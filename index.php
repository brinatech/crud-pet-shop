<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    if ($_SESSION['perfil'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: dashboard.php");
    }
    exit;
}

require_once 'classes/Usuario.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (!empty($email) && !empty($senha)) {
        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->autenticar($email, $senha);

        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['perfil'] = $usuario['perfil'];
            
            if ($usuario['perfil'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            $erro = "E-mail ou senha incorretos.";
        }
    } else {
        $erro = "Preencha todos os campos.";
    }
}

$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include 'includes/header.php';
?>

<div class="auth-container">
    <h2>Acesse sua Conta</h2>
    <p>Bem-vindo ao Petshop Patinhas Felizes!</p>
    
    <?php if ($erro): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 20px;">
            <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required placeholder="Digite seu e-mail">
        </div>
        
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required placeholder="Digite sua senha">
        </div>

        <button type="submit" class="btn" style="width: 100%; margin-top: 10px;">Entrar</button>
    </form>

    <div class="auth-links">
        <p>Ainda não é cliente? <a href="cadastro.php">Cadastre-se aqui</a></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
