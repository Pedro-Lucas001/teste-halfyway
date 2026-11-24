<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — HalfyWay</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <main class="app-container">
    <header class="topbar">
      <div class="brand">Halfy<span>Way</span></div>
      <span class="badge-green">Candidato</span>
    </header>

    <!-- Card Escuro: Global Career Score -->
    <section class="card card-dark" style="display: flex; justify-content: space-between; align-items: center;">
      <div>
        <p style="font-size: 0.8rem; color: #94A3B8;">Global Career Score</p>
        <h2 style="margin: 4px 0;">Perfil em Destaque</h2>
        <p style="font-size: 0.85rem; color: #CBD5E1;">Top 5% em compatibilidade</p>
      </div>
      <div class="score-ring">85%</div>
    </section>

    <!-- Resumo de Candidaturas -->
    <section class="stats-grid">
      <div class="stat-box"><strong>12</strong><span>Enviadas</span></div>
      <div class="stat-box"><strong>5</strong><span>Triagem</span></div>
      <div class="stat-box"><strong>3</strong><span>Entrevistas</span></div>
    </section>

    <!-- Seção CRUD de Vagas (Itens) -->
    <section style="margin-bottom: 24px;">
      <div class="topbar" style="margin-bottom: 12px;">
        <h3>Vagas Recomendadas</h3>
        <a href="vaga_form.html" class="btn btn-green" style="width: auto; padding: 8px 14px; font-size: 0.85rem;">+ Nova Vaga</a>
      </div>

      <article class="card">
        <div class="vaga-header">
          <div>
            <h4>Desenvolvedor PHP / Full-Stack</h4>
            <p style="font-size: 0.85rem; color: var(--text-muted);">Tech Solutions • Remoto</p>
          </div>
          <span class="badge-green">92% Match</span>
        </div>
        <div class="vaga-actions">
          <button class="btn btn-dark" style="padding: 8px;">Candidatar-se</button>
          <button class="btn btn-outline" style="padding: 8px;">Editar</button>
        </div>
      </article>
    </section>

    <!-- Seção do Chatbot IA (Integrado com Python) -->
    <section class="card">
      <h3 style="margin-bottom: 12px;">Assistente HalfyWay (IA)</h3>
      <div class="chat-box" id="chat-box">
        <div class="msg msg-bot">Olá! Posso buscar vagas abertas ou consultar suas candidaturas. Como ajudo?</div>
      </div>
      <div class="chat-input-group">
        <input type="text" id="chat-input" class="form-control" placeholder="Digite sua pergunta...">
        <button id="btn-enviar-chat" class="btn btn-green" style="width: auto;">Enviar</button>
      </div>
    </section>
  </main>

  <!-- Menu Inferior -->
  <nav class="bottom-nav">
    <a href="dashboard.html" class="nav-item active">Início</a>
    <a href="vagas.html" class="nav-item">Vagas</a>
    <a href="servicos.html" class="nav-item">Triagem</a>
    <a href="perfil.html" class="nav-item">Portfólio</a>
  </nav>
</body>
</html>