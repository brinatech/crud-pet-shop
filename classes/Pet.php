<?php
require_once __DIR__ . '/Conexao.php';

class Pet {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getConn();
    }

    public function salvar($usuario_id, $nome, $especie, $raca, $data_nascimento) {
        $sql = "INSERT INTO pets (usuario_id, nome, especie, raca, data_nascimento) VALUES (:usuario_id, :nome, :especie, :raca, :data_nascimento)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'usuario_id' => $usuario_id,
            'nome' => $nome,
            'especie' => $especie,
            'raca' => $raca,
            'data_nascimento' => $data_nascimento
        ]);
    }

    public function listarPorTutor($usuario_id) {
        $sql = "SELECT * FROM pets WHERE usuario_id = :usuario_id ORDER BY nome ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id, $usuario_id) {
        $sql = "SELECT * FROM pets WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'usuario_id' => $usuario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $usuario_id, $nome, $especie, $raca, $data_nascimento) {
        $sql = "UPDATE pets SET nome = :nome, especie = :especie, raca = :raca, data_nascimento = :data_nascimento WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nome' => $nome,
            'especie' => $especie,
            'raca' => $raca,
            'data_nascimento' => $data_nascimento,
            'id' => $id,
            'usuario_id' => $usuario_id
        ]);
    }

    public function deletar($id, $usuario_id) {
        $sql = "DELETE FROM pets WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'usuario_id' => $usuario_id]);
    }
}
?>
