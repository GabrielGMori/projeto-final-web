<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['permissao'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../src/conexao-bd.php';
require_once '../src/Repositorio/UsuarioRepositorio.php';
require_once '../src/Componentes/header.php';
require_once '../src/Componentes/button.php';
require_once '../src/Componentes/input.php';

$erro = $_GET['erro'] ?? '';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];
$repoUsuario = new UsuarioRepositorio($pdo);
$usuario = $repoUsuario->buscarPorId($id);

if (!$usuario) {
    header('Location: index.php');
    exit;
}

$mainDir = '..';
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="../css/form.css" />
    <link rel="icon" href="../img/logo.png" type="image/x-icon" />
</head>

<body>
    <?php gerarHeader(true, true, $_SESSION['email'], $mainDir); ?>

    <main>
        <h1>Editar Usuário</h1>
        <section class="container-form">
            <form action="salvar.php" method="POST">
                <input class="disabled" id="id" name="id" type="number" value=<?php echo $usuario->getId(); ?>>
                <?php gerarInputComValue('email', 'email', 'E-mail', 'Digite o e-mail do usuário...', $usuario->getEmail(), $mainDir); ?>
                <?php gerarInput('senha', 'password', 'Senha', 'Deixe em branco para manter a atual...', $mainDir); ?>

                <div class="container-select">
                    <label for="permissao">Permissão:</label>
                    <select name="permissao" id="permissao" required>
                        <option value="user" <?= $usuario->getPermissao() === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= $usuario->getPermissao() === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <div class="acoesForm" style="margin-top: 1em;">
                    <?php
                    gerarLink('index.php', 'Cancelar', 'cancelar', $mainDir);
                    gerarButton('confirmar', 'Confirmar', 'admin', false, $mainDir);
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