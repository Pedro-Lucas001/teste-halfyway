CREATE DATABASE IF NOT EXISTS halfyway
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE halfyway;

-- Tabela de Usuários (Login e Cadastro)
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  tipo_perfil ENUM('candidato', 'empresa') NOT NULL DEFAULT 'candidato',
  career_score INT DEFAULT 85,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Vagas (CRUD de Itens)
CREATE TABLE vagas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa_id INT NULL,
  titulo VARCHAR(150) NOT NULL,
  descricao TEXT NOT NULL,
  salario DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  status ENUM('aberta', 'pausada', 'encerrada') NOT NULL DEFAULT 'aberta',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (empresa_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

-- Tabela de Serviços de Triagem (CRUD de Serviços)
CREATE TABLE servicos_triagem (
  id INT AUTO_INCREMENT PRIMARY KEY,
  vaga_id INT NULL,
  nome_servico VARCHAR(150) NOT NULL,
  tipo ENUM('triagem_ia', 'entrevista_tecnica', 'revisao_portfolio') NOT NULL,
  status ENUM('agendado', 'concluido', 'cancelado') NOT NULL DEFAULT 'agendado',
  data_agendada DATETIME NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (vaga_id) REFERENCES vagas(id) ON DELETE SET NULL
);

-- Tabela de Candidaturas
CREATE TABLE candidaturas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  vaga_id INT NOT NULL,
  match_percentual INT DEFAULT 80,
  status ENUM('enviada', 'triagem', 'entrevista', 'aprovado', 'recusado') DEFAULT 'enviada',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (vaga_id) REFERENCES vagas(id) ON DELETE CASCADE
);

-- Tabela de Logs do Chatbot (Registro da Camada de IA)
CREATE TABLE chat_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NULL,
  mensagem_usuario TEXT NOT NULL,
  resposta_bot TEXT NOT NULL,
  intencao_detectada VARCHAR(80) DEFAULT 'duvida_geral',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

-- Dados iniciais para teste imediato (senha do usuário padrão: "password")
INSERT INTO usuarios (nome, email, senha_hash, tipo_perfil, career_score) VALUES
('Admin HalfyWay', 'admin@halfyway.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'empresa', 92);

INSERT INTO vagas (empresa_id, titulo, descricao, salario, status) VALUES
(1, 'Desenvolvedor PHP / Full-Stack', 'Atuação com PHP, MySQL, APIs REST e integração com Python.', 4500.00, 'aberta'),
(1, 'Analista de QA (Selenium)', 'Automação de testes web e documentação de cenários.', 3800.00, 'aberta');

INSERT INTO servicos_triagem (vaga_id, nome_servico, tipo, status, data_agendada) VALUES
(1, 'Entrevista Técnica — Full-Stack', 'entrevista_tecnica', 'agendado', '2026-11-28 14:00:00');