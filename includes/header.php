<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base_url = 'http://' . $_SERVER['HTTP_HOST'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patinhas Felizes - O Melhor Petshop</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/style.css">
</head>
<body>

    <nav class="navbar">
        <a href="<?php echo $base_url; ?>/index.php" class="navbar-brand">🐾 Patinhas Felizes</a>
        
        <div class="navbar-menu">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                
                <?php if ($_SESSION['perfil'] === 'admin'): ?>
                    <!-- Links do ADMIN -->
                    <a href="<?php echo $base_url; ?>/admin/dashboard.php">Dashboard Admin</a>
                    <a href="<?php echo $base_url; ?>/admin/agendamentos.php">Gerenciar Agendamentos</a>
                    <a href="<?php echo $base_url; ?>/admin/servicos/index.php">Serviços</a>
                    <a href="<?php echo $base_url; ?>/admin/usuarios.php">Clientes/Tutores</a>
                <?php else: ?>
                    <!-- Links do TUTOR (Cliente) -->
                    <a href="<?php echo $base_url; ?>/dashboard.php">Meu Dashboard</a>
                    <a href="<?php echo $base_url; ?>/pets/index.php">Meus Pets</a>
                    <a href="<?php echo $base_url; ?>/agendamentos/create.php">Novo Agendamento</a>
                <?php endif; ?>
                
                <span class="navbar-user">Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
                <a href="<?php echo $base_url; ?>/logout.php" class="btn btn-small btn-outline-light">Sair</a>
            
            <?php else: ?>
                <!-- Links deslogados -->
                <a href="<?php echo $base_url; ?>/index.php">Entrar</a>
                <a href="<?php echo $base_url; ?>/cadastro.php" class="btn btn-small btn-outline-light">Criar Conta</a>
            <?php endif; ?>
        </div>
    </nav>
