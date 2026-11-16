<?php $user = current_user(); $flash = get_flash(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriWeb — Alta Gastronomia e Kits Mise en Place</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <header class="navbar">
        <div class="container">
            <a href="/" class="brand">
                <img src="/assets/img/nutriweb-logo.png" alt="NutriWeb" onerror="this.style.display='none'">
                <span>NutriWeb</span>
            </a>
            <nav class="nav-links">
                <a href="/">Receitas</a>
                <a href="/kits">Kits Mise en Place</a>
                <a href="/quero-ser-criador">Para Chefs e Restaurantes</a>
                <?php if ($user && $user['role'] === 'creator'): ?>
                    <a href="/nova-receita" class="badge badge-exclusive">+ Publicar Receita</a>
                <?php endif; ?>
                <?php if ($user && $user['role'] === 'admin'): ?>
                    <a href="/admin" class="badge badge-sanitary">Painel Curadoria</a>
                <?php endif; ?>
            </nav>
            <div class="nav-actions">
                <?php if ($user): ?>
                    <span class="user-pill"><?= e($user['name']) ?> <?= $user['is_subscriber'] ? '★ Clube' : '' ?></span>
                    <a href="/logout" class="btn btn-outline">Sair</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-outline">Entrar</a>
                    <a href="/register" class="btn btn-primary">Criar Conta</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="container">
        <?php if ($flash): ?>
            <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
        <?php endif; ?>
        <?= $content ?>
    </main>

    <footer>
        <div class="container footer-grid">
            <div>
                <h3>NutriWeb</h3>
                <p>Receitas exclusivas com curadoria profissional e insumos frescos porcionados na medida certa.</p>
            </div>
            <div>
                <strong>Conformidade & Qualidade</strong>
                <p>Curadoria com validação de CNPJ/Alvará e entrega refrigerada restrita por raio local.</p>
            </div>
        </div>
    </footer>
    <script src="/assets/js/app.js"></script>
</body>
</html>