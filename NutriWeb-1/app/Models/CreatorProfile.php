<?php
namespace App\Models;

use App\Core\Database;

class CreatorProfile {
    public static function findByUserId(int $userId): ?array {$stmt = Database::getConnection()->prepare("SELECT * FROM creator_profiles WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch() ?: null;
    }

    public static function allWithUsers(): array {
        return Database::getConnection()->query("
            SELECT cp.*, u.name, u.email, u.city
            FROM creator_profiles cp
            JOIN users u ON u.id = cp.user_id
            ORDER BY FIELD(cp.status, 'pending', 'approved', 'rejected'), cp.created_at DESC
        ")->fetchAll();
    }

    public static function approve(int $profileId, int $adminId): void {$pdo = Database::getConnection();
        $stmt =$pdo->prepare("UPDATE creator_profiles SET status = 'approved', reviewed_by = ? WHERE id = ?");
        $stmt->execute([$adminId,$profileId]);

        $userStmt =$pdo->prepare("UPDATE users u JOIN creator_profiles cp ON cp.user_id = u.id SET u.role = 'creator' WHERE cp.id = ?");
        $userStmt->execute([$profileId]);
    }

    public static function reject(int $profileId, int $adminId): void {$stmt = Database::getConnection()->prepare("UPDATE creator_profiles SET status = 'rejected', reviewed_by = ? WHERE id = ?");
        $stmt->execute([$adminId,$profileId]);
    }
}