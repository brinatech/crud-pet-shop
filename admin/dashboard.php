<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'admin') {
    header("Location: ../index.php"); exit;
}
require_once '../classes/Agendamento.php';

$agendamentoModel = new Agendamento();
$todos = $agendamentoModel->listarTodosAdmin();
$pendentes = 0; $concluidos = 0; $receita = 0;

foreach ($todos as $ag) {
    if ($ag['status'] === 'Pendente') $pendentes++;
    if ($ag['status'] === 'Concluído') { $concluidos++; $receita += $ag['preco']; }
}

$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include '../includes/header.php';
?>
<div class="container">
    <h1>Painel de Administração</h1>
    <div class="dashboard-grid">
        <div class="card" style="border-left: 4px solid #f39c12;">
            <h3>Agendamentos Pendentes</h3>
            <p style="font-size: 32px; font-weight: bold; margin: 10px 0;"><?php echo $pendentes; ?></p>
            <a href="agendamentos.php" class="btn btn-small">Gerenciar</a>
        </div>
        <div class="card" style="border-left: 4px solid #2ecc71;">
            <h3>Serviços Concluídos</h3>
            <p style="font-size: 32px; font-weight: bold; margin: 10px 0;"><?php echo $concluidos; ?></p>
            <small>Receita: R$ <?php echo number_format($receita, 2, ',', '.'); ?></small>
        </div>
        <div class="card" style="border-left: 4px solid #3498db;">
            <h3>Serviços Oferecidos</h3>
            <p class="card-content">Edite banhos, tosas e preços.</p>
            <a href="servicos/index.php" class="btn btn-small">Acessar Catálogo</a>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
