<?php
// index.php - Tela inicial: lista os pets (Refatorado para POO)

// 1. Instanciar o objeto Pet (ele já puxa a conexão do Singleton sozinho)
$petModel = new Pet();

// 2. Usar o método da classe para buscar os pets
$pets = $petModel->listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Petshop CRUD (POO)</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de Petshop (POO)</h1>
        
        <a href="create.php" class="btn">Adicionar Novo Pet</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Espécie</th>
                    <th>Raça</th>
                    <th>Idade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($pets) > 0): ?>
                    <?php foreach ($pets as $pet): ?>
                        <tr>
                            <td><?php echo $pet['id']; ?></td>
                            <td><?php echo htmlspecialchars($pet['nome']); ?></td>
                            <td><?php echo htmlspecialchars($pet['especie']); ?></td>
                            <td><?php echo htmlspecialchars($pet['raca']); ?></td>
                            <td><?php echo $pet['idade']; ?> anos</td>
                            <td>
                                <a href="edit.php?id=<?php echo $pet['id']; ?>" class="btn btn-small">Editar</a>
                                <a href="delete.php?id=<?php echo $pet['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Tem certeza que deseja deletar este pet?');">Deletar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty-state">Nenhum pet cadastrado. Adicione um novo!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
