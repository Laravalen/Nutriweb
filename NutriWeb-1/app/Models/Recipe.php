<?php
namespace App\Models;

use App\Core\Database;

class Recipe {
    public static function filter(array $filters): array {$sql = "
            SELECT r.*, u.name AS chef_name, cp.business_name
            FROM recipes r
            JOIN users u ON u.id = r.creator_id
            LEFT JOIN creator_profiles cp ON cp.user_id = u.id
            WHERE 1=1
        ";
        $params = [];

        if (!empty($filters['q'])) {$sql .= " AND (r.title LIKE ? OR r.description LIKE ? OR u.name LIKE ?)";
            $term = '\%' .$filters['q'] . '%';
            $params[] =$term;
            $params[] =$term;
            $params[] =$term;
        }
        if (!empty($filters['category']) && $filters['category'] !== 'Todas') {$sql .= " AND r.category = ?";
            $params[] =$filters['category'];
        }
        if (!empty($filters['diet']) && $filters['diet'] !== 'Todas as dietas') {$sql .= " AND r.dietary_restriction = ?";
            $params[] =$filters['diet'];
        }
        if (!empty($filters['difficulty']) &&$filters['difficulty'] !== 'Qualquer nível') {
            $sql .= " AND r.difficulty = ?";
            $params[] =$filters['difficulty'];
        }
        if (!empty($filters['max_time'])) {$sql .= " AND r.prep_time_minutes <= ?";
            $params[] = (int)$filters['max_time'];
        }

        $sql .= " ORDER BY r.created_at DESC";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array {$stmt = Database::getConnection()->prepare("
            SELECT r.*, u.name AS chef_name, cp.business_name, cp.specialty
            FROM recipes r
            JOIN users u ON u.id = r.creator_id
            LEFT JOIN creator_profiles cp ON cp.user_id = u.id
            WHERE r.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data): int {$pdo = Database::getConnection();
        $stmt =$pdo->prepare("
            INSERT INTO recipes (creator_id, title, category, dietary_restriction, difficulty, prep_time_minutes, price, included_in_club, description, ingredients, steps, zero_waste_tip, video_stream_token)
            VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$data['creator_id'],
            $data['title'],$data['category'],
            $data['dietary_restriction'],$data['difficulty'],
            $data['prep_time_minutes'],$data['price'],
            $data['description'],$data['ingredients'],
            $data['steps'],$data['zero_waste_tip'],
            'NW-DRM-' . strtoupper(bin2hex(random_bytes(4)))
        ]);
        return (int)$pdo->lastInsertId();
    }
}