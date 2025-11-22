<?php

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Peca.php';
require_once __DIR__ . '/../src/Repositorio/PecaRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pecas');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$estoque = (int)($_POST['estoque'] ?? 1);

if ($nome === '') {
    header('Location: ../pecas?modo=editarPecas&id='.$_POST['id'].'&erro=campos-vazios');
    exit;
}

$repoPeca = new PecaRepositorio($pdo);
$repoPeca->editar(new Peca($_POST['id'], $_POST['nome'], $_POST['estoque']));
$categoriaId = (int)($_POST['categoria_id'] ?? 0);
header('Location: indexPecas.php?categoria_id=' . $categoriaId);

exit;
