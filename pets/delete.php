<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) { header("Location: index.php"); exit; }

require_once '../classes/Pet.php';
$petModel = new Pet();
$petModel->deletar($_GET['id'], $_SESSION['usuario_id']);
header("Location: index.php");
exit;
?>
