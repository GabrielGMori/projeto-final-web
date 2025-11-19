<?php
session_start();

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/CategoriaRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: ../categorias');
    exit;
}

$repoCategoria = new CategoriaRepositorio($pdo);
$repoCategoria->remover($_GET['id']);
header('Location: ../categorias');

exit;
