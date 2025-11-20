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
    header('Location: ../pecas?modo=editar&id='.$_POST['id'].'&erro=campos-vazios');
    exit;
}

$repoPeca = new PecaRepositorio($pdo);
$repoPeca->editar(new Peca($_POST['id'], $_POST['nome'], $_POST['estoque']));
header('Location: ../pecas');

exit;
