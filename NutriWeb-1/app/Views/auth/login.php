<section class="auth-box">
    <h2>Entrar no NutriWeb</h2>
    <p class="muted">Acesse suas receitas exclusivas, o Clube e seus pedidos de Kits.</p>
    <form method="POST" action="/login" class="form-stack">
        <label>E-mail
            <input type="email" name="email" required placeholder="seu@email.com">
        </label>
        <label>Senha
            <input type="password" name="password" required placeholder="••••••">
        </label>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
    <div class="demo-accounts">
        <strong>Contas rápidas de teste (senha: 123456):</strong>
        <ul>
            <li>Admin Curadoria: <code>admin@nutriweb.com.br</code></li>
            <li>Chef Aprovada: <code>helena@osteriamansur.com.br</code></li>
            <li>Cliente Joinville (Kit liberado): <code>mariana@gmail.com</code></li>
            <li>Cliente Curitiba (Kit bloqueado por km): <code>rafael@gmail.com</code></li>
        </ul>
    </div>
</section>