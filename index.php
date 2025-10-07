<?php
session_start();

require_once 'src/conexao-bd.php';
require_once 'src/Repositorio/UsuarioRepositorio.php';

echo '<link rel="stylesheet" href="css/reset.css">';

$repoUsuario = new UsuarioRepositorio($pdo);
if (!$repoUsuario->buscarPorEmail("admin@admin.com")) {
    $repoUsuario->criar("admin@admin.com", "12345", "admin");
    echo '<p>Usuário admin criado!</p>';
} else {
    echo '<p>Usuário admin já existe!</p>';
}

echo '<br>';
echo '<p>Credenciais para login:</p>';
echo '<br>';
echo '<p>Usuário: admin@admin.com</p>';
echo '<p>Senha: 12345</p>';
echo '<br>';
echo '<p>Esta é uma tela temporária para testes!</p>';
echo '<br>';
echo '<a href="login.php">Tela de Login</a>';

// if (!isset($_SESSION['usuario'])) {
//     header('Location: login.php');
//     exit;
// }
// header('Location: categorias.php');
