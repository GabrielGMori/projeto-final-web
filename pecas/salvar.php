<?php
session_start();

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/PecaRepositorio.php';

if (!isset($_POST['categoria_id'])) {
    header('Location: ../categorias');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pecas?categoria_id='.$_POST['categoria_id']);
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$estoque = trim($_POST['estoque'] ?? '');

if ($nome === '' || $estoque === '') {
    header('Location: ./criar.php?erro=campos-vazios&categoria_id='.$_POST['categoria_id']);
    exit;
}

$repoPeca = new PecaRepositorio($pdo);
$repoPeca->criar($nome, (int)$estoque, (int)$_POST['categoria_id']);
header('Location: ../pecas?categoria_id='.$_POST['categoria_id']);

exit;
