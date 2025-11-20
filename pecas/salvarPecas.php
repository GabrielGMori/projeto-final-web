<?php
session_start();

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/PecaRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../categorias/index.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$estoque = (int)($_POST['estoque'] ?? 1);
$categoriaId = (int)($_POST['categoria_id'] ?? 0);

if ($nome === '' || $categoriaId === 0) {
    header('Location: ../categorias/index.php?erro=campos-vazios');
    exit;
}

$repoPeca = new PecaRepositorio($pdo);
$repoPeca->criar($nome, $estoque, $categoriaId);

header('Location: indexPecas.php?categoria_id=' . $categoriaId);
exit;
