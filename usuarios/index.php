<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['permissao'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../src/conexao-bd.php';
require_once '../src/Repositorio/UsuarioRepositorio.php';
require_once '../src/Componentes/header.php';
require_once '../src/criar-parametros-get-listas.php';

$repoUsuario = new UsuarioRepositorio($pdo);

$limitePorPagina = isset($_GET['limite']) ? (int)$_GET['limite'] : 10;
$paginaAtual = isset($_GET['pagina']) && $_GET['pagina'] > 0 ? (int)$_GET['pagina'] : 1;

$total = $repoUsuario->contar();
$offset = ($paginaAtual - 1) * $limitePorPagina;
$totalPaginas = ceil($total / $limitePorPagina);

$usuarios = $repoUsuario->listarPaginado($limitePorPagina, $offset);

$mainDir = '..';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Usuários</title>
    <link rel="stylesheet" href="../css/lista-usuarios.css" />
    <link rel="icon" href="../img/logo.png" type="image/x-icon" />
</head>
<body>
<?php gerarHeader(true, false, $_SESSION['email'], $mainDir); ?>

<h1>Gestão de Usuários</h1>
<main>
    <div class="container-lista">
        <?php foreach ($usuarios as $usuario): ?>
        <div class="lista-item">
            <div>
                <strong>Email:</strong> <?php echo htmlspecialchars($usuario->getEmail()); ?><br />
                <strong>Permissão:</strong> <?php echo htmlspecialchars($usuario->getPermissao()); ?>
            </div>
            <div class="lista-item-acoes">
                <a href="editar.php<?php echo criarParamsGet('editar', $usuario->getId(), $limitePorPagina, $paginaAtual, null); ?>" class="lista-item-editar">
                    <img src="../img/Editar.png" alt="Editar" />
                </a>
                <a href="excluir.php<?php echo criarParamsGet('excluir', $usuario->getId(), $limitePorPagina, $paginaAtual, null); ?>" class="lista-item-excluir">
                    <img src="../img/Excluir.png" alt="Excluir" />
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="container-direita">
        <a href="criar.php" class="botao-add" id="botao-add">
            <img src="../img/Add.png" alt="Adicionar" />
        </a>
    </div>
</main>

<footer>
    <div class="container-limite">
        <form class="form-limite" method="GET" action=".">
            <label for="limite">Itens por página:</label>
            <select name="limite" id="limite" onchange="this.form.submit()">
                <option value="5" <?php if ($limitePorPagina == 5) echo 'selected'; ?>>5</option>
                <option value="10" <?php if ($limitePorPagina == 10) echo 'selected'; ?>>10</option>
                <option value="20" <?php if ($limitePorPagina == 20) echo 'selected'; ?>>20</option>
                <option value="50" <?php if ($limitePorPagina == 50) echo 'selected'; ?>>50</option>
                <option value="100" <?php if ($limitePorPagina == 100) echo 'selected'; ?>>100</option>
                <option value="1000" <?php if ($limitePorPagina == 1000) echo 'selected'; ?>>1000</option>
            </select>
        </form>
    </div>
    <div class="container-pagina">
        <?php if ($totalPaginas > 1): ?>
            <?php
            if ($paginaAtual > 1):
                echo '<a href="'. criarParamsGet(null, null, $limitePorPagina, $paginaAtual - 1, null) .'" class="paginacao"><</a>';
                echo '<a href="'. criarParamsGet(null, null, $limitePorPagina, 1, null) .'" class="paginacao">1</a>';
            else: ?>
                <span class="paginacao-disabled"><</span>
                <span class="paginacao-disabled">1</span>
            <?php endif;

            if ($paginaAtual - 2 > 1): ?>
                <span class="paginacao-disabled">...</span>
            <?php endif;

            for ($i = $paginaAtual - 1; $i <= $paginaAtual; $i++):
                if ($i > 1 && $i < $totalPaginas):
                    if ($i == $paginaAtual): ?>
                        <span class="paginacao-disabled"><?= $i ?></span>
                    <?php else: ?>
                        <a href="<?php echo criarParamsGet(null, null, $limitePorPagina, $i, null); ?>" class="paginacao"><?= $i ?></a>
                    <?php endif;
                endif;
            endfor;

            for ($i = $paginaAtual + 1; $i <= $paginaAtual + 2; $i++):
                if ($i > 1 && $i < $totalPaginas):
                    if ($i == $paginaAtual): ?>
                        <span class="paginacao-disabled"><?= $i ?></span>
                    <?php else: ?>
                        <a href="<?php echo criarParamsGet(null, null, $limitePorPagina, $i, null); ?>" class="paginacao"><?= $i ?></a>
                    <?php endif;
                endif;
            endfor;

            if ($paginaAtual + 3 < $totalPaginas): ?>
                <span class="paginacao-disabled">...</span>
            <?php endif;

            if ($paginaAtual < $totalPaginas):
                echo '<a href="'. criarParamsGet(null, null, $limitePorPagina, $totalPaginas, null) .'" class="paginacao">'. $totalPaginas .'</a>';
                echo '<a href="'. criarParamsGet(null, null, $limitePorPagina, $paginaAtual + 1, null) .'" class="paginacao">></a>';
            else: ?>
                <span class="paginacao-disabled"><?= $totalPaginas ?></span>
                <span class="paginacao-disabled">></span>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</footer>
</body>
</html>
