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

$pecasSelecionadas = $_GET['pecas'] ?? [];

$repoReposicao = new ReposicaoRepositorio($pdo);
$repoPeca = new PecaRepositorio($pdo);

for ($i = 0; $i < count($pecasSelecionadas); $i++) {
    if (isset($_GET['id']) && $pecasSelecionadas[$i]['id'] == $_GET['id']) {
        $selecionado = $i;
    }
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
    <title>Nova Reposição</title>
</head>

<body>
    <?php gerarHeader($_SESSION['permissao'] == 'admin' ? true : false, false,  $_SESSION['email'], $mainDir); ?>

    <h1>Nova Reposição</h1>
    <main>
        <div class="container-voltar">
            <?php gerarLink('../reposicoes', "<", "cancelar", $mainDir); ?>
        </div>
        <div class="container-lista">
            <?php
            foreach ($pecasSelecionadas as $dadosPeca) {
                $peca = $repoPeca->buscarPorId($dadosPeca['id']);

                $listWithout = array_values($pecasSelecionadas);
                for ($i = 0; $i < count($listWithout); $i++) {
                    if ($listWithout[$i]['id'] == $dadosPeca['id']) {
                        unset($listWithout[$i]);
                    }
                }
                $listWithout = array_values($listWithout);

                echo '<div class="lista-item">

                        <h3>' . htmlspecialchars($dadosPeca['quantidade']) . 'x ' . htmlspecialchars($peca->getNome()) . ' - R$ ' . htmlspecialchars(number_format((float)$dadosPeca['preco'], 2, ',', '.')) . '</h3>

                        <div class="lista-item-acoes">
                            <a href="?modo=editar&id=' . $dadosPeca['id'] . '&' . http_build_query(['pecas' => $pecasSelecionadas]) . '" class="lista-item-editar">
                                <img src="../img/Editar.png" alt="Editar">
                            </a>

                            <a href="?' . http_build_query(['pecas' => $listWithout]) . '" class="lista-item-excluir">
                                <img src="../img/Excluir.png" alt="Excluir">
                            </a>
                        </div>
                        </div>';
            }
            ?>
        </div>
        <div class="container-direita">
            <?php if (!isset($_GET['modo']) || !isset($_GET['id']) || $_GET['modo'] != 'editar') : ?>
                <div class="container-direita-normal">
                    <?php gerarLink("salvar.php?" . http_build_query(['pecas' => $pecasSelecionadas]), "Registrar Reposição", "padrao", $mainDir) ?>
                    <a href="selecionar/categoria.php?<?= http_build_query(['pecas' => $pecasSelecionadas]) ?>" class="botao-add" id="botao-add"><img src="../img/Add.png" alt="Adicionar"></a>
                </div>

            <?php elseif ($_GET['modo'] == 'editar') : ?>
                <form class="container-editar" action="verificar.php" method="GET">
                    <input class="disabled" name="id" value="<?= $_GET['id'] ?>" />

                    <?php
                    for ($i = 0; $i < count($pecasSelecionadas); $i++) {
                        echo '<input class="disabled" name="pecas[' . $i . '][id]" value="' . htmlspecialchars($pecasSelecionadas[$i]['id']) . '" />';
                        echo '<input class="disabled" name="pecas[' . $i . '][quantidade]" value="' . htmlspecialchars($pecasSelecionadas[$i]['quantidade']) . '" />';
                        echo '<input class="disabled" name="pecas[' . $i . '][preco]" value="' . htmlspecialchars($pecasSelecionadas[$i]['preco']) . '" />';
                        if ($i == $selecionado) {
                            gerarInputComValue("quantidade", "number", "Quantidade", "Quantidade comprada", $pecasSelecionadas[$selecionado]['quantidade'], $mainDir);
                            gerarInputDecimalComValue("preco", "0.01", "Preço", "Preço pelo qual foi comprado (total)", $pecasSelecionadas[$selecionado]['preco'], $mainDir);
                        }
                    }
                    ?>

                    <div class="acoes">
                        <?php
                        gerarLink('criar.php?' . http_build_query(['pecas' => $pecasSelecionadas]), "Cancelar", "cancelar", $mainDir);
                        gerarButton("confirmar-editar", "Confirmar", "padrao", true, $mainDir);
                        ?>
                    </div>
                    <?php if ($erro === 'campos-vazios'): ?>
                        <p class="mensagem-erro">Por favor, preencha todos os campos.</p>
                    <?php endif; ?>
                </form>

            <?php endif; ?>
        </div>
    </main>

    <footer>
        <?php if ($erro === 'reposicao-vazia'): ?>
            <p class="mensagem-erro">Por favor, selecione ao menos uma peça.</p>
        <?php endif; ?>
    </footer>

    <script src="../js/lista-expansivel.js"></script>
</body>