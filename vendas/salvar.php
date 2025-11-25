<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/VendaRepositorio.php';
require_once __DIR__ . '/../src/Repositorio/PecaRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: criar.php');
    exit;
}

if (!isset($_GET['pecas']) || !is_array($_GET['pecas']) || empty($_GET['pecas'])) {
    header('Location: criar.php?erro=venda-vazia');
    exit;
}

$repoVenda = new VendaRepositorio($pdo);
$repoVenda->criar($_GET['pecas']);

$repoPeca = new PecaRepositorio($pdo);
foreach ($_GET['pecas'] as $peca) {
    $pecaAntiga = $repoPeca->buscarPorId($peca['id']);
    $repoPeca->editar(new Peca(
        $pecaAntiga->getId(),
        $pecaAntiga->getNome(),
        $pecaAntiga->getEstoque() - $peca['quantidade'],
        $pecaAntiga->getImagem(),
        $pecaAntiga->getCategoriaId()
    ));
}

header('Location: ../vendas');

exit;
