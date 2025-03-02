<?php

class Config {
    private static $host = 'localhost';
    private static $dbname = 'db_projet';
    private static $username = 'root';
    private static $password = '';

    public static function getConnexion() {
        try {
            $connexion = new PDO(
                'mysql:host=' . self::$host . ';dbname=' . self::$dbname,
                self::$username,
                self::$password
            );
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connexion;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
?>
