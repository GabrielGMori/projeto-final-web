<?php
session_start();

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/CategoriaRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../criar-categoria.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');

if ($nome === '') {
    header('Location: ../criar-categoria.php?erro=campos-vazios');
    exit;
}

$repoCategoria = new CategoriaRepositorio($pdo);
$repoCategoria->criar($nome);
header('Location: ../categorias');

exit;
