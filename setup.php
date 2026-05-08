<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cria o banco de dados
    $sql = "CREATE DATABASE IF NOT EXISTS petshop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdo->exec($sql);
    $pdo->exec("USE petshop_db");

    // Limpa tabelas antigas para uma instalação limpa
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("DROP TABLE IF EXISTS agendamentos, pets, servicos, usuarios, clientes");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    // 1. Tabela de Usuários (Admins e Tutores)
    $sqlUsuarios = "
        CREATE TABLE usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            senha_hash VARCHAR(255) NOT NULL,
            telefone VARCHAR(20),
            perfil ENUM('tutor', 'admin') DEFAULT 'tutor',
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $pdo->exec($sqlUsuarios);

    // Cria o Administrador Padrão
    $senhaAdmin = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT INTO usuarios (nome, email, senha_hash, telefone, perfil) VALUES ('Administrador Geral', 'admin@patinhas.com', '$senhaAdmin', '000000000', 'admin')");

    // 2. Tabela de Pets (Ligada ao Tutor)
    $sqlPets = "
        CREATE TABLE pets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT NOT NULL,
            nome VARCHAR(100) NOT NULL,
            especie VARCHAR(50) NOT NULL,
            raca VARCHAR(50),
            data_nascimento DATE,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
        )
    ";
    $pdo->exec($sqlPets);

    // 3. Tabela de Serviços
    $sqlServicos = "
        CREATE TABLE servicos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            preco DECIMAL(10,2) NOT NULL,
            duracao_minutos INT NOT NULL
        )
    ";
    $pdo->exec($sqlServicos);

    // Insere Serviços Básicos Padrão
    $pdo->exec("INSERT INTO servicos (nome, preco, duracao_minutos) VALUES 
        ('Banho Simples', 50.00, 30),
        ('Banho e Tosa', 90.00, 60),
        ('Consulta Veterinária', 150.00, 45)
    ");

    // 4. Tabela de Agendamentos
    $sqlAgendamentos = "
        CREATE TABLE agendamentos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT NOT NULL,
            pet_id INT NOT NULL,
            servico_id INT NOT NULL,
            data_hora DATETIME NOT NULL,
            status ENUM('Pendente', 'Concluído', 'Cancelado') DEFAULT 'Pendente',
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
            FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE,
            FOREIGN KEY (servico_id) REFERENCES servicos(id) ON DELETE CASCADE
        )
    ";
    $pdo->exec($sqlAgendamentos);

    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h2 style='color: green;'>Banco de Dados configurado com sucesso!</h2>";
    echo "<p>Usuário Admin padrão criado:</p>";
    echo "<b>Email:</b> admin@patinhas.com<br>";
    echo "<b>Senha:</b> admin123<br><br>";
    echo "<a href='index.php' style='padding: 10px 20px; background: #8b1c31; color: white; text-decoration: none; border-radius: 5px;'>Ir para a Tela de Login</a>";
    echo "</div>";

} catch (\PDOException $e) {
    echo "Erro na configuração: " . $e->getMessage();
}
?>