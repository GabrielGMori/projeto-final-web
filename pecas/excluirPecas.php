<?php
session_start();

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/PecaRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: ../pecas');
    exit;
}

$repoPeca = new PecaRepositorio($pdo);
$repoPeca->remover($_GET['id']);
$categoriaId = (int)($_GET['categoria_id'] ?? 0);
header('Location: indexPecas.php?categoria_id=' . $categoriaId);

exit;
