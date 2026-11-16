<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\Recipe;

class HomeController {
    public function index(): void {
        $filters = [
            'q'          => trim($_GET['q'] ?? ''),
            'category'   => $_GET['category'] ?? 'Todas',
            'diet'       => $_GET['diet'] ?? 'Todas as dietas',
            'difficulty' => $_GET['difficulty'] ?? 'Qualquer nível',
            'max_time'   => $_GET['max_time'] ?? '',
        ];

        $recipes = Recipe::filter($filters);
        View::render('pages/home', compact('recipes', 'filters'));
    }
}