<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['permissao'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../src/conexao-bd.php';
require_once '../src/Repositorio/UsuarioRepositorio.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: index.php');
    exit;
}

$repoUsuario = new UsuarioRepositorio($pdo);
$repoUsuario->remover((int)$id);

header('Location: index.php');
exit;
