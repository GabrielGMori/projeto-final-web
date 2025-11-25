<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['permissao'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../src/conexao-bd.php';
require_once '../src/Repositorio/UsuarioRepositorio.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

$repoUsuario = new UsuarioRepositorio($pdo);

if ($repoUsuario->buscarPorId($id)->getEmail() == $_SESSION['email']) {
    header('Location: index.php?modo=excluir&id='.$_GET['id'].'&erro=usando-conta');
    exit;
}

$repoUsuario->remover($id);

header('Location: index.php');
exit;
