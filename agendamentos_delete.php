<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: index.php"); exit;
}
require_once 'classes/Agendamento.php';
$agendamentoModel = new Agendamento();
$agendamentoModel->deletar($_GET['id'], $_SESSION['usuario_id']);
header("Location: dashboard.php");
exit;
