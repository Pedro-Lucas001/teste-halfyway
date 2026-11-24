<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Triagem e Serviços — HalfyWay</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <main class="app-container">
    <header class="topbar">
      <div class="brand">Halfy<span>Way</span></div>
      <span class="badge-green">Painel de Triagem</span>
    </header>

    <!-- Métricas do Painel de Triagem -->
    <section class="stats-grid">
      <div class="stat-box"><strong>142</strong><span>Avaliados</span></div>
      <div class="stat-box"><strong>78%</strong><span>Aprovação</span></div>
      <div class="stat-box"><strong>45</strong><span>Agendados</span></div>
    </section>

    <!-- Formulário CRUD de Serviços -->
    <section class="card">
      <h3 style="margin-bottom: 14px;">Novo Serviço de Triagem</h3>
      <form id="form-servico" action="../controllers/ServicoController.php" method="POST">
        <input type="hidden" id="servico-id" name="id" value="">
        <input type="hidden" name="acao" value="salvar">

        <div class="form-group">
          <label for="nome_servico">Nome do Serviço</label>
          <input type="text" id="nome_servico" name="nome_servico" class="form-control" placeholder="Ex: Teste Técnico de Lógica" required>
        </div>

        <div class="form-group">
          <label for="tipo">Tipo de Serviço</label>
          <select id="tipo" name="tipo" class="form-control">
            <option value="triagem_ia">Triagem Automatizada (IA)</option>
            <option value="entrevista_tecnica">Entrevista Técnica</option>
            <option value="revisao_portfolio">Revisão de Portfólio</option>
          </select>
        </div>

        <div class="form-group">
          <label for="data_agendada">Data Agendada</label>
          <input type="datetime-local" id="data_agendada" name="data_agendada" class="form-control" required>
        </div>

        <button type="submit" id="btn-salvar-servico" class="btn btn-dark">Salvar Serviço</button>
      </form>
    </section>

    <!-- Listagem de Serviços -->
    <section>
      <h3 style="margin-bottom: 12px;">Serviços Configurados</h3>

      <article class="card" data-servico-id="1">
        <div class="vaga-header">
          <div>
            <h4>Entrevista Técnica — Full-Stack</h4>
            <p style="font-size: 0.85rem; color: var(--text-muted);">Tipo: Entrevista Técnica • 28/11/2026 14:00</p>
          </div>
          <span class="badge-green">Agendado</span>
        </div>
        <div class="vaga-actions">
          <button type="button" class="btn btn-outline" style="padding: 8px;">Editar</button>
          <a href="../controllers/ServicoController.php?acao=excluir&id=1" class="btn btn-dark" style="padding: 8px;">Excluir</a>
        </div>
      </article>
    </section>
  </main>

  <nav class="bottom-nav">
    <a href="dashboard.html" class="nav-item">Início</a>
    <a href="vagas.html" class="nav-item">Vagas</a>
    <a href="servicos.html" class="nav-item active">Triagem</a>
    <a href="perfil.html" class="nav-item">Portfólio</a>
  </nav>
</body>
</html>