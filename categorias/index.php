<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
}

require_once '../src/Componentes/header.php';
require_once '../src/Componentes/input.php';
require_once '../src/Componentes/button.php';

require_once '../src/conexao-bd.php';
require_once '../src/Repositorio/CategoriaRepositorio.php';

$erro = $_GET['erro'] ?? '';

$repoCategoria = new CategoriaRepositorio($pdo);
$categorias = $repoCategoria->listar();

if (isset($_GET['id'])) {
    $_GET['id'] = (int) $_GET['id'];
    $selecionado = $repoCategoria->buscarPorId($_GET['id']);
}

$mainDir = '..';
gerarHeader(false, $_SESSION['email'], $mainDir);
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
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title>Categorias - Loja Roupas</title>
</head>

<body>
    <h1>Categorias de Peças</h1>
    <main>
        <div class="container-lista">
            <?php
            foreach ($categorias as $categoria) {
                echo '<div class="lista-item">
                        <p><b>' . $categoria->getNome() . '</b></p>
                        <div class="lista-item-acoes">
                            <a href="?modo=editar&id=' . $categoria->getId() . '" class="lista-item-editar"><img src="../img/Editar.png" alt="Editar"></img></a>
                            <a href="?modo=excluir&id=' . $categoria->getId() . '" class="lista-item-excluir"><img src="../img/Excluir.png" alt="Excluir"></img></a>
                        </div>
                    </div>';
            }
            ?>
        </div>
        <div class="container-direita">
            <?php if (!isset($_GET['modo']) || !isset($_GET['id']) || $_GET['modo'] != 'editar' && $_GET['modo'] != 'excluir') : ?>
                <a href="criar.php" class="botao-add" id="botao-add"><img src="../img/Add.png" alt="Adicionar"></a>

            <?php elseif ($_GET['modo'] == 'editar') : ?>
                <form class="container-editar" action="editar.php" method="POST">
                    <input class="disabled" id="id" name="id" type="number" value=<?php echo $selecionado->getId(); ?>>
                    <?php gerarInputComValue("nome", "text", "Nome", "Nome da categoria", $selecionado->getNome(), $mainDir); ?>
                    <div class="acoes">
                        <?php
                        gerarLink(".", "Cancelar", "cancelar", false);
                        gerarButton("confirmar-editar", "Confirmar", "padrao", true, $mainDir);
                        ?>
                    </div>
                    <?php if ($erro === 'campos-vazios'): ?>
                        <p class="mensagem-erro">Por favor, preencha todos os campos.</p>
                    <?php endif; ?>
                </form>

            <?php elseif ($_GET['modo'] == 'excluir') : ?>
                <div class="container-excluir">
                    <p>Isso irá excluir permanentemente:</p>
                    <br>
                    <p><b><?php echo htmlspecialchars($selecionado->getNome()); ?></b></p>
                    <br>
                    <div class="acoes">
                        <?php
                        gerarLink(".", "Cancelar", "cancelar", false);
                        gerarLink('excluir.php?id=' . $selecionado->getId() . '', "Confirmar", "padrao", false);
                        ?>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </main>
</body>