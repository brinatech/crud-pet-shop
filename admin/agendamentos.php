<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'admin') {
    header("Location: ../index.php"); exit;
}
require_once '../classes/Agendamento.php';
$agendamentoModel = new Agendamento();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $agendamentoModel->atualizarStatus($_POST['id'], $_POST['status']);
    header("Location: agendamentos.php"); exit;
}
$todos = $agendamentoModel->listarTodosAdmin();
$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include '../includes/header.php';
?>
<div class="container">
    <h2>Gerenciar Agendamentos</h2>
    <table>
        <thead><tr><th>Data/Hora</th><th>Tutor (Tel)</th><th>Pet</th><th>Serviço (R$)</th><th>Status Atual</th><th>Mudar Status</th></tr></thead>
        <tbody>
            <?php foreach ($todos as $ag): ?>
                <tr>
                    <td><?php echo date('d/m/Y H:i', strtotime($ag['data_hora'])); ?></td>
                    <td><?php echo htmlspecialchars($ag['tutor_nome']); ?><br><small><?php echo htmlspecialchars($ag['telefone']); ?></small></td>
                    <td><?php echo htmlspecialchars($ag['pet_nome']); ?></td>
                    <td><?php echo htmlspecialchars($ag['servico_nome']); ?></td>
                    <td><span class="badge badge-<?php echo strtolower($ag['status'] == 'Concluído' ? 'concluido' : $ag['status']); ?>"><?php echo $ag['status']; ?></span></td>
                    <td>
                        <form method="POST" style="display:flex; gap:10px;">
                            <input type="hidden" name="id" value="<?php echo $ag['id']; ?>">
                            <select name="status">
                                <option value="Pendente" <?php echo $ag['status'] == 'Pendente'?'selected':''; ?>>Pendente</option>
                                <option value="Concluído" <?php echo $ag['status'] == 'Concluído'?'selected':''; ?>>Concluído</option>
                                <option value="Cancelado" <?php echo $ag['status'] == 'Cancelado'?'selected':''; ?>>Cancelado</option>
                            </select>
                            <button class="btn btn-small">Salvar</button>
                        </form>
                        <a href="agendamentos_delete.php?id=<?php echo $ag['id']; ?>" class="btn btn-small btn-danger" style="margin-top:5px; display:inline-block;" onclick="return confirm('Excluir este agendamento do histórico?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; if(empty($todos)): ?>
                <tr><td colspan="6" class="empty-state">Nenhum agendamento.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
