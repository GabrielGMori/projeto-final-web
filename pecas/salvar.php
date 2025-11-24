<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/PecaRepositorio.php';

if (!isset($_POST['categoria_id'])) {
    header('Location: ../categorias');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pecas?categoria_id='.$_POST['categoria_id']);
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$estoque = trim($_POST['estoque'] ?? '');

if ($nome === '' || $estoque === '') {
    header('Location: ./criar.php?erro=campos-vazios&categoria_id='.$_POST['categoria_id']);
    exit;
}

$arquivoImagem = null;
if (isset($_FILES['imagem']) && !empty($_FILES['imagem']['tmp_name'])) {
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
            header('Location: ./criar.php?erro=processamento-imagem&categoria_id='.$_POST['categoria_id']);
            exit;
        }
    } else {
        header('Location: ./criar.php?erro=processamento-imagem&categoria_id='.$_POST['categoria_id']);
        exit;
    }
}

$repoPeca = new PecaRepositorio($pdo);
$repoPeca->criar($nome, (int)$estoque, $arquivoImagem, (int)$_POST['categoria_id']);
header('Location: ../pecas?categoria_id='.$_POST['categoria_id']);

exit;
