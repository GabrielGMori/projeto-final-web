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

    <h1>Peças da Categoria</h1>
    <main>
        <div class="container-lista">
            <?php
            if (empty($pecas)) {
                echo '<p>Não há peças cadastradas para esta categoria.</p>';
            } else {
                foreach ($pecas as $peca) {
                    echo '<div class="lista-item">
                            <p><b>' . htmlspecialchars($peca->getNome()) . '</b> - Estoque: ' . $peca->getEstoque() . '</p>
                            <div class="lista-item-acoes">
                                <a href="editarPecas.php?id=' . $peca->getId() . '" class="lista-item-editar"><img src="../img/Editar.png" alt="Editar"></img></a>
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
            <form action="salvarPecas.php" method="POST">
                <input type="hidden" name="categoria_id" value="<?php echo $categoriaId; ?>">
                <?php gerarInput("nome", "nome", "Nome", "Insira o nome da peça...", $mainDir); ?>
                <?php gerarInput("estoque", "estoque", "Estoque", "Insira a quantidade em estoque...", $mainDir); ?>
                <div class="acoesForm">
                    <?php gerarButton("criar", "Adicionar Peça", "padrao", false, true); ?>
                </div>
            </form>
        </div>
    </main>
</body>

</html>