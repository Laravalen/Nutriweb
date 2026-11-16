<section>
    <h2>Painel de Curadoria Profissional</h2>
    <p class="muted">Aprove ou reprove solicitações de chefs e restaurantes verificando CNPJ, Alvará Sanitário e Diploma.</p>

    <table class="data-table">
        <thead>
            <tr>
                <th>Profissional / Estabelecimento</th>
                <th>Credenciais</th>
                <th>Raio Kit</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($profiles as $p): ?>
                <tr>
                    <td>
                        <strong><?= e($p['business_name']) ?></strong><br>
                        <small><?= e($p['name']) ?> (<?= e($p['city']) ?>)</small>
                    </td>
                    <td>
                        CNPJ: <?= e($p['cnpj'] ?: '—') ?><br>
                        Alvará: <?= e($p['alvara_number'] ?: '—') ?><br>
                        Diploma: <?= e($p['diploma_code'] ?: '—') ?>
                    </td>
                    <td><?= (int)$p['delivery_radius_km'] ?> km</td>
                    <td><span class="badge badge-exclusive"><?= strtoupper(e($p['status'])) ?></span></td>
                    <td>
                        <?php if ($p['status'] === 'pending'): ?>
                            <form method="POST" action="/admin/aprovar/<?= (int)$p['id'] ?>" style="display:inline;">
                                <button type="submit" class="btn btn-primary">Aprovar</button>
                            </form>
                            <form method="POST" action="/admin/reprovar/<?= (int)$p['id'] ?>" style="display:inline;">
                                <button type="submit" class="btn btn-outline">Reprovar</button>
                            </form>
                        <?php else: ?>
                            <span>Revisado</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>