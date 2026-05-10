<?php
require_once __DIR__ . '/Conexao.php';

class Usuario {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getConn();
    }

    public function salvar($nome, $email, $senha, $telefone) {
        // Verifica se email já existe
        $stmt = $this->pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            return false; // Email já cadastrado
        }

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (nome, email, senha_hash, telefone, perfil) VALUES (:nome, :email, :senha_hash, :telefone, 'tutor')";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            'nome' => $nome,
            'email' => $email,
            'senha_hash' => $senha_hash,
            'telefone' => $telefone
        ]);
    }

    public function autenticar($email, $senha) {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            return $usuario;
        }

        return false;
    }

    public function atualizar($id, $nome, $email, $telefone) {
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nome' => $nome,
            'email' => $email,
            'telefone' => $telefone,
            'id' => $id
        ]);
    }

    public function deletar($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>
