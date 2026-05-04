<?php

require_once 'Conexao.php'; 

class Pet {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getConn();
    }

    // (Read)
    public function listarTodos() {
        $sql = "SELECT * FROM pets ORDER BY id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna um array com todos os pets
    }

    // Buscar um único pet pelo ID
        public function buscarPorId($id) {
        $sql = "SELECT * FROM pets WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna apenas 1 pet
    }

    // (Create)
    public function salvar($nome, $especie, $raca, $idade) {
        $sql = "INSERT INTO pets (nome, especie, raca, idade) VALUES (:nome, :especie, :raca, :idade)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['nome' => $nome, 'especie' => $especie, 'raca' => $raca, 'idade' => $idade]); // Retorna true se inseriu com sucesso
    }

    // (Update)
    public function atualizar($id, $nome, $especie, $raca, $idade) {
        $sql = "UPDATE pets SET nome = :nome, especie = :especie, raca = :raca, idade = :idade WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute(['id' => $id,'nome' => $nome, 'especie' => $especie, 'raca' => $raca, 'idade' => $idade]); // Retorna true se atualizou com sucesso
    }

    // (Delete)
    public function deletar($id) {
        $sql = "DELETE FROM pets WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute(['id' => $id]); // Retorna true se deletou com sucesso
    }
}
?>
