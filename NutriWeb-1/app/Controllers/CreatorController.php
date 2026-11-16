<?php
namespace App\Controllers;

use App\Core\Database;
use App\Core\View;
use App\Models\CreatorProfile;

class CreatorController {
    public function applyForm(): void {
        $user = current_user();
        if (!$user) {
            set_flash('error', 'Faça login para solicitar seu perfil profissional.');
            redirect('/login');
        }

        $existing = CreatorProfile::findByUserId((int)$user['id']);
        View::render('pages/creator-apply', compact('existing'));
    }

    public function submitApplication(): void {
        $user = current_user();
        if (!$user) {
            redirect('/login');
        }

        $businessName = trim($_POST['business_name'] ?? '');
        $specialty    = trim($_POST['specialty'] ?? '');
        $cnpj         = trim($_POST['cnpj'] ?? '');
        $alvara       = trim($_POST['alvara_number'] ?? '');
        $diploma      = trim($_POST['diploma_code'] ?? '');
        $radius       = max(1, min(50, (int)($_POST['delivery_radius_km'] ?? 15)));
        $sanitary     = isset($_POST['sanitary_terms']) ? 1 : 0;

        $hasCredentials = !empty($diploma) || (!empty($cnpj) && !empty($alvara));
        if (!$hasCredentials || !$sanitary) {
            set_flash('error', 'Informe formação gastronômica comprovada OU CNPJ + Alvará ativo e aceite os termos sanitários.');
            redirect('/quero-ser-criador');
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            REPLACE INTO creator_profiles
            (user_id, business_name, specialty, cnpj, alvara_number, diploma_code, sanitary_terms_accepted, delivery_radius_km, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
        ");
        $stmt->execute([$user['id'], $businessName, $specialty, $cnpj, $alvara, $diploma, $sanitary, $radius]);

        set_flash('success', 'Credenciais enviadas! A curadoria NutriWeb analisará seus documentos.');
        redirect('/quero-ser-criador');
    }
}