<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\CreatorProfile;

class AdminController {
    public function dashboard(): void {
        $user = current_user();
        if (!$user || $user['role'] !== 'admin') {
            set_flash('error', 'Acesso restrito à equipe de curadoria NutriWeb.');
            redirect('/');
        }

        $profiles = CreatorProfile::allWithUsers();
        View::render('pages/admin', compact('profiles'));
    }

    public function approveCreator(int $id): void {
        $user = current_user();
        if (!$user || $user['role'] !== 'admin') {
            redirect('/');
        }

        CreatorProfile::approve($id, (int)$user['id']);
        set_flash('success', 'Criador aprovado e selo de conformidade ativado!');
        redirect('/admin');
    }

    public function rejectCreator(int $id): void {
        $user = current_user();
        if (!$user || $user['role'] !== 'admin') {
            redirect('/');
        }

        CreatorProfile::reject($id, (int)$user['id']);
        set_flash('error', 'Solicitação reprovada.');
        redirect('/admin');
    }
}