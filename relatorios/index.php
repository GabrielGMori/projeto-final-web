<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
}

$erro = $_GET['erro'] ?? '';

require_once '../src/Componentes/header.php';
require_once '../src/Componentes/button.php';
require_once '../src/Componentes/input.php';

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
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title>Gerar Relatório</title>
</head>

<body>
    <?php gerarHeader($_SESSION['permissao'] == 'admin' ? true : false, false, $_SESSION['email'], $mainDir); ?>

    <main>
        <h1>Gerar Relatório (PDF)</h1>
        <section class="container-form">
            <form action="./gerar-pdf.php" method="POST">
                <?php gerarInput("inicio", "date", "Data inicial", "", $mainDir); ?>
                <?php gerarInput("fim", "date", "Data final", "", $mainDir); ?>
                <div class="acoesForm">
                    <?php
                    gerarLink("../categorias", "Cancelar", "cancelar", $mainDir);
                    gerarButton("gerar", "Gerar", "padrao", true, $mainDir);
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