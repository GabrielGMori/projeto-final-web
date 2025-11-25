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
$senha = $_POST['senha'] ?? '';
$permissao = $_POST['permissao'] ?? '';

if ($email === '' || $permissao === '') {
    $redirect = $id ? "editar.php?id=$id&erro=campos-vazios" : "criar.php?erro=campos-vazios";
    header("Location: $redirect");
    exit;
}

$repoUsuario = new UsuarioRepositorio($pdo);

    
$usuarioExistente = $repoUsuario->buscarPorEmail($email);
if ($usuarioExistente && (!$id || $usuarioExistente->getId() != (int)$id)) {
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
    require_once __DIR__ . '/../src/Modelo/Usuario.php';

    $sqlUpdate = "UPDATE usuario SET email = ?, permissao = ?";

    if ($senha !== '') {
        $sqlUpdate .= ", senha = ?";
    }
    $sqlUpdate .= " WHERE id_pk = ?";

    $stmt = $pdo->prepare($sqlUpdate);

    if ($senha !== '') {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt->execute([$email, $permissao, $senhaHash, (int)$id]);    
    } else {
        $stmt->execute([$email, $permissao, (int)$id]);
    }

    header('Location: index.php');
    exit;

} else {
    // Criar
    if ($senha === '') {
        header("Location: criar.php?erro=campos-vazios");
        exit;
    }
    $repoUsuario->criar($email, $senha, $permissao);
    header('Location: index.php');
    exit;
}
