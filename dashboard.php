<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'tutor') {
    header("Location: index.php");
    exit;
}

require_once 'classes/Pet.php';
require_once 'classes/Agendamento.php';

$usuario_id = $_SESSION['usuario_id'];

$petModel = new Pet();
$meus_pets = $petModel->listarPorTutor($usuario_id);

$agendamentoModel = new Agendamento();
$meus_agendamentos = $agendamentoModel->listarPorTutor($usuario_id);

$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include 'includes/header.php';
?>

<div class="container">
    <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
    <p>Aqui você pode gerenciar seus pets e agendar os melhores serviços para eles.</p>

    <div class="dashboard-grid">
        <div class="card">
            <h3>Meus Pets</h3>
            <p class="card-content">Você tem <strong><?php echo count($meus_pets); ?></strong> pet(s) cadastrado(s).</p>
            <a href="pets/index.php" class="btn">Gerenciar Pets</a>
        </div>
        
        <div class="card">
            <h3>Agendamentos</h3>
            <p class="card-content">Veja os próximos horários marcados ou agende um novo.</p>
            <a href="agendamentos/create.php" class="btn">Agendar Novo Serviço</a>
        </div>
    </div>

    <h2 style="margin-top: 40px; text-align: left;">Meus Agendamentos</h2>
    <table>
        <thead>
            <tr>
                <th>Data / Hora</th>
                <th>Pet</th>
                <th>Serviço</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($meus_agendamentos) > 0): ?>
                <?php foreach ($meus_agendamentos as $ag): ?>
                    <tr>
                        <td><?php echo date('d/m/Y H:i', strtotime($ag['data_hora'])); ?></td>
                        <td><?php echo htmlspecialchars($ag['pet_nome']); ?></td>
                        <td><?php echo htmlspecialchars($ag['servico_nome']); ?></td>
                        <td>R$ <?php echo number_format($ag['preco'], 2, ',', '.'); ?></td>
                        <td>
                            <?php 
                                $badgeClass = strtolower($ag['status']);
                                if ($badgeClass == 'concluído') $badgeClass = 'concluido';
                            ?>
                            <span class="badge badge-<?php echo $badgeClass; ?>"><?php echo $ag['status']; ?></span>
                        </td>
                        <td>
                            <a href="agendamentos_delete.php?id=<?php echo $ag['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Deseja cancelar e excluir este agendamento?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty-state">Você ainda não possui agendamentos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
