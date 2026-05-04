<?php

require_once 'classes/Pet.php';

if (!isset($_GET['id'])) {
    die("ID não fornecido. <a href='index.php'>Voltar</a>");
}

$id = $_GET['id'];
$petModel = new Pet();

// Se o formulário foi enviado (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $raca = $_POST['raca'];
    $idade = $_POST['idade'];

    // Usa o método atualizar() da classe Pet
    if ($petModel->atualizar($id, $nome, $especie, $raca, $idade)) {
        header("Location: index.php");
        exit;
    } else {
        $erro = "Erro ao atualizar pet.";
    }
}

// Se for um acesso (GET), busca os dados atuais usando o método da classe Pet
$petAtual = $petModel->buscarPorId($id);

if (!$petAtual) {
    die("Pet não encontrado. <a href='index.php'>Voltar</a>");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Pet</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Pet: <?php echo htmlspecialchars($petAtual['nome']); ?></h1>
        
        <?php if (isset($erro)): ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form method="POST" action="edit.php?id=<?php echo $petAtual['id']; ?>">
            <div class="form-group">
                <label for="nome">Nome do Pet</label>
                <input type="text" id="nome" name="nome" required value="<?php echo htmlspecialchars($petAtual['nome']); ?>">
            </div>
            
            <div class="form-group">
                <label for="especie">Espécie</label>
                <input type="text" id="especie" name="especie" required value="<?php echo htmlspecialchars($petAtual['especie']); ?>">
            </div>

            <div class="form-group">
                <label for="raca">Raça</label>
                <input type="text" id="raca" name="raca" value="<?php echo htmlspecialchars($petAtual['raca']); ?>">
            </div>

            <div class="form-group">
                <label for="idade">Idade (em anos)</label>
                <input type="number" id="idade" name="idade" required min="0" value="<?php echo $petAtual['idade']; ?>">
            </div>

            <div class="actions">
                <button type="submit" class="btn">Atualizar Pet</button>
                <a href="index.php" class="btn" style="background-color: #95a5a6;">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
