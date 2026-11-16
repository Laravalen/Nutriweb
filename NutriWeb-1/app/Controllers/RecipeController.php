<?php
namespace App\Controllers;

use App\Core\Database;
use App\Core\View;
use App\Models\Recipe;
use App\Models\CreatorProfile;

class RecipeController {
    public function show(int $id): void {
        $recipe = Recipe::find($id);
        if (!$recipe) {
            http_response_code(404);
            echo "Receita não encontrada.";
            return;
        }

        $pdo = Database::getConnection();
        $user = current_user();
        $hasAccess = false;

        if ($user) {
            if ($user['role'] === 'admin' || (int)$user['id'] === (int)$recipe['creator_id'] || ($user['is_subscriber'] && $recipe['included_in_club'])) {
                $hasAccess = true;
            } else {
                $check = $pdo->prepare("SELECT id FROM recipe_purchases WHERE user_id = ? AND recipe_id = ?");
                $check->execute([$user['id'], $id]);
                $hasAccess = (bool)$check->fetch();
            }
        }

        $kitStmt = $pdo->prepare("SELECT * FROM kits WHERE recipe_id = ? LIMIT 1");
        $kitStmt->execute([$id]);
        $linkedKit = $kitStmt->fetch();

        $postsStmt = $pdo->prepare("
            SELECT p.*, u.name AS author_name
            FROM community_posts p
            JOIN users u ON u.id = p.user_id
            WHERE p.recipe_id = ?
            ORDER BY p.created_at DESC
        ");
        $postsStmt->execute([$id]);
        $posts = $postsStmt->fetchAll();

        View::render('recipes/show', compact('recipe', 'hasAccess', 'linkedKit', 'posts'));
    }

    public function unlock(int $id): void {
        $user = current_user();
        if (!$user) {
            set_flash('error', 'Entre na sua conta para desbloquear esta receita.');
            redirect('/login');
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT IGNORE INTO recipe_purchases (user_id, recipe_id) VALUES (?, ?)");
        $stmt->execute([$user['id'], $id]);

        set_flash('success', 'Receita e videoaula protegida desbloqueadas!');
        redirect("/receita/{$id}");
    }

    public function addPost(int $id): void {
        $user = current_user();
        if (!$user) {
            redirect('/login');
        }

        $type = ($_POST['type'] ?? 'result') === 'question' ? 'question' : 'result';
        $content = trim($_POST['content'] ?? '');
        $rating = max(1, min(5, (int)($_POST['rating'] ?? 5)));

        if ($content !== '') {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("INSERT INTO community_posts (recipe_id, user_id, type, content, rating) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$id, $user['id'], $type, $content, $rating]);
            set_flash('success', 'Comentário publicado na comunidade!');
        }
        redirect("/receita/{$id}");
    }

    public function createForm(): void {
        $user = current_user();
        if (!$user) {
            redirect('/login');
        }

        $profile = CreatorProfile::findByUserId((int)$user['id']);
        if (!$profile || $profile['status'] !== 'approved') {
            set_flash('error', 'Apenas chefs e restaurantes aprovados na curadoria podem publicar receitas pagas.');
            redirect('/quero-ser-criador');
        }

        View::render('recipes/create', compact('profile'));
    }

    public function store(): void {
        $user = current_user();
        if (!$user) {
            redirect('/login');
        }

        $profile = CreatorProfile::findByUserId((int)$user['id']);
        if (!$profile || $profile['status'] !== 'approved') {
            set_flash('error', 'Perfil profissional não aprovado.');
            redirect('/quero-ser-criador');
        }

        $recipeId = Recipe::create([
            'creator_id'          => $user['id'],
            'title'               => trim($_POST['title'] ?? ''),
            'category'            => $_POST['category'] ?? 'Brasileira',
            'dietary_restriction' => $_POST['dietary_restriction'] ?? 'Todas as dietas',
            'difficulty'          => $_POST['difficulty'] ?? 'Intermediário',
            'prep_time_minutes'   => (int)($_POST['prep_time_minutes'] ?? 40),
            'price'               => (float)($_POST['price'] ?? 29.90),
            'description'         => trim($_POST['description'] ?? ''),
            'ingredients'         => trim($_POST['ingredients'] ?? ''),
            'steps'               => trim($_POST['steps'] ?? ''),
            'zero_waste_tip'      => trim($_POST['zero_waste_tip'] ?? ''),
        ]);

        if (!empty($_POST['create_kit']) && $profile['sanitary_terms_accepted']) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("INSERT INTO kits (recipe_id, creator_id, title, servings, price, sanitary_certified) VALUES (?, ?, ?, 2, ?, 1)");
            $stmt->execute([
                $recipeId,
                $user['id'],
                'Kit Mise en Place: ' . trim($_POST['title']),
                (float)($_POST['kit_price'] ?? 75.00)
            ]);
        }

        set_flash('success', 'Receita exclusiva publicada com proteção de marca d\'água!');
        redirect("/receita/{$recipeId}");
    }
}