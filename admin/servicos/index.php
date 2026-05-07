<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'admin') { header("Location: ../../index.php"); exit; }
require_once '../../classes/Servico.php';
$servicoModel = new Servico();
$servicos = $servicoModel->listarTodos();

$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include '../../includes/header.php';
?>
<div class="container">
    <h2>Catálogo de Serviços</h2>
    <a href="create.php" class="btn" style="margin-bottom: 20px;">Adicionar Novo Serviço</a>
    <table>
        <thead><tr><th>Nome</th><th>Preço</th><th>Duração (min)</th><th>Ações</th></tr></thead>
        <tbody>
            <?php foreach ($servicos as $s): ?>
                <tr>
                    <td><?php echo htmlspecialchars($s['nome']); ?></td>
                    <td>R$ <?php echo number_format($s['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo $s['duracao_minutos']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $s['id']; ?>" class="btn btn-small">Editar</a>
                        <a href="delete.php?id=<?php echo $s['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Apagar serviço?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; if(empty($servicos)): ?>
                <tr><td colspan="4" class="empty-state">Nenhum serviço cadastrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include '../../includes/footer.php'; ?>
