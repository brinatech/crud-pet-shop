<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}

require_once 'classes/Usuario.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $senha = $_POST['senha'];

    if (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        if (!empty($nome) && !empty($email) && !empty($senha)) {
            $usuarioModel = new Usuario();
            
            if ($usuarioModel->salvar($nome, $email, $senha, $telefone)) {
                $sucesso = "Cadastro realizado com sucesso! Você já pode fazer login.";
            } else {
                $erro = "Este e-mail já está cadastrado.";
            }
        } else {
            $erro = "Preencha todos os campos obrigatórios (*).";
        }
    }
}

$base_url = 'http://' . $_SERVER['HTTP_HOST'];
include 'includes/header.php';
?>

<div class="auth-container">
    <h2>Criar Conta</h2>
    <p>Cadastre-se para agendar os serviços para o seu pet!</p>

    <?php if ($erro): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 20px;">
            <?php echo $erro; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($sucesso): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 6px; margin-bottom: 20px;">
            <?php echo $sucesso; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="cadastro.php">
        <div class="form-group">
            <label for="nome">Nome Completo *</label>
            <input type="text" id="nome" name="nome" required placeholder="Seu nome completo">
        </div>
        
        <div class="form-group">
            <label for="email">E-mail *</label>
            <input type="email" id="email" name="email" required placeholder="seu@email.com">
        </div>

        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" placeholder="(11) 99999-9999">
        </div>
        
        <div class="form-group">
            <label for="senha">Senha *</label>
            <input type="password" id="senha" name="senha" required placeholder="Crie uma senha segura" minlength="6">
        </div>

        <button type="submit" class="btn" style="width: 100%; margin-top: 10px;">Cadastrar</button>
    </form>

    <div class="auth-links">
        <p>Já tem uma conta? <a href="index.php">Faça login</a></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
