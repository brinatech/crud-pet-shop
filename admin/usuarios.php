<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'admin') { header("Location: ../index.php"); exit; }

require_once '../classes/Conexao.php';
$pdo = Conexao::getConn();

// Busca tutores e agrupa os pets de cada um usando GROUP_CONCAT
$sql = "
    SELECT 
        u.id, u.nome, u.email, u.telefone, u.criado_em,
        GROUP_CONCAT(CONCAT(p.nome, ' (', p.especie, ')') SEPARATOR ', ') as pets_lista
    FROM usuarios u
    LEFT JOIN pets p ON u.id = p.usuario_id
    WHERE u.perfil = 'tutor'
    GROUP BY u.id
    ORDER BY u.nome ASC
";
$tutores = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include '../includes/header.php';
?>
<div class="container">
    <h2>Clientes / Tutores Cadastrados</h2>
    <p>Lista de todos os usuários clientes e seus respectivos animais.</p>
    
    <table>
        <thead>
            <tr>
                <th>Nome do Tutor</th>
                <th>Contato</th>
                <th>Pets Vinculados</th>
                <th>Data de Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tutores as $tutor): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($tutor['nome']); ?></strong></td>
                    <td>
                        <?php echo htmlspecialchars($tutor['email']); ?><br>
                        <small><?php echo htmlspecialchars($tutor['telefone']); ?></small>
                    </td>
                    <td>
                        <?php echo !empty($tutor['pets_lista']) ? htmlspecialchars($tutor['pets_lista']) : '<span style="color:#999; font-style:italic;">Nenhum pet</span>'; ?>
                    </td>
                    <td><?php echo date('d/m/Y', strtotime($tutor['criado_em'])); ?></td>
                    <td>
                        <a href="usuarios_delete.php?id=<?php echo $tutor['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Deseja excluir este cliente? Todos os seus pets e agendamentos serão removidos.');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; if(empty($tutores)): ?>
                <tr><td colspan="5" class="empty-state">Nenhum cliente cadastrado ainda.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
