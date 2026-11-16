<section class="auth-box" style="max-width: 720px;">
    <span class="badge badge-exclusive">ÁREA DO CRIADOR VERIFICADO</span>
    <h2>Publicar Nova Receita Exclusiva</h2>
    <p class="muted">Estabelecimento: <strong><?= e($profile['business_name']) ?></strong> (Raio de entrega: <?= (int)$profile['delivery_radius_km'] ?> km)</p>

    <form method="POST" action="/nova-receita" class="form-stack">
        <label>Título do Prato
            <input type="text" name="title" required placeholder="Ex.: Risoto de Camarão Rosa com Limão Siciliano">
        </label>
        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:12px;">
            <label>Categoria
                <select name="category">
                    <option value="Brasileira">Brasileira</option>
                    <option value="Italiana">Italiana</option>
                    <option value="Asiática">Asiática</option>
                    <option value="Vegetariana">Vegetariana</option>
                </select>
            </label>
            <label>Restrição Alimentar
                <select name="dietary_restriction">
                    <option value="Todas as dietas">Todas as dietas</option>
                    <option value="Vegetariana">Vegetariana</option>
                    <option value="Sem glúten">Sem glúten</option>
                    <option value="Sem lactose">Sem lactose</option>
                </select>
            </label>
            <label>Dificuldade
                <select name="difficulty">
                    <option value="Fácil">Fácil</option>
                    <option value="Intermediário">Intermediário</option>
                    <option value="Avançado">Avançado</option>
                </select>
            </label>
        </div>
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
            <label>Tempo de preparo (minutos)
                <input type="number" name="prep_time_minutes" value="40" min="5" required>
            </label>
            <label>Preço da Receita Avulsa (R$)
                <input type="number" step="0.01" name="price" value="29.90" required>
            </label>
        </div>
        <label>Descrição curta
            <textarea name="description" rows="2" required></textarea>
        </label>
        <label>Ingredientes porcionados (um por linha)
            <textarea name="ingredients" rows="5" required placeholder="200g de arroz arbóreo&#10;150g de camarão limpo"></textarea>
        </label>
        <label>Modo de preparo passo a passo
            <textarea name="steps" rows="5" required></textarea>
        </label>
        <label>Dica de Aproveitamento Integral (Zero Desperdício)
            <input type="text" name="zero_waste_tip" placeholder="Ex.: Use as cascas do camarão para fazer o fumet do cozimento.">
        </label>
        <label class="checkbox-row">
            <input type="checkbox" name="create_kit" value="1" checked>
            <span>Disponibilizar também o <strong>Kit Mise en Place</strong> fresco para entrega local</span>
        </label>
        <label>Preço do Kit Mise en Place para 2 pessoas (R$)
            <input type="number" step="0.01" name="kit_price" value="79.90">
        </label>
        <button type="submit" class="btn btn-primary">Publicar Receita e Ativar Proteção DRM</button>
    </form>
</section>