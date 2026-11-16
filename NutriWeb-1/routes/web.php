<?php
use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\RecipeController;
use App\Controllers\KitController;
use App\Controllers\CreatorController;
use App\Controllers\AdminController;

$router = new Router();

// Vitrine Principal e Filtros
$router->get('/', [HomeController::class, 'index']);

// Autenticação e Assinatura Clube NutriWeb
$router->get('/login', [AuthController::class, 'loginForm']);$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'registerForm']);$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);$router->post('/assinar-clube', [AuthController::class, 'subscribeClub']);

// Receitas, Videoaulas e Comunidade
$router->get('/receita/{id}', [RecipeController::class, 'show']);
$router->post('/receita/{id}/desbloquear', [RecipeController::class, 'unlock']);$router->post('/receita/{id}/comunidade', [RecipeController::class, 'addPost']);
$router->get('/nova-receita', [RecipeController::class, 'createForm']);$router->post('/nova-receita', [RecipeController::class, 'store']);

// Kits Mise en Place (Validação de Raio km)
$router->get('/kits', [KitController::class, 'index']);$router->post('/kits/pedir', [KitController::class, 'order']);

// Curadoria Profissional (Chefs e Restaurantes)
$router->get('/quero-ser-criador', [CreatorController::class, 'applyForm']);$router->post('/quero-ser-criador', [CreatorController::class, 'submitApplication']);

// Painel Administrativo de Curadoria
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->post('/admin/aprovar/{id}', [AdminController::class, 'approveCreator']);$router->post('/admin/reprovar/{id}', [AdminController::class, 'rejectCreator']);

return $router;