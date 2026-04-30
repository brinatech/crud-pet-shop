<?php
// setup.php - Script para facilitar a criação do banco de dados e tabela

$host = '127.0.0.1';
$user = 'root';
$pass = ''; // Senha vazia padrão do XAMPP

try {
    // Conecta sem selecionar o banco, pois vamos criá-lo
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cria o banco de dados petshop_db se ele não existir
    $sql = "CREATE DATABASE IF NOT EXISTS petshop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdo->exec($sql);
    echo "Banco de dados 'petshop_db' criado ou já existente.<br>";

    // Seleciona o banco de dados
    $pdo->exec("USE petshop_db");

    // Cria a tabela pets se ela não existir
    $sqlTable = "
        CREATE TABLE IF NOT EXISTS pets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            especie VARCHAR(50) NOT NULL,
            raca VARCHAR(50),
            idade INT,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $pdo->exec($sqlTable);
    echo "Tabela 'pets' criada ou já existente.<br>";

    echo "<br><b>Configuração concluída com sucesso!</b> <a href='index.php'>Ir para a Tela Inicial</a>";

} catch (\PDOException $e) {
    echo "Erro na configuração: " . $e->getMessage();
}
?>
