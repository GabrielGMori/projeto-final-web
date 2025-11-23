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
require_once '../src/Repositorio/CategoriaRepositorio.php';

$repoCategoria = new CategoriaRepositorio($pdo);

if (!isset($_GET['categoria_id'])) {
    header('Location: ../categorias');
}

$categoriaId = (int)$_GET['categoria_id'];
$categoria = $repoCategoria->buscarPorId($categoriaId);

if (!isset($categoria)) {
    header('Location: ../categorias');
}

$mainDir = '..';
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title>Criar Peça</title>
</head>

<body>
    <?php gerarHeader($_SESSION['permissao'] == 'admin' ? true : false, false, $_SESSION['email'], $mainDir); ?>

    <main>
        <h1>Criar Peça (<?= htmlspecialchars($categoria->getNome()) ?>)</h1>
        <section class="container-form">
            <form action="./salvar.php" method="POST">
                <input class="disabled" name="categoria_id" value="<?= htmlspecialchars($categoriaId) ?>" />
                <?php gerarInput("nome", "nome", "Nome", "Insira o nome da peça...", $mainDir); ?>
                <?php gerarInput("estoque", "estoque", "Estoque inicial", "Insira a quantidade de estoque...", $mainDir); ?>
                <div class="acoesForm">
                    <?php
                    gerarLink(".?categoria_id=".$categoriaId, "Cancelar", "cancelar", $mainDir);
                    gerarButton("criar", "Criar", "padrao", false, $mainDir);
                    ?>
                </div>

            </form>

            <?php if ($erro === 'campos-vazios'): ?>
                <p class="mensagem-erro">Por favor, preencha todos os campos.</p>
            <?php endif; ?>
        </section>
    </main>

</body>

</html>