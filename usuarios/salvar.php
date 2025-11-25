<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['permissao'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/UsuarioRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = $_POST['id'] ?? null;
$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');
$permissao = $_POST['permissao'] ?? '';

if ($email === '' || $permissao === '') {
    $redirect = $id ? "editar.php?id=$id&erro=campos-vazios" : "criar.php?erro=campos-vazios";
    header("Location: $redirect");
    exit;
}

$repoUsuario = new UsuarioRepositorio($pdo);

$usuarioExiste = $repoUsuario->buscarPorEmail($email);
if ($usuarioExiste && (!$id || $usuarioExiste->getId() != (int)$id)) {
    $redirect = $id ? "editar.php?id=$id&erro=email-existente" : "criar.php?erro=email-existente";
    header("Location: $redirect");
    exit;
}

if ($id) {
    // Editar
    $usuario = $repoUsuario->buscarPorId((int)$id);
    if (!$usuario) {
        header('Location: index.php');
        exit;
    }
    $senhaParaSalvar = $senha !== '' ? password_hash($senha, PASSWORD_DEFAULT) : $usuario->getSenha();
    $repoUsuario->editar(new Usuario((int)$id, $email, $senhaParaSalvar, $permissao));

    header('Location: index.php');
    exit;

} else {
    // Criar
    if ($email === '' || $senha === '') {
        header("Location: criar.php?erro=campos-vazios");
        exit;
    }
    $repoUsuario->criar($email, $senha, $permissao);
    header('Location: index.php');
    exit;
}
