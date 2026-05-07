<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'tutor') {
    header("Location: ../index.php"); exit;
}

require_once '../classes/Pet.php';
require_once '../classes/Servico.php';
require_once '../classes/Agendamento.php';

$petModel = new Pet();
$servicoModel = new Servico();
$agendamentoModel = new Agendamento();

$pets = $petModel->listarPorTutor($_SESSION['usuario_id']);
$servicos = $servicoModel->listarTodos();
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pet_id = (int)$_POST['pet_id'];
    $servico_id = (int)$_POST['servico_id'];
    $data_hora = $_POST['data_hora'];

    if ($pet_id && $servico_id && !empty($data_hora)) {
        $hoje = date('Y-m-d\TH:i');
        if ($data_hora < $hoje) {
            $erro = "Não é permitido agendar horários no passado.";
        } else {
            if ($agendamentoModel->salvar($_SESSION['usuario_id'], $pet_id, $servico_id, $data_hora)) {
                header("Location: ../dashboard.php"); exit;
            } else { $erro = "Erro ao agendar."; }
        }
    } else { $erro = "Preencha tudo."; }
}
$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include '../includes/header.php';
?>
<div class="container">
    <h2>Agendar Serviço</h2>
    <?php if ($erro): ?><div style="color:red; margin-bottom: 20px;"><?php echo $erro; ?></div><?php endif; ?>
    
    <?php if(empty($pets)): ?>
        <p>Você precisa cadastrar um pet primeiro.</p>
        <a href="../pets/create.php" class="btn">Cadastrar Pet</a>
    <?php else: ?>
        <form method="POST">
            <div class="form-group">
                <label>Selecione o Pet *</label>
                <select name="pet_id" required>
                    <option value="">-- Selecione --</option>
                    <?php foreach($pets as $pet): ?>
                        <option value="<?php echo $pet['id']; ?>"><?php echo htmlspecialchars($pet['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Selecione o Serviço *</label>
                <select name="servico_id" required>
                    <option value="">-- Selecione --</option>
                    <?php foreach($servicos as $s): ?>
                        <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['nome']); ?> - R$ <?php echo number_format($s['preco'], 2, ',', '.'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Data e Hora *</label>
                <input type="datetime-local" name="data_hora" min="<?php echo date('Y-m-d\TH:i'); ?>" required>
            </div>
            <button type="submit" class="btn">Confirmar Agendamento</button>
            <a href="../dashboard.php" class="btn" style="background:#666;">Cancelar</a>
        </form>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
