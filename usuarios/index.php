<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['permissao'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../src/Componentes/header.php';
require_once '../src/Componentes/input.php';
require_once '../src/Componentes/button.php';

require_once '../src/conexao-bd.php';
require_once '../src/Repositorio/UsuarioRepositorio.php';
require_once '../src/Componentes/header.php';
require_once '../src/criar-parametros-get-listas.php';

$erro = $_GET['erro'] ?? '';

$repoUsuario = new UsuarioRepositorio($pdo);

$limitePorPagina = isset($_GET['limite']) ? (int)$_GET['limite'] : 10;
$paginaAtual = isset($_GET['pagina']) && $_GET['pagina'] > 0 ? (int)$_GET['pagina'] : 1;

$total = $repoUsuario->contar();
$offset = ($paginaAtual - 1) * $limitePorPagina;
$totalPaginas = ceil($total / $limitePorPagina);

$usuarios = $repoUsuario->listarPaginado($limitePorPagina, $offset);

if (isset($_GET['id'])) {
    $_GET['id'] = (int) $_GET['id'];
    $selecionado = $repoUsuario->buscarPorId($_GET['id']);
}

$mainDir = '..';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Usuários</title>
    <link rel="stylesheet" href="../css/lista.css" />
    <link rel="icon" href="../img/logo.png" type="image/x-icon" />
</head>

<body>
    <?php gerarHeader(true, true, $_SESSION['email'], $mainDir); ?>

    <h1>Usuários</h1>
    <main>
        <div class="container-lista">
            <?php foreach ($usuarios as $usuario): ?>
                <div class="lista-item admin">
                    <h3 class="admin-text"><?= $usuario->getEmail() ?> <span><i><?= $usuario->getPermissao() ?></i></span></h3>

                    <div class="lista-item-acoes">
                        <a href="editar.php?id=<?= $usuario->getId() ?>" class="lista-item-editar">
                            <img src="../img/Editar.png" alt="Editar" />
                        </a>
                        <a href="<?= criarParamsGet('excluir', $usuario->getId(), $limitePorPagina, $paginaAtual, null); ?>" class="lista-item-excluir">
                            <img src="../img/Excluir.png" alt="Excluir" />
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="container-direita">
            <?php if (!isset($_GET['modo']) || !isset($_GET['id']) || $_GET['modo'] != 'excluir') : ?>
                <a href="criar.php" class="botao-add admin" id="botao-add"><img src="../img/Add.png" alt="Adicionar"></a>

            <?php elseif ($_GET['modo'] == 'excluir') : ?>
                <div class="container-excluir">
                    <p>Isso irá excluir permanentemente:</p>
                    <br>
                    <p><b><?php echo htmlspecialchars($selecionado->getEmail()); ?></b></p>
                    <br>
                    <div class="acoes">
                        <?php
                        gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, $paginaAtual, null), "Cancelar", "cancelar", $mainDir);
                        gerarLink('excluir.php?id=' . $selecionado->getId() . '', "Confirmar", "admin", $mainDir);
                        ?>
                    </div>

                    <?php if ($erro === 'usando-conta'): ?>
                        <p class="mensagem-erro">Este usuário está sendo usado no momento, faça login com outro e tente novamente.</p>
                    <?php endif; ?>
                </div>

            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container-limite">
            <form class="form-limite" method="GET" action=".">
                <label for="limite">Itens por página:</label>
                <select name="limite" id="limite" onchange="this.form.submit()">
                    <option value="5" <?= $limitePorPagina == 5 ? 'selected' : '' ?>>5</option>
                    <option value="10" <?= $limitePorPagina == 10 ? 'selected' : '' ?>>10</option>
                    <option value="20" <?= $limitePorPagina == 20 ? 'selected' : '' ?>>20</option>
                    <option value="50" <?= $limitePorPagina == 50 ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= $limitePorPagina == 100 ? 'selected' : '' ?>>100</option>
                    <option value="1000" <?= $limitePorPagina == 1000 ? 'selected' : '' ?>>1000</option>
                </select>
            </form>
        </div>
        <div class="container-pagina">
            <?php if ($totalPaginas > 1): ?>
                <?php
                if ($paginaAtual > 1):
                    gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, $paginaAtual - 1, null), "<", "paginacao", $mainDir);
                    gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, 1, null), "1", "paginacao", $mainDir);
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
                                <?php
                                else:
                                    gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, $i, null), $i, "paginacao", $mainDir);
                                endif;
                            endif;
                        endfor;

                        for ($i = $paginaAtual + 1; $i <= $paginaAtual + 2; $i++):
                            if ($i > 1 && $i < $totalPaginas):
                                if ($i == $paginaAtual): ?>
                                    <span class="paginacao-disabled"><?= $i ?></span>
                            <?php
                                else:
                                    gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, $i, null), $i, "paginacao", $mainDir);
                                endif;
                            endif;
                        endfor;

                        if ($paginaAtual + 3 < $totalPaginas): ?>
                            <span class="paginacao-disabled">...</span>
                        <?php endif;

                        if ($paginaAtual < $totalPaginas):
                            gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, $totalPaginas, null), $totalPaginas, "paginacao", $mainDir);
                            gerarLink('.' . criarParamsGet(null, null, $limitePorPagina, $paginaAtual + 1, null), ">", "paginacao", $mainDir);
                        else: ?>
                            <span class="paginacao-disabled"><?= $totalPaginas ?></span>
                            <span class="paginacao-disabled">></span>
                        <?php endif; ?>
                    <?php endif; ?>
        </div>
    </footer>
</body>

</html>