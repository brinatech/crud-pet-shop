<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'admin' || !isset($_GET['id'])) { header("Location: ../../index.php"); exit; }
require_once '../../classes/Servico.php';
$servicoModel = new Servico();
$servicoModel->deletar($_GET['id']);
header("Location: index.php");
exit;
?>
