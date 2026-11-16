<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;

class AuthController {
    public function loginForm(): void {
        View::render('auth/login');
    }

    public function login(): void {
        $email = trim($_POST['email'] ?? '');
        $password =$_POST['password'] ?? '';

        $user = User::findByEmail($email);
        if (!$user || !password_verify($password,$user['password'])) {
            set_flash('error', 'E-mail ou senha inválidos.');
            redirect('/login');
        }

        $_SESSION['user'] =$user;
        set_flash('success', "Bem-vindo(a) de volta, {$user['name']}!");
        redirect('/');
    }

    public function registerForm(): void {
        View::render('auth/register');
    }

    public function register(): void {
        $cities = [
            'Joinville, SC' => [-26.3044, -48.8487],
            'Curitiba, PR'  => [-25.4284, -49.2733],
            'São Paulo, SP' => [-23.5505, -46.6333],
        ];
        $city =$_POST['city'] ?? 'Joinville, SC';
        [$lat,$lon] = $cities[$city] ?? [-26.3044, -48.8487];

        $email = trim($_POST['email'] ?? '');
        if (User::findByEmail($email)) {
            set_flash('error', 'Este e-mail já está cadastrado.');
            redirect('/register');
        }

        $id = User::create([
            'name'      => trim($_POST['name'] ?? ''),
            'email'     => $email,
            'password'  => $_POST['password'] ?? '123456', 'city'      =>$city,
            'latitude'  => $lat,
            'longitude' => $lon,
        ]);

        $_SESSION['user'] = User::findById($id);
        set_flash('success', 'Conta criada com sucesso!');
        redirect('/');
    }

    public function logout(): void {
        session_destroy();
        header('Location: /');
        exit;
    }

    public function subscribeClub(): void {
        $user = current_user();
        if (!$user) {
            set_flash('error', 'Faça login para assinar o Clube NutriWeb.');
            redirect('/login');
        }

        User::activateClub((int)$user['id']);
        $_SESSION['user'] = User::findById((int)$user['id']);
        set_flash('success', 'Assinatura Clube NutriWeb ativada! Todas as receitas exclusivas foram liberadas.');
        redirect('/');
    }
}