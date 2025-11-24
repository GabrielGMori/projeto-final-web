<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/CategoriaRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../categorias');
    exit;
}

$nome = trim($_POST['nome'] ?? '');

if ($nome === '') {
    header('Location: ./criar.php?erro=campos-vazios');
    exit;
}

$repoCategoria = new CategoriaRepositorio($pdo);
$repoCategoria->criar($nome);
header('Location: ../categorias');

exit;
