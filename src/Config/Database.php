<?php
namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private static $conn;

    public static function connect()
    {
        if (!self::$conn) {
            try {
                $host = getenv('DB_HOST');
                $db   = getenv('DB_NAME');
                $user = getenv('DB_USER');
                $pass = getenv('DB_PASS');

                self::$conn = new PDO(
                    "mysql:host=$host;dbname=$db;charset=utf8mb4",
                    $user,
                    $pass,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die('DB Connection failed');
            }
        }

        return self::$conn;
    }
}
