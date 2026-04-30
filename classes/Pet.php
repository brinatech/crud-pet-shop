<?php
// classes/Pet.php - O nosso "Model" na arquitetura POO

class Pet {
    private $pdo;

    // O construtor é chamado automaticamente quando fazemos: new Pet($pdo)
    // Ele recebe a conexão do banco de dados (config.php) para usar dentro da classe
    public function __construct($pdo) {
        $this->pdo = $pdo;
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
