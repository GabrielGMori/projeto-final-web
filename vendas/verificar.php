<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/PecaRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    header('Location: criar.php');
    exit;
}

$repoPeca = new PecaRepositorio($pdo);

$redirectErro = $_GET['redirectErro'] ?? 'criar.php';
$redirectErroQuery = '';

$pecas = $_GET['pecas'] ?? [];
$pecasModificado = array_values($pecas);

switch ($redirectErro) {
    case 'selecionar/dados.php':
        if (!isset($_GET['categoria_id'])) {
            header('Location: ' . $redirectErro);
            exit;
        }
        $redirectErroQuery = "categoria_id=" . $_GET['categoria_id'];
        $adicionado = false;
        for ($i=0; $i<count($pecasModificado); $i++) {
            if ($pecasModificado[$i]['id'] == $_GET['id']) {
                $pecasModificado[$i]['quantidade'] = $_GET['quantidade'];
                $pecasModificado[$i]['preco'] = $_GET['preco'];
                $adicionado = true;
                break;
            }
        }
        if ($adicionado == true) {
            break;
        }
        $pecasModificado[] = ['id'=>$_GET['id'], 'quantidade'=>$_GET['quantidade'], 'preco'=>$_GET['preco']];
        break;

    default:
        $redirectErroQuery = "modo=editar";
        for ($i=0; $i<count($pecasModificado); $i++) {
            if ($pecasModificado[$i]['id'] == $_GET['id']) {
                $pecasModificado[$i]['quantidade'] = $_GET['quantidade'];
                $pecasModificado[$i]['preco'] = $_GET['preco'];
            }
        }
        break;
}

$redirectErroQuery = '&id=' . $_GET['id'] . '&' . $redirectErroQuery . '&' . http_build_query(["pecas" => $pecas]);

if (trim($_GET['quantidade'] ?? '') === '' || trim($_GET['preco'] ?? '') === '') {
    header('Location: ' . $redirectErro . '?erro=campos-vazios' . $redirectErroQuery);
    exit;
} elseif ((int)$_GET['quantidade'] > $repoPeca->buscarPorId($_GET['id'])->getEstoque()) {
    header('Location: ' . $redirectErro . '?erro=estoque-insuficiente' . $redirectErroQuery);
    exit;
}

header('Location: criar.php?'.http_build_query(["pecas" => $pecasModificado]));

exit;
