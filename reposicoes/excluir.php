<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/ReposicaoRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    header('Location: ../reposicoes');
    exit;
}

$repoReposicao = new ReposicaoRepositorio($pdo);
$repoReposicao->remover($_GET['id']);
header('Location: ../reposicoes');

exit;
