<section class="auth-box">
    <h2>Criar Conta no NutriWeb</h2>
    <form method="POST" action="/register" class="form-stack">
        <label>Nome completo
            <input type="text" name="name" required>
        </label>
        <label>E-mail
            <input type="email" name="email" required>
        </label>
        <label>Sua cidade (define o raio de entrega dos Kits)
            <select name="city">
                <option value="Joinville, SC">Joinville, SC</option>
                <option value="Curitiba, PR">Curitiba, PR</option>
                <option value="São Paulo, SP">São Paulo, SP</option>
            </select>
        </label>
        <label>Senha
            <input type="password" name="password" required minlength="6">
        </label>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</section>