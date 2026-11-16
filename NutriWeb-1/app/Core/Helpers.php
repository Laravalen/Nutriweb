<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}

function set_flash(string $type, string $message): void {$_SESSION['flash'] = ['type' => $type, 'message' =>$message];
}

function get_flash(): ?array {
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash =$_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function redirect(string $path): void {
    header("Location: {$path}");
    exit;
}

function calculate_distance_km(float $lat1, float $lon1, float$lat2, float $lon2): float {$earthRadius = 6371;
    $dLat = deg2rad($lat2 -$lat1);
    $dLon = deg2rad($lon2 - $lon1);$a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);$c = 2 * atan2(sqrt($a), sqrt(1 -$a));
    return round($earthRadius * $c, 1);
}