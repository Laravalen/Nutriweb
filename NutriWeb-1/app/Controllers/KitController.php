<?php
namespace App\Controllers;

use App\Core\Database;
use App\Core\View;
use App\Models\Kit;

class KitController {
    public function index(): void {
        $user = current_user();
        $locations = [
            'Joinville, SC' => [-26.3044, -48.8487],
            'Curitiba, PR'  => [-25.4284, -49.2733],
            'São Paulo, SP' => [-23.5505, -46.6333],
        ];

        $selectedCity = $_GET['city'] ?? ($user['city'] ?? 'Joinville, SC');
        [$userLat, $userLon] = $locations[$selectedCity] ?? [-26.3044, -48.8487];

        $kits = Kit::allApproved();
        foreach ($kits as &$kit) {
            $dist = calculate_distance_km($userLat, $userLon, (float)$kit['rest_lat'], (float)$kit['rest_lon']);
            $kit['distance_km'] = $dist;
            $kit['within_radius'] = $dist <= (int)$kit['delivery_radius_km'];
        }

        View::render('pages/kits', compact('kits', 'selectedCity', 'locations'));
    }

    public function order(): void {
        $user = current_user();
        if (!$user) {
            set_flash('error', 'Entre na sua conta para pedir um Kit Mise en Place.');
            redirect('/login');
        }

        $kitId = (int)($_POST['kit_id'] ?? 0);
        $kit = Kit::find($kitId);

        if (!$kit || !$kit['sanitary_terms_accepted']) {
            set_flash('error', 'Kit indisponível ou sem certificação sanitária.');
            redirect('/kits');
        }

        $distance = calculate_distance_km((float)$user['latitude'], (float)$user['longitude'], (float)$kit['rest_lat'], (float)$kit['rest_lon']);
        if ($distance > (int)$kit['delivery_radius_km']) {
            set_flash('error', "Bloqueio logístico: Você está a {$distance} km (raio máximo de {$kit['delivery_radius_km']} km para manter insumos frescos).");
            redirect('/kits');
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO kit_orders (kit_id, user_id, distance_km, total_price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$kitId, $user['id'], $distance, $kit['price']]);

        set_flash('success', "Pedido do '{$kit['title']}' confirmado! Entrega refrigerada ({$distance} km) em andamento.");
        redirect('/kits');
    }
}