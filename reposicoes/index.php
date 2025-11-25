<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
}

require_once '../src/Componentes/header.php';
require_once '../src/Componentes/input.php';
require_once '../src/Componentes/button.php';

require_once '../src/conexao-bd.php';
require_once '../src/Repositorio/ReposicaoRepositorio.php';
require_once '../src/Repositorio/PecaRepositorio.php';

require_once '../src/criar-parametros-get-listas.php';

$erro = $_GET['erro'] ?? '';

$repoReposicao = new ReposicaoRepositorio($pdo);
$repoPeca = new PecaRepositorio($pdo);

$limitePorPagina = isset($_GET['limite']) ? $_GET['limite'] : 10;
$paginaAtual = isset($_GET['pagina']) && $_GET['pagina'] > 0 ? $_GET['pagina'] : 1;

$total = $repoReposicao->contar();
$offset = ($paginaAtual - 1) * $limitePorPagina;
$totalPaginas = ceil($total / $limitePorPagina);

$reposicoes = $repoReposicao->listarPaginado($limitePorPagina, $offset);

if (isset($_GET['id'])) {
    $_GET['id'] = (int) $_GET['id'];
    $selecionado = $repoReposicao->buscarPorId($_GET['id']);
}

$mainDir = '..';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/lista.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title>Reposições</title>
</head>

<body>
    <?php gerarHeader($_SESSION['permissao'] == 'admin' ? true : false, false,  $_SESSION['email'], $mainDir); ?>

    <h1>Reposições</h1>
    <main>
        <div class="container-lista">
            <?php
            foreach ($reposicoes as $reposicao) {
                $pecas = $repoReposicao->getPecas($reposicao->getId());
                $total = 0.00;
                foreach ($pecas as $peca) {
                    $total += (float)$peca['preco'];
                }
                $total = number_format($total, 2, ',', '.');

                echo '<div class="lista-item-expansivel">

                        <div class="lista-item-expansivel-topo">
                            <h3>Reposicao ' . htmlspecialchars($reposicao->getDataFormatada()) . '</h3>
                            <a href="' . criarParamsGet("excluir", $reposicao->getId(), $limitePorPagina, $paginaAtual, null) . '" class="lista-item-excluir">
                                <img src="../img/Excluir.png" alt="Excluir">
                            </a>
                        </div>

                        <p><i>R$ ' . htmlspecialchars($total) . ' - ' . htmlspecialchars(count($pecas)) . ' peças</i></p>

                        <div class="lista-item-expansivel-pecas disabled">';
                            foreach ($pecas as $peca) {
                                $nome = $repoPeca->buscarPorId($peca['id'])->getNome();
                                $preco = number_format($peca['preco'], 2, ',', '.');
                                echo '<p>' . htmlspecialchars($peca['quantidade']) . 'x ' . htmlspecialchars($nome) . ' - R$ ' . htmlspecialchars($preco) . '</p>';
                            }
                echo    '</div>
                        
                        <button class="botao-expandir"><img class=""botao-expandir-img" src="../img/Abrir.png" alt="Conta"></button>
                    </div>';
            }
            ?>
        </div>
        <div class="container-direita">
            <?php if (!isset($_GET['modo']) || !isset($_GET['id']) || $_GET['modo'] != 'excluir') : ?>
                <a href="criar.php" class="botao-add" id="botao-add"><img src="../img/Add.png" alt="Adicionar"></a>

            <?php elseif ($_GET['modo'] == 'excluir') : ?>
                <div class="container-excluir">
                    <p>Isso irá excluir permanentemente:</p>
                    <br>
                    <p><b><?php echo "Reposicao " . htmlspecialchars($selecionado->getDataFormatada()); ?></b></p>
                    <br>
                    <div class="acoes">
                        <?php
                        gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, $paginaAtual, null), "Cancelar", "cancelar", $mainDir);
                        gerarLink('excluir.php?id=' . $selecionado->getId() . '', "Confirmar", "padrao", $mainDir);
                        ?>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </main>
    <footer>
        <div class="container-limite">
            <form class="form-limite" method="GET" action=".">
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
                    gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, $paginaAtual - 1, null), "<", "paginacao", $mainDir);
                    gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, 1, null), "1", "paginacao", $mainDir);
                else: ?>
                    <span class="paginacao-disabled">
                        <
                            </span>
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
                                    gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, $i, null), $i, "paginacao", $mainDir);
                                endif;
                            endif;
                        endfor;

                        for ($i = $paginaAtual + 1; $i <= $paginaAtual + 2; $i++):
                            if ($i > 1 && $i < $totalPaginas):
                                if ($i == $paginaAtual): ?>
                                    <span class="paginacao-disabled"><?= $i ?></span>
                            <?php
                                else:
                                    gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, $i, null), $i, "paginacao", $mainDir);
                                endif;
                            endif;
                        endfor;

                        if ($paginaAtual + 3 < $totalPaginas): ?>
                            <span class="paginacao-disabled">...</span>
                        <?php endif;

                        if ($paginaAtual < $totalPaginas):
                            gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, $totalPaginas, null), $totalPaginas, "paginacao", $mainDir);
                            gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, $paginaAtual + 1, null), ">", "paginacao", $mainDir);
                        else: ?>
                            <span class="paginacao-disabled"><?= $totalPaginas ?></span>
                            <span class="paginacao-disabled">></span>
                        <?php endif; ?>
                    <?php endif; ?>
        </div>
    </footer>

    <script src="../js/lista-expansivel.js"></script>
</body>