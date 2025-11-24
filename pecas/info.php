<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
}

$erro = $_GET['erro'] ?? '';

require_once '../src/Componentes/header.php';
require_once '../src/Componentes/button.php';
require_once '../src/Componentes/input.php';

require_once '../src/conexao-bd.php';
require_once '../src/Repositorio/PecaRepositorio.php';

if (!isset($_GET['categoria_id'])) {
    header('Location: ../categorias');
}

if (!isset($_GET['id'])) {
    header('Location: ../pecas?categoria_id='.$_GET['categoria_id']);
}

$repoPeca = new PecaRepositorio($pdo);
$peca = $repoPeca->buscarPorId($_GET['id']);

$mainDir = '..';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/info.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title><?= htmlspecialchars($peca->getNome()) ?></title>
</head>

<body>
    <?php gerarHeader($_SESSION['permissao'] == 'admin' ? true : false, false,  $_SESSION['email'], $mainDir); ?>

    <h1><?= htmlspecialchars($peca->getNome()) ?></h1>
    <main>
        <section class="container-imagem">
            <?php if ($peca->getImagem() === null): ?>
                <h2>Imagem não disponível.</h2>
            <?php else: ?>
                <img src="<?= htmlspecialchars("../uploads/".$peca->getImagem()) ?>" alt="Imagem da peça <?= $peca->getNome() ?>">
            <?php endif ?>
        </section>

        <section class="container-editar-imagem">
            <form action="./editar.php" method="POST" enctype="multipart/form-data">
                <input class="disabled" name="categoria_id" value="<?= htmlspecialchars($_GET['categoria_id']) ?>" />
                <input class="disabled" id="id" name="id" type="number" value=<?= $peca->getId() ?>>
                <?php gerarInputImagem("imagem", "image/*", "Atualizar imagem: ", $mainDir) ?>
                <?php gerarButton("editarImagem", "Atualizar", "pequeno", true, $mainDir) ?>
        </section>

        <?php if ($erro === 'processamento-imagem'): ?>
            <p class="mensagem-erro">Algo deu errado ao processar a imagem, tente novamente.</p>
        <?php elseif ($erro === 'imagem-vazia'): ?>
            <p class="mensagem-erro">Por favor, selecione uma imagem para atualizá-la</p>
        <?php endif; ?>

        <section class="container-estoque">
            <h2>Estoque: <?= $peca->getEstoque() ?></h2>
            <?php gerarLink("../pecas?categoria_id=".$_GET['categoria_id'], "Voltar", "padrao", $mainDir) ?>
        </section>
    </main>
</body>