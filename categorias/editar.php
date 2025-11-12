<?php

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Categoria.php';
require_once __DIR__ . '/../src/Repositorio/CategoriaRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../categorias');
    exit;
}

$nome = trim($_POST['nome'] ?? '');

if ($nome === '') {
    header('Location: ../categorias?modo=editar&id='.$_POST['id'].'&erro=campos-vazios');
    exit;
}

$repoCategoria = new CategoriaRepositorio($pdo);
$repoCategoria->editar(new Categoria($_POST['id'], $_POST['nome']));
header('Location: ../categorias');

exit;
