<?php
namespace App\Models;

use App\Core\Database;

class Kit {
    public static function allApproved(): array {
        return Database::getConnection()->query("
            SELECT k.*, r.title AS recipe_title, u.name AS chef_name, u.latitude AS rest_lat, u.longitude AS rest_lon,
                   cp.business_name, cp.delivery_radius_km, cp.sanitary_terms_accepted
            FROM kits k
            JOIN recipes r ON r.id = k.recipe_id
            JOIN users u ON u.id = k.creator_id
            JOIN creator_profiles cp ON cp.user_id = u.id
            WHERE cp.status = 'approved' AND cp.sanitary_terms_accepted = 1
            ORDER BY k.id DESC
        ")->fetchAll();
    }

    public static function find(int $id): ?array {$stmt = Database::getConnection()->prepare("
            SELECT k.*, u.latitude AS rest_lat, u.longitude AS rest_lon, cp.delivery_radius_km, cp.sanitary_terms_accepted
            FROM kits k
            JOIN users u ON u.id = k.creator_id
            JOIN creator_profiles cp ON cp.user_id = u.id
            WHERE k.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
}