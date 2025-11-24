<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Peca.php';
require_once __DIR__ . '/../src/Repositorio/PecaRepositorio.php';

if (!isset($_POST['categoria_id'])) {
    header('Location: ../categorias');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    header('Location: ../pecas?categoria_id='.$_POST['categoria_id']);
    exit;
}

$repoPeca = new PecaRepositorio($pdo);

if (!isset($_FILES['imagem'])) {
    $nome = trim($_POST['nome'] ?? '');
    $estoque = trim($_POST['estoque'] ?? '');

    if ($nome === '' || $estoque === '') {
        header('Location: ../pecas?modo=editar&id='.$_POST['id'].'&erro=campos-vazios&categoria_id='.$_POST['categoria_id']);
        exit;
    }
    $peca = $repoPeca->buscarPorId($_POST['id']);
    $arquivoImagem = $peca->getImagem();
    $repoPeca->editar(new Peca($_POST['id'], $nome, (int)$estoque, $arquivoImagem ?? null, (int)$_POST['categoria_id']));
    header('Location: ../pecas?categoria_id='.$_POST['categoria_id']);

} else {
    if (empty($_FILES['imagem']['tmp_name'])) {
        header('Location: ./info.php?erro=imagem-vazia&id='.$_POST['id'].'&categoria_id='.$_POST['categoria_id']);
        exit;
    }

    $uploadsDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
    }

    $tmpPath = $_FILES['imagem']['tmp_name'];
    $imgInfo = @getimagesize($tmpPath);
    if ($imgInfo !== false) {
        $mime = $imgInfo['mime'];
        $ext = '';
        switch ($mime) {
            case 'image/jpeg':
                $ext = '.jpg';
                break;
            case 'image/png':
                $ext = '.png';
                break;
            case 'image/gif':
                $ext = '.gif';
                break;
            default:
                $ext = image_type_to_extension($imgInfo[2]) ?: '';
        }

        $arquivoImagem = uniqid('img_', true) . $ext;
        $destination = $uploadsDir . $arquivoImagem;

        if (!move_uploaded_file($tmpPath, $destination)) {
            header('Location: ./info.php?erro=processamento-imagem&id='.$_POST['id'].'&categoria_id='.$_POST['categoria_id']);
            exit;
        }
    } else {
        header('Location: ./info.php?erro=processamento-imagem&id='.$_POST['id'].'&categoria_id='.$_POST['categoria_id']);
        exit;
    }
    $peca = $repoPeca->buscarPorId($_POST['id']);
    $repoPeca->editar(new Peca($_POST['id'], $peca->getNome(), (int)$peca->getEstoque(), $arquivoImagem, (int)$_POST['categoria_id']));
    header('Location: ./info.php?id='.$_POST['id'].'&categoria_id='.$_POST['categoria_id']);
}

exit;
