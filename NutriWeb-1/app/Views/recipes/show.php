<?php $user = current_user(); ?>
<article class="recipe-detail">
    <div class="recipe-header">
        <span class="badge badge-exclusive"><?= e($recipe['category']) ?></span>
        <span class="badge badge-sanitary"><?= e($recipe['dietary_restriction']) ?></span>
        <h1><?= e($recipe['title']) ?></h1>
        <p class="muted">Por <strong><?= e($recipe['chef_name']) ?></strong> · <?= e($recipe['business_name'] ?? 'Chef Oficial') ?> · ⏱ <?= (int)$recipe['prep_time_minutes'] ?> min</p>
        <p><?= e($recipe['description']) ?></p>
    </div>

    <?php if ($hasAccess): ?>
        <section class="protected-media">
            <div class="watermark-overlay">
                LICENCIADO PARA: <?= e(strtoupper($user['name'] ?? 'ASSINANTE')) ?> (<?= e($user['email'] ?? '') ?>) · TOKEN <?= e($recipe['video_stream_token']) ?>
            </div>
            <h3>🎬 Videoaula Técnica Exclusiva (Streaming Protegido)</h3>
            <p>Reproduzindo aula passo a passo em 4K com marca d'água dinâmica anti-pirataria.</p>
            <div class="video-placeholder">▶ Aula em execução — Segredos de emulsão e finalização do Chef <?= e($recipe['chef_name']) ?></div>
        </section>

        <div class="recipe-columns">
            <section class="card">
                <h3>Ingredientes Porcionados</h3>
                <pre class="recipe-text"><?= e($recipe['ingredients']) ?></pre>
                <?php if (!empty($recipe['zero_waste_tip'])): ?>
                    <div class="alert alert-success">
                        <strong>🌱 Aproveitamento Integral (Zero Desperdício):</strong> <?= e($recipe['zero_waste_tip']) ?>
                    </div>
                <?php endif; ?>
            </section>

            <section class="card protected-media" style="background: var(--bg-card); color: var(--espresso);">
                <div class="watermark-overlay" style="color: rgba(142, 40, 11, 0.09);">
                    CÓPIA RASTREÁVEL · <?= e($user['email'] ?? '') ?>
                </div>
                <h3>Modo de Preparo Detalhado</h3>
                <pre class="recipe-text"><?= e($recipe['steps']) ?></pre>
            </section>
        </div>
    <?php else: ?>
        <section class="paywall-box">
            <h3>Conteúdo Exclusivo Protegido</h3>
            <p>Desbloqueie a videoaula completa e a ficha técnica com marca d'água pessoal.</p>
            <div class="hero-actions">
                <form method="POST" action="/receita/<?= (int)$recipe['id'] ?>/desbloquear">
                    <button type="submit" class="btn btn-primary">Comprar Receita Avulsa (R$ <?= number_format((float)$recipe['price