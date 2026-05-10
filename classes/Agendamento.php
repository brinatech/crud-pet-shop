<?php
require_once __DIR__ . '/Conexao.php';

class Agendamento {
    private $pdo;
    public function __construct() { $this->pdo = Conexao::getConn(); }

    // Para o Tutor marcar o agendamento
    public function salvar($usuario_id, $pet_id, $servico_id, $data_hora) {
        $sql = "INSERT INTO agendamentos (usuario_id, pet_id, servico_id, data_hora, status) 
                VALUES (:usuario_id, :pet_id, :servico_id, :data_hora, 'Pendente')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['usuario_id' => $usuario_id, 'pet_id' => $pet_id, 'servico_id' => $servico_id, 'data_hora' => $data_hora]);
    }

    // Para o Admin ver todos os agendamentos da loja
    public function listarTodosAdmin() {
        $sql = "SELECT a.*, u.nome as tutor_nome, u.telefone, p.nome as pet_nome, s.nome as servico_nome, s.preco 
                FROM agendamentos a
                JOIN usuarios u ON a.usuario_id = u.id
                JOIN pets p ON a.pet_id = p.id
                JOIN servicos s ON a.servico_id = s.id
                ORDER BY a.data_hora DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Para o Tutor ver os próprios agendamentos
    public function listarPorTutor($usuario_id) {
        $sql = "SELECT a.*, p.nome as pet_nome, s.nome as servico_nome, s.preco 
                FROM agendamentos a
                JOIN pets p ON a.pet_id = p.id
                JOIN servicos s ON a.servico_id = s.id
                WHERE a.usuario_id = ?
                ORDER BY a.data_hora ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Para o Admin mudar o status
    public function atualizarStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE agendamentos SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    // Para o Tutor deletar o próprio agendamento
    public function deletar($id, $usuario_id) {
        $sql = "DELETE FROM agendamentos WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'usuario_id' => $usuario_id]);
    }

    // Para o Admin deletar qualquer agendamento
    public function deletarAdmin($id) {
        $sql = "DELETE FROM agendamentos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>
