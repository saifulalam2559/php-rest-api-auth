<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class User
{
    public static function create($email, $password)
    {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        return $stmt->execute([$email, password_hash($password, PASSWORD_BCRYPT)]);
    }

    public static function findByEmail($email)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findById($id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT id, email FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
