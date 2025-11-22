<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../src/Componentes/header.php';
require_once '../src/Componentes/input.php';
require_once '../src/Componentes/button.php';
require_once '../src/conexao-bd.php';
require_once '../src/Repositorio/PecaRepositorio.php';

$categoriaId = (int)($_GET['categoria_id'] ?? 0);

if ($categoriaId === 0) {
    header('Location: ../categorias/index.php');
    exit;
}

$repoPeca = new PecaRepositorio($pdo);
$pecas = $repoPeca->listarPorCategoria($categoriaId);

$mainDir = '..';

$selecionado = null;
$erro = $_GET['erro'] ?? null;

if (isset($_GET['id']) && $_GET['modo'] === 'editar') {
    $selecionado = $repoPeca->buscarPorId((int)$_GET['id']);
    if (!$selecionado) {
        die('Peça não encontrada.');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/lista.css">
    <title>Peças da Categoria</title>
</head>

<body>
    <?php gerarHeader($_SESSION['permissao'] == 'admin' ? true : false, false, '', $mainDir); ?>

    <h1>Peças desta Categoria</h1>

    <main>
        <a href="../categorias/index.php" class="botao-voltar"><img src="../img/Voltar.png" alt="Voltar"></a>
        <div class="container-lista">
            <?php
            if (empty($pecas)) {
                echo '<p>Não há peças cadastradas para esta categoria.</p>';
            } else {
                foreach ($pecas as $peca) {
                    echo '<div class="lista-item">
                            <p><b>' . htmlspecialchars($peca->getNome()) . '</b> - Estoque: ' . $peca->getEstoque() . '</p>
                            <div class="lista-item-acoes">
                                <a href="indexPecas.php?categoria_id=' . $categoriaId . '&modo=editar&id=' . $peca->getId() . '" class="lista-item-editar">
                                    <img src="../img/Editar.png" alt="Editar">
                                </a>
                                <a href="excluirPecas.php?id=' . $peca->getId() . '&categoria_id=' . $categoriaId . '" class="lista-item-excluir">
                                    <img src="../img/Excluir.png" alt="Excluir">
                                </a>
                            </div>
                        </div>';
                }
            }
            ?>
        </div>
        <div class="container-direita">
            <?php if (!isset($_GET['modo']) || !isset($_GET['id']) || ($_GET['modo'] != 'editar' && $_GET['modo'] != 'excluir')) : ?>
                <a href="criarPecas.php?categoria_id=<?= $categoriaId ?>" class="botao-add" id="botao-add"><img src="../img/Add.png" alt="Adicionar"></a>

            <?php elseif ($_GET['modo'] == 'editar') : ?>
                <form class="container-editar" action="editarPecas.php" method="POST">
                    <input type="hidden" name="categoria_id" value="<?= $categoriaId ?>">
                    <input class="disabled" id="id" name="id" type="number" value="<?= htmlspecialchars($selecionado->getId()); ?>" readonly>
                    <?php gerarInputComValue("nome", "text", "Nome", "Nome da peça", htmlspecialchars($selecionado->getNome()), $mainDir); ?>
                    <?php gerarInputComValue("estoque", "number", "Estoque", "Quantidade em estoque", htmlspecialchars($selecionado->getEstoque()), $mainDir); ?>
                    <div class="acoes">
                        <?php
                        gerarLink("indexPecas.php?categoria_id=" . $categoriaId, "Cancelar", "cancelar", false);
                        gerarButton("confirmar-editar", "Confirmar", "padrao", true, $mainDir);
                        ?>
                    </div>
                    <?php if ($erro === 'campos-vazios') : ?>
                        <p class="mensagem-erro">Por favor, preencha todos os campos.</p>
                    <?php endif; ?>
                </form>

            <?php elseif ($_GET['modo'] == 'excluir') : ?>
                <div class="container-excluir">
                    <p>Isso irá excluir permanentemente:</p>
                    <br>
                    <p><b><?= htmlspecialchars($selecionado->getNome()); ?></b></p>
                    <br>
                    <div class="acoes">
                        <?php
                        gerarLink("indexPecas.php?categoria_id=" . $categoriaId, "Cancelar", "cancelar", false);
                        gerarLink('excluirPecas.php?id=' . $selecionado->getId() . '&categoria_id=' . $categoriaId, "Confirmar", "padrao", false);
                        ?>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </main>
</body>

</html>