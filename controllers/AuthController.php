<?php
session_start();
require_once '../config/db.php';

$acao = $_POST['acao'] ?? $_GET['acao'] ?? 'login';

if ($acao === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['tipo_perfil'] = $usuario['tipo_perfil'];
        header('Location: ../views/dashboard.php');
        exit;
    }

    header('Location: ../views/login.php?erro=credenciais');
    exit;
}

if ($acao === 'cadastro' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $tipo  = $_POST['tipo_perfil'] ?? 'candidato';

    if (!$nome || !$email || !$senha) {
        header('Location: ../views/cadastro.php?erro=campos');
        exit;
    }

    $hash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO usuarios (nome, email, senha_hash, tipo_perfil) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$nome, $email, $hash, $tipo]);
        header('Location: ../views/login.php?msg=cadastrado');
        exit;
    } catch (PDOException $e) {
        header('Location: ../views/cadastro.php?erro=email_existente');
        exit;
    }
}

if ($acao === 'logout') {
    session_destroy();
    header('Location: ../views/login.php');
    exit;
}