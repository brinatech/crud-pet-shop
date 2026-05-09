<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'admin') { header("Location: ../../index.php"); exit; }
require_once '../../classes/Servico.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preco = floatval($_POST['preco']);
    $duracao = intval($_POST['duracao_minutos']);

    if ($preco <= 0 || $duracao <= 0) {
        echo "<script>alert('O preço e a duração devem ser maiores que zero!'); window.history.back();</script>";
        exit;
    }

    $servicoModel = new Servico();
    $servicoModel->salvar($_POST['nome'], $preco, $duracao);
    header("Location: index.php"); exit;
}
$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include '../../includes/header.php';
?>
<div class="container">
    <h2>Adicionar Serviço</h2>
    <form method="POST">
        <div class="form-group"><label>Nome</label><input type="text" name="nome" required></div>
        <div class="form-group"><label>Preço (R$)</label><input type="number" name="preco" step="0.01" min="0.01" required></div>
        <div class="form-group"><label>Duração (minutos)</label><input type="number" name="duracao_minutos" min="1" required></div>
        <button type="submit" class="btn">Salvar Serviço</button>
        <a href="index.php" class="btn" style="background:#666;">Cancelar</a>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>
