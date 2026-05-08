<?php
require_once __DIR__ . '/Conexao.php';

class Servico {
    private $pdo;
    public function __construct() { $this->pdo = Conexao::getConn(); }

    public function listarTodos() {
        return $this->pdo->query("SELECT * FROM servicos ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM servicos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function salvar($nome, $preco, $duracao) {
        $stmt = $this->pdo->prepare("INSERT INTO servicos (nome, preco, duracao_minutos) VALUES (?, ?, ?)");
        return $stmt->execute([$nome, $preco, $duracao]);
    }
    public function atualizar($id, $nome, $preco, $duracao) {
        $stmt = $this->pdo->prepare("UPDATE servicos SET nome = ?, preco = ?, duracao_minutos = ? WHERE id = ?");
        return $stmt->execute([$nome, $preco, $duracao, $id]);
    }
    public function deletar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM servicos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
