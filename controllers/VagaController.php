<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../views/login.php');
    exit;
}

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

if ($acao === 'salvar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = $_POST['id'] ?? '';
    $titulo    = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $salario   = (float) ($_POST['salario'] ?? 0);
    $status    = $_POST['status'] ?? 'aberta';

    if (!empty($id)) {
        // UPDATE
        $stmt = $pdo->prepare(
            "UPDATE vagas SET titulo = ?, descricao = ?, salario = ?, status = ? WHERE id = ?"
        );
        $stmt->execute([$titulo, $descricao, $salario, $status, $id]);
    } else {
        // CREATE
        $stmt = $pdo->prepare(
            "INSERT INTO vagas (empresa_id, titulo, descricao, salario, status) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$_SESSION['usuario_id'], $titulo, $descricao, $salario, $status]);
    }

    header('Location: ../views/vagas.php?msg=salvo');
    exit;
}

if ($acao === 'excluir' && isset($_GET['id'])) {
    // DELETE
    $stmt = $pdo->prepare("DELETE FROM vagas WHERE id = ?");
    $stmt->execute([(int) $_GET['id']]);
    header('Location: ../views/vagas.php?msg=excluido');
    exit;
}