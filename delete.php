<?php
// delete.php - Lógica para excluir um pet (Refatorado para POO)

require_once 'classes/Pet.php';

// Verifica se recebeu um ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Instancia o Model e chama o método deletar()
    $petModel = new Pet();
    $petModel->deletar($id);
}

// Redireciona de volta para a lista após deletar
header("Location: index.php");
exit;
?>
