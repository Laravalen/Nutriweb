<?php
namespace App\Models;

use App\Core\Database;

class User {
    public static function findByEmail(string $email): ?array {$stmt = Database::getConnection()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public static function findById(int $id): ?array {$stmt = Database::getConnection()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data): int {$pdo = Database::getConnection();
        $stmt =$pdo->prepare("
            INSERT INTO users (name, email, password, city, latitude, longitude)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['name'],$data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),$data['city'],
            $data['latitude'],$data['longitude']
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function activateClub(int $userId): void {$stmt = Database::getConnection()->prepare("UPDATE users SET is_subscriber = 1 WHERE id = ?");
        $stmt->execute([$userId]);
    }
}