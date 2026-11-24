<?php
session_start();
require_once '../config/db.php';
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
$vagas = $pdo->query("SELECT * FROM vagas ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vagas (CRUD Itens) — HalfyWay</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <main class="app-container">
    <header class="topbar">
      <div class="brand">Halfy<span>Way</span></div>
      <span class="badge-green">Gestão de Vagas</span>
    </header>

    <!-- Formulário de Cadastro / Edição de Vaga -->
    <section class="card">
      <h3 style="margin-bottom: 14px;">Cadastrar / Editar Vaga</h3>
      <form id="form-vaga" action="../controllers/VagaController.php" method="POST">
        <input type="hidden" id="vaga-id" name="id" value="">
        <input type="hidden" name="acao" value="salvar">

        <div class="form-group">
          <label for="titulo">Título da Vaga</label>
          <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ex: Desenvolvedor Back-End PHP" required>
        </div>

        <div class="form-group">
          <label for="descricao">Descrição e Requisitos</label>
          <textarea id="descricao" name="descricao" class="form-control" rows="3" placeholder="Principais atividades e stack..." required></textarea>
        </div>

        <div class="form-group">
          <label for="salario">Faixa Salarial (R$)</label>
          <input type="number" step="0.01" id="salario" name="salario" class="form-control" placeholder="4500.00" required>
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select id="status" name="status" class="form-control">
            <option value="aberta">Aberta</option>
            <option value="pausada">Pausada</option>
            <option value="encerrada">Encerrada</option>
          </select>
        </div>

        <button type="submit" id="btn-salvar-vaga" class="btn btn-green">Salvar Vaga</button>
      </form>
    </section>

    <!-- Listagem de Vagas Cadastradas -->
    <?php foreach ($vagas as $vaga): ?>
  <article class="card" data-vaga-id="<?= $vaga['id'] ?>">
    <div class="vaga-header">
      <div>
        <h4><?= htmlspecialchars($vaga['titulo']) ?></h4>
        <p style="font-size: 0.85rem; color: var(--text-muted);">
          R$ <?= number_format($vaga['salario'], 2, ',', '.') ?>
        </p>
      </div>
      <span class="badge-green"><?= ucfirst($vaga['status']) ?></span>
    </div>
    <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 6px;">
      <?= htmlspecialchars($vaga['descricao']) ?>
    </p>
    <div class="vaga-actions">
      <button type="button" class="btn btn-outline btn-editar-vaga" style="padding: 8px;"
        onclick='preencherEdicao(<?= json_encode($vaga) ?>)'>Editar</button>
      <a href="../controllers/VagaController.php?acao=excluir&id=<?= $vaga['id'] ?>"
         class="btn btn-dark btn-excluir-vaga" style="padding: 8px;">Excluir</a>
    </div>
  </article>
<?php endforeach; ?>

<script>
function preencherEdicao(vaga) {
  document.getElementById('vaga-id').value = vaga.id;
  document.getElementById('titulo').value = vaga.titulo;
  document.getElementById('descricao').value = vaga.descricao;
  document.getElementById('salario').value = vaga.salario;
  document.getElementById('status').value = vaga.status;
  window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>

  <nav class="bottom-nav">
    <a href="dashboard.html" class="nav-item">Início</a>
    <a href="vagas.html" class="nav-item active">Vagas</a>
    <a href="servicos.html" class="nav-item">Triagem</a>
    <a href="perfil.html" class="nav-item">Portfólio</a>
  </nav>
</body>
</html>