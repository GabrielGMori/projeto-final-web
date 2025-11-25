<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['permissao'] !== 'admin') {
    header('Location: ../login.php');
    exit;
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Criar Usuário</title>
    <link rel="stylesheet" href="../css/form.css" />
    <link rel="icon" href="../img/logo.png" type="image/x-icon" />
</head>

<body>
    <?php gerarHeader(true, true, $_SESSION['email'], $mainDir); ?>

    <main>
        <h1>Criar Novo Usuário</h1>
        <section class="container-form">
            <form action="salvar.php" method="POST">
                <?php gerarInput('email', 'email', 'E-mail', 'Digite o e-mail do usuário...', $mainDir); ?>
                <?php gerarInput('senha', 'password', 'Senha', 'Digite a senha do usuário...', $mainDir); ?>

                <div class="container-select">
                    <label for="permissao">Permissão:</label>
                    <select name="permissao" id="permissao" required>
                        <option value="user" selected>User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="acoesForm" style="margin-top: 1em;">
                    <?php
                    gerarLink('index.php', 'Cancelar', 'cancelar', $mainDir);
                    gerarButton('criar', 'Criar', 'admin', false, $mainDir);
                    ?>
                </div>
            </form>

            <?php if ($erro === 'campos-vazios'): ?>
                <p class="mensagem-erro">Por favor, preencha todos os campos.</p>
            <?php elseif ($erro === 'email-existente'): ?>
                <p class="mensagem-erro">Este email já está registrado.</p>
            <?php endif; ?>
        </section>
    </main>

</body>

</html>
