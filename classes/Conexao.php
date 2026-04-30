<?php
// classes/Conexao.php - Padrão Singleton para o Banco de Dados

class Conexao {
    // Variável estática que vai guardar a nossa única instância da conexão
    private static $instance;

    public static function getConn() {
        // Verificação se já existe uma instância, caso NÃO exista ele cria a conexão
        if (!isset(self::$instance)) {
            $host = '127.0.0.1';
            $db   = 'petshop_db';
            $user = 'root';
            $pass = '';

            try {
                // Cria a conexão (igual a imagem do professor, mas com os dados do nosso banco)
                self::$instance = new \PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
                
                // Configurações de erro do PDO para facilitar debug
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                if ($e->getCode() == 1049) {
                    die("Banco de dados não encontrado. <a href='setup.php'>Clique aqui para rodar o Setup e criar o banco.</a>");
                }
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        
        // Se a conexão já existia (ou acabou de ser criada), ele apenas a retorna reaproveitada
        return self::$instance;
    }
}
?>
