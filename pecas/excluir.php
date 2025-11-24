<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/PecaRepositorio.php';

if (!isset($_GET['categoria_id'])) {
    header('Location: ../categorias');
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    header('Location: ../pecas?categoria_id='.$_GET['categoria_id']);
    exit;
}

$repoPeca = new PecaRepositorio($pdo);
$repoPeca->remover($_GET['id']);
header('Location: ../pecas?categoria_id='.$_GET['categoria_id']);

exit;
