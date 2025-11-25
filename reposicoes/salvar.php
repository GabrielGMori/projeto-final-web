<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/ReposicaoRepositorio.php';
require_once __DIR__ . '/../src/Repositorio/PecaRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: criar.php');
    exit;
}

if (!isset($_GET['pecas']) || !is_array($_GET['pecas']) || empty($_GET['pecas'])) {
    header('Location: criar.php?erro=reposicao-vazia');
    exit;
}

$repoReposicao = new ReposicaoRepositorio($pdo);
$repoReposicao->criar($_GET['pecas']);

$repoPeca = new PecaRepositorio($pdo);
foreach ($_GET['pecas'] as $peca) {
    $pecaAntiga = $repoPeca->buscarPorId($peca['id']);
    $repoPeca->editar(new Peca(
        $pecaAntiga->getId(),
        $pecaAntiga->getNome(),
        $pecaAntiga->getEstoque() + $peca['quantidade'],
        $pecaAntiga->getImagem(),
        $pecaAntiga->getCategoriaId()
    ));
}

header('Location: ../reposicoes');

exit;
