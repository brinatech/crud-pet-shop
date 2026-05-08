<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'admin' || !isset($_GET['id'])) { header("Location: ../../index.php"); exit; }
require_once '../../classes/Servico.php';

$servicoModel = new Servico();
$servico = $servicoModel->buscarPorId($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servicoModel->atualizar($_GET['id'], $_POST['nome'], $_POST['preco'], $_POST['duracao_minutos']);
    header("Location: index.php"); exit;
}
$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include '../../includes/header.php';
?>
<div class="container">
    <h2>Editar Serviço</h2>
    <form method="POST">
        <div class="form-group"><label>Nome</label><input type="text" name="nome" value="<?php echo htmlspecialchars($servico['nome']); ?>" required></div>
        <div class="form-group"><label>Preço (R$)</label><input type="number" name="preco" step="0.01" value="<?php echo $servico['preco']; ?>" required></div>
        <div class="form-group"><label>Duração (minutos)</label><input type="number" name="duracao_minutos" value="<?php echo $servico['duracao_minutos']; ?>" required></div>
        <button type="submit" class="btn">Atualizar</button>
        <a href="index.php" class="btn" style="background:#666;">Cancelar</a>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>
