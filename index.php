<?php

require_once __DIR__ . '/src/Util/conexao-bd.php';
require_once __DIR__ . '/src/Repositorio/UsuarioRepositorio.php';
require_once __DIR__ . '/src/Repositorio/CategoriaRepositorio.php';
require_once __DIR__ . '/src/Componentes/header.php';

$repoUsuario = new UsuarioRepositorio($pdo);

if ($repoUsuario->buscarPorEmail("admin@admin.com")) {
    echo "<h1>Usuário existe</h1>";
} else {
    echo "<h1>Usuário criado</h1>";
    $repoUsuario->criar("admin@admin.com", "12345", "admin");
}

$usuarios = $repoUsuario->listar();
echo "<h1>usuarios:</h1>";
foreach ($usuarios as $usuario) {
    echo "<h4>".$usuario->getEmail()."</h4>";
}

echo "<h1>Categorias - Antes</h1>";

$repoCategoria = new CategoriaRepositorio($pdo);

$categorias = $repoCategoria->listar();
if (count($categorias) == 0) {
    $repoCategoria->criar("Acessórios");
    $repoCategoria->criar("Roupas de Inverno");
    $repoCategoria->criar("Roupas de Verão");
    $categorias = $repoCategoria->listar();
}

foreach ($categorias as $categoria) {
    echo "<p>". $categoria->getId() . $categoria->getNome() ."</p>";
}

$repoCategoria->editar(new Categoria(1, "Acessórios de Rosto"));
$repoCategoria->remover(2);

echo "<h1>Categorias - Antes</h1>";

foreach ($categorias as $categoria) {
    echo "<p>". $categoria->getId() . $categoria->getNome() ."</p>";
}

echo "<h1>Categorias - Depois</h1>";

$categorias = $repoCategoria->listar();

foreach ($categorias as $categoria) {
    echo "<p>". $categoria->getId() . $categoria->getNome() ."</p>";
}
