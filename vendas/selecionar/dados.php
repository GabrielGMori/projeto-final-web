<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../../login.php');
}

require_once '../../src/Componentes/header.php';
require_once '../../src/Componentes/button.php';
require_once '../../src/Componentes/input.php';

require_once '../../src/conexao-bd.php';
require_once '../../src/Repositorio/PecaRepositorio.php';
require_once '../../src/Repositorio/CategoriaRepositorio.php';

$erro = $_GET['erro'] ?? '';

$pecasSelecionadas = $_GET['pecas'] ?? [];

$repoPeca = new PecaRepositorio($pdo);
$repoCategoria = new CategoriaRepositorio($pdo);

if (!isset($_GET['categoria_id'])) {
    header('Location: categoria.php');
}

$categoriaId = (int)$_GET['categoria_id'];

if (!isset($_GET['id'])) {
    header('Location: peca.php');
}

$pecaId = (int)$_GET['id'];
$peca = $repoPeca->buscarPorId($pecaId);

if (!isset($peca)) {
    header('Location: peca.php');
}

$mainDir = '../..';
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title>Nova Venda (<?= $peca->getNome() ?>)</title>
</head>

<body>
    <?php gerarHeader($_SESSION['permissao'] == 'admin' ? true : false, false, $_SESSION['email'], $mainDir); ?>

    <main>
        <h1>Adicionar (<?= $peca->getNome() ?>)</h1>
        <section class="container-form">
            <form action="../verificar.php" method="GET">
                <input class="disabled" name="redirectErro" value="selecionar/dados.php" />

                <input class="disabled" name="id" value="<?= $pecaId ?>" />
                <input class="disabled" name="categoria_id" value="<?= $categoriaId ?>" />

                <?php for ($i=0; $i<count($pecasSelecionadas); $i++) {
                    echo '<input class="disabled" name="pecas['.$i.'][id]" value="'.htmlspecialchars($pecasSelecionadas[$i]['id']).'" />';
                    echo '<input class="disabled" name="pecas['.$i.'][quantidade]" value="'.htmlspecialchars($pecasSelecionadas[$i]['quantidade']).'" />';
                    echo '<input class="disabled" name="pecas['.$i.'][preco]" value="'.htmlspecialchars($pecasSelecionadas[$i]['preco']).'" />';
                } ?>
                
                <?php
                gerarInput("quantidade", "number", "Quantidade", "Quantidade vendida", $mainDir);
                gerarInputDecimal("preco", "0.01", "Preço", "Preço pelo qual foi vendido (total)", $mainDir);
                ?>
                
                <div class="acoesForm">
                    <?php
                    gerarLink("peca.php?categoria_id=".$categoriaId.'&'.http_build_query(["pecas" => $pecasSelecionadas]), "Voltar", "cancelar", $mainDir);
                    gerarButton("adicionar", "Adicionar", "padrao", true, $mainDir);
                    ?>
                </div>
            </form>

            <?php if ($erro === 'campos-vazios'): ?>
                <p class="mensagem-erro">Por favor, preencha todos os campos.</p>
            <?php elseif ($erro === 'estoque-insuficiente'): ?>
                <p class="mensagem-erro">A quantidade vendida escolhida é maior que a quantidade disponível da peça (<?= $peca->getEstoque() ?>).</p>
            <?php endif; ?>
        </section>
    </main>

</body>

</html>