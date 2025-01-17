<?php
require_once(__DIR__ . '/../config/init.php');

class DBConnect
{
    private static $pdo;

    public static function getPDO()
    {
        if (!self::$pdo) {

            try {
                self::$pdo = new PDO($_ENV['DSN'], $_ENV['LOGIN'], $_ENV['PASSWORD']);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                
            } catch (\Throwable $e) {
                echo "Impossible de se connecter à la base de données. Veuillez vérifier vos paramètres de connexion.";
                error_log("Erreur de connexion PDO : " . $e->getMessage());
                die;
            }
        }
        return self::$pdo;
    }
}
