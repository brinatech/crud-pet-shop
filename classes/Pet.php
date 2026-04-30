<?php
// classes/Pet.php - O nosso "Model" na arquitetura POO

require_once 'Conexao.php'; // Inclui a classe Singleton

class Pet {
    private $pdo;

    // O construtor não precisa mais receber $pdo da tela (index.php)
    // Ele mesmo vai lá no Singleton e "puxa" a conexão
    public function __construct() {
        $this->pdo = Conexao::getConn();
    }

    // Método para listar todos os pets (Read)
    public function listarTodos() {
        $sql = "SELECT * FROM pets ORDER BY id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna um array com todos os pets
    }

    // Método para buscar um único pet pelo ID
    public function buscarPorId($id) {
        $sql = "SELECT * FROM pets WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna apenas 1 pet
    }

    // Método para salvar um novo pet (Create)
    public function salvar($nome, $especie, $raca, $idade) {
        $sql = "INSERT INTO pets (nome, especie, raca, idade) VALUES (:nome, :especie, :raca, :idade)";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':especie', $especie);
        $stmt->bindParam(':raca', $raca);
        $stmt->bindParam(':idade', $idade, PDO::PARAM_INT);
        
        return $stmt->execute(); // Retorna true se inseriu com sucesso
    }

    // Método para atualizar um pet existente (Update)
    public function atualizar($id, $nome, $especie, $raca, $idade) {
        $sql = "UPDATE pets SET nome = :nome, especie = :especie, raca = :raca, idade = :idade WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':especie', $especie);
        $stmt->bindParam(':raca', $raca);
        $stmt->bindParam(':idade', $idade, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute(); // Retorna true se atualizou com sucesso
    }

    // Método para deletar um pet (Delete)
    public function deletar($id) {
        $sql = "DELETE FROM pets WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute(); // Retorna true se deletou com sucesso
    }
}
?>
