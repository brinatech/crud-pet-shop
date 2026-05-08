<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'tutor') {
    header("Location: ../index.php"); exit;
}

require_once '../classes/Pet.php';
$petModel = new Pet();
$pets = $petModel->listarPorTutor($_SESSION['usuario_id']);

$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include '../includes/header.php';
?>

<div class="container">
    <h2>Meus Pets</h2>
    <a href="create.php" class="btn" style="margin-bottom: 20px;">Adicionar Novo Pet</a>
    <table>
        <thead><tr><th>Nome</th><th>Espécie</th><th>Raça</th><th>Idade</th><th>Ações</th></tr></thead>
        <tbody>
            <?php if (count($pets) > 0): foreach ($pets as $pet): 
                $idadeTexto = "Não informada";
                if (!empty($pet['data_nascimento'])) {
                    $nascimento = new DateTime($pet['data_nascimento']);
                    $hoje = new DateTime();
                    $diferenca = $hoje->diff($nascimento);
                    if ($diferenca->y > 0) {
                        $idadeTexto = $diferenca->y . " ano(s)";
                    } elseif ($diferenca->m > 0) {
                        $idadeTexto = $diferenca->m . " mês(es)";
                    } else {
                        $idadeTexto = $diferenca->d . " dia(s)";
                    }
                }
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($pet['nome']); ?></td>
                    <td><?php echo htmlspecialchars($pet['especie']); ?></td>
                    <td><?php echo htmlspecialchars($pet['raca']); ?></td>
                    <td><?php echo $idadeTexto; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $pet['id']; ?>" class="btn btn-small">Editar</a>
                        <a href="delete.php?id=<?php echo $pet['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Excluir?');">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="5" class="empty-state">Nenhum pet cadastrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
