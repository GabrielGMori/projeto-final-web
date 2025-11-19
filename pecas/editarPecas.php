<?php

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Peca.php';
require_once __DIR__ . '/../src/Repositorio/PecaRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pecas');
    exit;
}

$nome = trim($_POST['nome'] ?? '');

if ($nome === '') {
    header('Location: ../pecas?modo=editar&id='.$_POST['id'].'&erro=campos-vazios');
    exit;
}

$repoCategoria = new PecaRepositorio($pdo);
$repoCategoria->editar(new Peca($_POST['id'], $_POST['nome'], $_POST['estoque']));
header('Location: ../pecas');

exit;
