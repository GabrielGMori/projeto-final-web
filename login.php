<?php
session_start();
if (isset($_SESSION['email'])) {
    header('Location: categorias.php');
}

$erro = $_GET['erro'] ?? '';

require_once 'src/Componentes/header.php';
require_once 'src/Componentes/button.php';
require_once 'src/Componentes/input.php';
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title>Login - Loja Roupas</title>
</head>

<body>
    <?php gerarHeader(false, ''); ?>

    <main>
        <h1>Login</h1>
        <section class="container-form">
            <form action="autenticar.php" method="POST">
                <?php
                gerarInput("email", "email", "E-mail", "Digite o seu e-mail");
                gerarInput("senha", "password", "Senha", "Digite a sua senha");
                gerarButton("Entrar", "padrao", false, true);
                ?>
            </form>

            <?php if ($erro === 'credenciais-erradas'): ?>
                <p class="mensagem-erro">Usuário ou senha incorretos.</p>
            <?php elseif ($erro === 'campos-vazios'): ?>
                <p class="mensagem-erro">Por favor, preencha o e-mail e senha.</p>
            <?php endif; ?>
        </section>
    </main>

</body>

</html>