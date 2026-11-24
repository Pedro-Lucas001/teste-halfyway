<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — HalfyWay</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <main class="app-container" style="margin-top: 40px;">
    <div class="topbar" style="justify-content: center;">
      <div class="brand">Halfy<span>Way</span></div>
    </div>

    <section class="card">
      <h2 style="margin-bottom: 6px;">Continue usando o HalfyWay</h2>
      <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">
        Acesse sua conta de Candidato ou Empresa.
      </p>

      <form id="form-login" action="../controllers/AuthController.php" method="POST">
        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="seu@email.com" required>
        </div>

        <div class="form-group">
          <label for="senha">Senha</label>
          <input type="password" id="senha" name="senha" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" id="btn-entrar" class="btn btn-dark">Entrar</button>
      </form>

      <p style="text-align: center; margin-top: 16px; font-size: 0.85rem; color: var(--text-muted);">
        Não tem conta? <a href="cadastro.html" style="color: var(--primary-green); font-weight: 600;">Cadastre-se</a>
      </p>
    </section>
  </main>
</body>
</html>