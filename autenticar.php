<?php
session_start();

require_once __DIR__ . '/src/conexao-bd.php';
require_once __DIR__ . '/src/Repositorio/UsuarioRepositorio.php';
require_once __DIR__ . '/src/Modelo/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($email === '' || $senha === '') {
    header('Location: login.php?erro=campos-vazios');
    exit;
}

$repoUsuario = new UsuarioRepositorio($pdo);

if (!$repoUsuario->autenticar($email, $senha)) {
    header('Location: login.php?erro=credenciais-erradas');
    exit;
}

session_regenerate_id(true);
$_SESSION['email'] = $email;
header('Location: categorias.php');

exit;
