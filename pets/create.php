<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'tutor') {
    header("Location: ../index.php"); exit;
}
require_once '../classes/Pet.php';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $especie = trim($_POST['especie']);
    $raca = trim($_POST['raca']);
    $data_nascimento = !empty($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null;

    if (!empty($nome) && !empty($especie)) {
        $petModel = new Pet();
        if ($petModel->salvar($_SESSION['usuario_id'], $nome, $especie, $raca, $data_nascimento)) {
            header("Location: index.php"); exit;
        } else {
            $erro = "Erro ao cadastrar.";
        }
    } else {
        $erro = "Preencha Nome e Espécie.";
    }
}
$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include '../includes/header.php';
?>
<div class="container">
    <h2>Cadastrar Novo Pet</h2>
    <?php if ($erro): ?><div style="color:red; margin-bottom: 20px;"><?php echo $erro; ?></div><?php endif; ?>
    <form method="POST">
        <div class="form-group"><label>Nome *</label><input type="text" name="nome" required></div>
        <div class="form-group"><label>Espécie *</label><input type="text" name="especie" required></div>
        <div class="form-group"><label>Raça</label><input type="text" name="raca"></div>
        <div class="form-group"><label>Data de Nascimento</label><input type="date" name="data_nascimento" max="<?php echo date('Y-m-d'); ?>"></div>
        <button type="submit" class="btn">Cadastrar</button>
        <a href="index.php" class="btn" style="background:#666;">Cancelar</a>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
