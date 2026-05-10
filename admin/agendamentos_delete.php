<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'admin' || !isset($_GET['id'])) {
    header("Location: ../index.php"); exit;
}
require_once '../classes/Agendamento.php';
$agendamentoModel = new Agendamento();
$agendamentoModel->deletarAdmin($_GET['id']);
header("Location: agendamentos.php");
exit;
