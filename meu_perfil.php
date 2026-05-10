<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'tutor') {
    header("Location: index.php"); exit;
}
require_once 'classes/Usuario.php';
$usuarioModel = new Usuario();
$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);

    if (!empty($nome) && !empty($email)) {
        if ($usuarioModel->atualizar($_SESSION['usuario_id'], $nome, $email, $telefone)) {
            $_SESSION['usuario_nome'] = $nome; // Atualiza nome na sessão
            $sucesso = "Perfil atualizado com sucesso!";
        } else {
            $erro = "Erro ao atualizar perfil. O e-mail pode já estar em uso.";
        }
    } else {
        $erro = "Preencha os campos obrigatórios (*).";
    }
}

// Busca dados atuais do usuário (Poderia vir da sessão, mas buscar no banco garante dados frescos)
require_once 'classes/Conexao.php';
$pdo = Conexao::getConn();
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$u = $stmt->fetch(PDO::FETCH_ASSOC);

$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/crud-pet-shop';
include 'includes/header.php';
?>

<div class="container">
    <h2>Meu Perfil</h2>
    <p>Mantenha seus dados de contato sempre atualizados.</p>

    <?php if ($erro): ?><div style="color:red; margin-bottom: 20px;"><?php echo $erro; ?></div><?php endif; ?>
    <?php if ($sucesso): ?><div style="color:green; margin-bottom: 20px;"><?php echo $sucesso; ?></div><?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Nome Completo *</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($u['nome']); ?>" required>
        </div>
        <div class="form-group">
            <label>E-mail *</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($u['email']); ?>" required>
        </div>
        <div class="form-group">
            <label>Telefone</label>
            <input type="text" name="telefone" value="<?php echo htmlspecialchars($u['telefone']); ?>">
        </div>
        <button type="submit" class="btn">Salvar Alterações</button>
        <a href="dashboard.php" class="btn" style="background:#666;">Voltar</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
