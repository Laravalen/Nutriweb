<?php $user = current_user(); ?>
<section class="hero">
    <div>
        <span class="badge badge-exclusive">CURADORIA GASTRONÔMICA OFICIAL</span>
        <h1>Domine pratos de assinatura com insumos frescos na medida certa.</h1>
        <p>Receitas inéditas de chefs e restaurantes verificados, videoaulas protegidas e kits mise en place sem desperdício.</p>
        <div class="hero-actions">
            <a href="#catalogo" class="btn btn-primary">Explorar Receitas</a>
            <?php if (!$user || !$user['is_subscriber']): ?>
                <form method="POST" action="/assinar-clube" style="display:inline;">
                    <button type="submit" class="btn btn-terracotta">Assinar Clube (R$ 39,90/mês)</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="catalogo" class="filter-bar">
    <form method="GET" action="/" class="filter-grid">
        <input type="text" name="q" value="<?= e($filters['q']) ?>" placeholder="Buscar prato ou chef...">
        <select name="category">
            <?php foreach (['Todas', 'Brasileira', 'Italiana', 'Asiática', 'Vegetariana'] as $cat): ?>
                <option value="<?= $cat ?>" <?= $filters['category'] === $cat ? 'selected' : '' ?>><?= $cat ?></option>
            <?php endforeach; ?>
        </select>
        <select name="diet">
            <?php foreach (['Todas as dietas', 'Vegetariana', 'Sem glúten', 'Sem lactose'] as $diet): ?>
                <option value="<?= $diet ?>" <?= $filters['diet'] === $diet ? 'selected' : '' ?>><?= $diet ?></option>
            <?php endforeach; ?>
        </select>
        <select name="difficulty">
            <?php foreach (['Qualquer nível', 'Fácil', 'Intermediário', 'Avançado'] as $dif): ?>
                <option value="<?= $dif ?>" <?= $filters['difficulty'] === $dif ? 'selected' : '' ?>><?= $dif ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
</section>

<section class="grid-cards">
    <?php foreach ($recipes as $r): ?>
        <article class="card">
            <div>
                <div class="card-meta">
                    <span class="badge badge-exclusive"><?= e($r['category']) ?></span>
                    <span class="badge badge-sanitary"><?= e($r['dietary_restriction']) ?></span>
                </div>
                <h3><?= e($r['title']) ?></h3>
                <p class="muted">Por <strong><?= e($r['chef_name']) ?></strong> · <?= e($r['business_name'] ?? 'Chef Verificado') ?></p>
                <p><?= e($r['description']) ?></p>
            </div>
            <div class="card-footer">
                <div class="specs">
                    <span>⏱ <?= (int)$r['prep_time_minutes'] ?> min</span>
                    <span>📊 <?= e($r['difficulty']) ?></span>
                    <span>⭐ <?= e((string)$r['rating']) ?></span>
                </div>
                <a href="/receita/<?= (int)$r['id'] ?>" class="btn btn-terracotta">
                    Ver Receita (R$ <?= number_format((float)$r['price'], 2, ',', '.') ?>)
                </a>
            </div>
        </article>
    <?php endforeach; ?>
</section>