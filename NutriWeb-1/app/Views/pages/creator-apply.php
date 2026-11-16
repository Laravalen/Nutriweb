<section class="auth-box" style="max-width: 680px;">
    <span class="badge badge-exclusive">CURADORIA PROFISSIONAL NUTRIWEB</span>
    <h2>Torne-se um Chef ou Restaurante Parceiro</h2>
    <p class="muted">Para garantir segurança alimentar e exclusividade, exigimos comprovação profissional ou alvará sanitário ativo.</p>

    <?php if ($existing): ?>
        <div class="alert alert-success">
            Status atual da sua solicitação (<strong><?= e($existing['business_name']) ?></strong>):
            <strong><?= strtoupper(e($existing['status'])) ?></strong>
        </div>
    <?php endif; ?>

    <form method="POST" action="/quero-ser-criador" class="form-stack">
        <label>Nome do Restaurante ou Marca Gastronômica
            <input type="text" name="business_name" required placeholder="Ex.: Osteria Mansur">
        </label>
        <label>Especialidade Culinária
            <input type="text" name="specialty" required placeholder="Ex.: Cozinha Italiana Artesanal">
        </label>
        <label>CNPJ (Obrigatório para Restaurantes)
            <input type="text" name="cnpj" placeholder="00.000.000/0001-00">
        </label>
        <label>Número do Alvará Sanitário (Obrigatório para venda de Kits)
            <input type="text" name="alvara_number" placeholder="ALV-2026-000">
        </label>
        <label>Registro de Diploma Gastronômico (Opcional se possuir CNPJ + Alvará)
            <input type="text" name="diploma_code" placeholder="Ex.: IGP-2020-123">
        </label>
        <label>Raio máximo de entrega refrigerada dos Kits (km)
            <input type="number" name="delivery_radius_km" value="15" min="1" max="50" required>
        </label>
        <label class="checkbox-row">
            <input type="checkbox" name="sanitary_terms" value="1" required>
            <span>Declaro cumprir todas as normas da Vigilância Sanitária (RDC 216 ANVISA) para manipulação, embalagem a vácuo e transporte refrigerado dos Kits Mise en Place.</span>
        </label>
        <button type="submit" class="btn btn-primary">Enviar para Curadoria</button>
    </form>
</section>