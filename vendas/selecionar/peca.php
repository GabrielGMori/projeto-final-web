<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../../login.php');
}

require_once '../../src/Componentes/header.php';
require_once '../../src/Componentes/input.php';
require_once '../../src/Componentes/button.php';

require_once '../../src/conexao-bd.php';
require_once '../../src/Repositorio/PecaRepositorio.php';
require_once '../../src/Repositorio/CategoriaRepositorio.php';

require_once '../../src/criar-parametros-get-listas.php';

$pecasSelecionadas = $_GET['pecas'] ?? [];

$repoPeca = new PecaRepositorio($pdo);
$repoCategoria = new CategoriaRepositorio($pdo);

if (!isset($_GET['categoria_id'])) {
    header('Location: categoria.php');
}

$categoriaId = (int)$_GET['categoria_id'];
$categoria = $repoCategoria->buscarPorId($categoriaId);

if (!isset($categoria)) {
    header('Location: categoria.php');
}

$limitePorPagina = isset($_GET['limite']) ? $_GET['limite'] : 10;
$paginaAtual = isset($_GET['pagina']) && $_GET['pagina'] > 0 ? $_GET['pagina'] : 1;

$total = $repoPeca->contarPorCategoria($categoriaId);
$offset = ($paginaAtual - 1) * $limitePorPagina;
$totalPaginas = ceil($total / $limitePorPagina);

$pecas = $repoPeca->listarPaginadoPorCategoria($categoriaId, $limitePorPagina, $offset);

$mainDir = '../..';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/lista.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="../../img/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title>Nova Venda (<?= $categoria->getNome() ?>)</title>
</head>

<body>
    <?php gerarHeader($_SESSION['permissao'] == 'admin' ? true : false, false,  $_SESSION['email'], $mainDir); ?>

    <h1>Selecione uma Peça (<?= $categoria->getNome() ?>)</h1>
    <main>
        <div class="container-voltar">
            <?php gerarLink('categoria.php?'.http_build_query(["pecas" => $pecasSelecionadas]), "<", "padrao", $mainDir); ?>
        </div>
        <div class="container-lista">
            <?php
            foreach ($pecas as $peca) {
                echo '<div class="lista-item">

                    <a href="dados.php?id='.$peca->getId().'&categoria_id=' . $categoria->getId() .'&'.http_build_query(["pecas" => $pecasSelecionadas]).'">' . $peca->getNome() . ' <span>x' . $peca->getEstoque() . '</span></a>

                    </div>';
                }
            ?>
        </div>
    </main>
    <footer>
        <div class="container-limite">
            <form class="form-limite" method="GET" action="peca.php">
                <input class="disabled" name="categoria_id" value="<?= htmlspecialchars($categoriaId) ?>" />
                <?php for ($i=0; $i<count($pecasSelecionadas); $i++) {
                    echo '<input class="disabled" name="pecas['.$i.'][id]" value="'.htmlspecialchars($pecasSelecionadas[$i]['id']).'" />';
                    echo '<input class="disabled" name="pecas['.$i.'][quantidade]" value="'.htmlspecialchars($pecasSelecionadas[$i]['quantidade']).'" />';
                    echo '<input class="disabled" name="pecas['.$i.'][preco]" value="'.htmlspecialchars($pecasSelecionadas[$i]['preco']).'" />';
                } ?>
                <label for="limite">Itens por página:</label>
                <select name="limite" id="limite" onchange="this.form.submit()">
                    <option value="5" <?= $limitePorPagina == 5 ? 'selected' : '' ?>>5</option>
                    <option value="10" <?= $limitePorPagina == 10 ? 'selected' : '' ?>>10</option>
                    <option value="20" <?= $limitePorPagina == 20 ? 'selected' : '' ?>>20</option>
                    <option value="50" <?= $limitePorPagina == 50 ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= $limitePorPagina == 100 ? 'selected' : '' ?>>100</option>
                    <option value="1000" <?= $limitePorPagina == 1000 ? 'selected' : '' ?>>1000</option>
                </select>
            </form>
        </div>
        <div class="container-pagina">
            <?php if ($totalPaginas > 1): ?>
                <?php
                if ($paginaAtual > 1):
                    gerarLink('peca.php' . criarParamsGet(null, null, $limitePorPagina, $paginaAtual - 1, $categoriaId).'&'.http_build_query(["pecas" => $pecasSelecionadas]), "<", "paginacao", $mainDir);
                    gerarLink('peca.php' . criarParamsGet(null, null, $limitePorPagina, 1, $categoriaId).'&'.http_build_query(["pecas" => $pecasSelecionadas]), "1", "paginacao", $mainDir);
                else: ?>
                    <span class="paginacao-disabled"><</span>
                            <span class="paginacao-disabled">1</span>
                        <?php endif;

                    if ($paginaAtual - 2 > 1): ?>
                            <span class="paginacao-disabled">...</span>
                            <?php endif;

                        for ($i = $paginaAtual - 1; $i <= $paginaAtual; $i++):
                            if ($i > 1 && $i < $totalPaginas):
                                if ($i == $paginaAtual): ?>
                                    <span class="paginacao-disabled"><?= $i ?></span>
                                <?php
                                else:
                                    gerarLink('peca.php' . criarParamsGet(null, null, $limitePorPagina, $i, $categoriaId).'&'.http_build_query(["pecas" => $pecasSelecionadas]), $i, "paginacao", $mainDir);
                                endif;
                            endif;
                        endfor;

                        for ($i = $paginaAtual + 1; $i <= $paginaAtual + 2; $i++):
                            if ($i > 1 && $i < $totalPaginas):
                                if ($i == $paginaAtual): ?>
                                    <span class="paginacao-disabled"><?= $i ?></span>
                            <?php
                                else:
                                    gerarLink('peca.php' . criarParamsGet(null, null, $limitePorPagina, $i, $categoriaId).'&'.http_build_query(["pecas" => $pecasSelecionadas]), $i, "paginacao", $mainDir);
                                endif;
                            endif;
                        endfor;

                        if ($paginaAtual + 3 < $totalPaginas): ?>
                            <span class="paginacao-disabled">...</span>
                        <?php endif;

                        if ($paginaAtual < $totalPaginas):
                            gerarLink('peca.php' . criarParamsGet(null, null, $limitePorPagina, $totalPaginas, $categoriaId).'&'.http_build_query(["pecas" => $pecasSelecionadas]), $totalPaginas, "paginacao", $mainDir);
                            gerarLink('peca.php' . criarParamsGet(null, null, $limitePorPagina, $paginaAtual + 1, $categoriaId).'&'.http_build_query(["pecas" => $pecasSelecionadas]), ">", "paginacao", $mainDir);
                        else: ?>
                            <span class="paginacao-disabled"><?= $totalPaginas ?></span>
                            <span class="paginacao-disabled">></span>
                        <?php endif; ?>
                    <?php endif; ?>
        </div>
    </footer>
</body>