<?php
// create.php - Lógica e formulário para criar um novo pet (Refatorado para POO)

require_once 'config.php';
require_once 'classes/Pet.php';

// Se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta as variáveis
    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $raca = $_POST['raca'];
    $idade = $_POST['idade'];

    // Instancia o Model
    $petModel = new Pet($pdo);

    // Usa o método salvar() da classe Pet
    if ($petModel->salvar($nome, $especie, $raca, $idade)) {
        header("Location: index.php");
        exit;
    } else {
        $erro = "Erro ao cadastrar pet.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Pet</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar Novo Pet</h1>
        
        <?php if (isset($erro)): ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form method="POST" action="create.php">
            <div class="form-group">
                <label for="nome">Nome do Pet</label>
                <input type="text" id="nome" name="nome" required placeholder="Ex: Rex">
            </div>
            
            <div class="form-group">
                <label for="especie">Espécie</label>
                <input type="text" id="especie" name="especie" required placeholder="Ex: Cachorro, Gato">
            </div>

            <div class="form-group">
                <label for="raca">Raça</label>
                <input type="text" id="raca" name="raca" placeholder="Ex: Poodle (Opcional)">
            </div>

            <div class="form-group">
                <label for="idade">Idade (em anos)</label>
                <input type="number" id="idade" name="idade" required min="0" placeholder="Ex: 3">
            </div>

            <div class="actions">
                <button type="submit" class="btn">Salvar Pet</button>
                <a href="index.php" class="btn" style="background-color: #95a5a6;">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
