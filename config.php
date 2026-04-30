<?php
// config.php - Responsável pela conexão com o banco de dados

$host = '127.0.0.1';
$db   = 'petshop_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Se o banco não existir, exibe um link para o setup
    if ($e->getCode() == 1049) {
        die("Banco de dados não encontrado. <a href='setup.php'>Clique aqui para rodar o Setup e criar o banco.</a>");
    }
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}
?>
