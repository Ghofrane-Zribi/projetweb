 <?php

class Database {
    private static $host = 'localhost';
    private static $dbname = 'db_projet';
    private static $username = 'root';
    private static $password = '';

    public static function getConnection() {
        try {
            $connexion = new PDO(
                'mysql:host=' . self::$host . ';dbname=' . self::$dbname . ';charset=utf8',
                self::$username,
                self::$password
            );
            
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            return $connexion;

        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
}


?>
