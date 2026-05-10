<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'admin' || !isset($_GET['id'])) {
    header("Location: ../index.php"); exit;
}
require_once '../classes/Usuario.php';
$usuarioModel = new Usuario();
$usuarioModel->deletar($_GET['id']);
header("Location: usuarios.php");
exit;
