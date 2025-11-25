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

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: index.php');
    exit;
}

$repoUsuario = new UsuarioRepositorio($pdo);
$usuario = $repoUsuario->buscarPorId((int)$id);
if (!$usuario) {
    header('Location: index.php');
    exit;
}

$erro = $_GET['erro'] ?? '';
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
<?php gerarHeader(true, false, $_SESSION['email'], $mainDir); ?>

<main>
    <h1>Editar Usuário</h1>
    <section class="container-form">
        <form action="salvar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario->getId()); ?>" />
            <?php gerarInput('email', 'email', 'Email', 'Digite o email do usuário...', $mainDir, $usuario->getEmail()); ?>
            <?php gerarInput('senha', 'password', 'Senha', 'Deixe em branco para manter a atual', $mainDir, ''); ?>
            <label for="permissao">Permissão:</label>
            <select name="permissao" id="permissao" required>
                <option value="admin" <?php if ($usuario->getPermissao() === 'admin') echo 'selected'; ?>>Admin</option>
                <option value="user" <?php if ($usuario->getPermissao() === 'user') echo 'selected'; ?>>Usuário</option>
            </select>
            <div class="acoesForm" style="margin-top: 1em;">
                <?php
                gerarLink('index.php', 'Cancelar', 'cancelar', $mainDir);
                gerarButton('editar', 'Salvar', 'padrao', false, $mainDir);
                ?>
            </div>
        </form>
        <?php if ($erro === 'campos-vazios'): ?>
            <p class="mensagem-erro">Por favor, preencha todos os campos obrigatórios, exceto senha para mantê-la.</p>
        <?php elseif ($erro === 'email-existente'): ?>
            <p class="mensagem-erro">Este email já está registrado.</p>
        <?php endif; ?>
    </section>
</main>

</body>
</html>
