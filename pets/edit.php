<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) { header("Location: index.php"); exit; }

require_once '../classes/Pet.php';
$petModel = new Pet();
$pet = $petModel->buscarPorId($_GET['id'], $_SESSION['usuario_id']);
if (!$pet) { die("Pet não encontrado."); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data_nascimento = !empty($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null;
    $petModel->atualizar($pet['id'], $_SESSION['usuario_id'], $_POST['nome'], $_POST['especie'], $_POST['raca'], $data_nascimento);
    header("Location: index.php"); exit;
}
$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include '../includes/header.php';
?>
<div class="container">
    <h2>Editar Pet</h2>
    <form method="POST">
        <div class="form-group"><label>Nome *</label><input type="text" name="nome" value="<?php echo htmlspecialchars($pet['nome']); ?>" required></div>
        <div class="form-group"><label>Espécie *</label><input type="text" name="especie" value="<?php echo htmlspecialchars($pet['especie']); ?>" required></div>
        <div class="form-group"><label>Raça</label><input type="text" name="raca" value="<?php echo htmlspecialchars($pet['raca']); ?>"></div>
        <div class="form-group"><label>Data de Nascimento</label><input type="date" name="data_nascimento" value="<?php echo $pet['data_nascimento']; ?>" max="<?php echo date('Y-m-d'); ?>"></div>
        <button type="submit" class="btn">Atualizar</button>
        <a href="index.php" class="btn" style="background:#666;">Cancelar</a>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
