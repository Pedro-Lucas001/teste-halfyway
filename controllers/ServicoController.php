<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../views/login.php');
    exit;
}

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

if ($acao === 'salvar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id           = $_POST['id'] ?? '';
    $nomeServico  = trim($_POST['nome_servico'] ?? '');
    $tipo         = $_POST['tipo'] ?? 'triagem_ia';
    $dataAgendada = $_POST['data_agendada'] ?? date('Y-m-d H:i:s');

    if (!empty($id)) {
        // UPDATE
        $stmt = $pdo->prepare(
            "UPDATE servicos_triagem SET nome_servico = ?, tipo = ?, data_agendada = ? WHERE id = ?"
        );
        $stmt->execute([$nomeServico, $tipo, $dataAgendada, $id]);
    } else {
        // CREATE
        $stmt = $pdo->prepare(
            "INSERT INTO servicos_triagem (nome_servico, tipo, data_agendada) VALUES (?, ?, ?)"
        );
        $stmt->execute([$nomeServico, $tipo, $dataAgendada]);
    }

    header('Location: ../views/servicos.php?msg=salvo');
    exit;
}

if ($acao === 'excluir' && isset($_GET['id'])) {
    // DELETE
    $stmt = $pdo->prepare("DELETE FROM servicos_triagem WHERE id = ?");
    $stmt->execute([(int) $_GET['id']]);
    header('Location: ../views/servicos.php?msg=excluido');
    exit;
}