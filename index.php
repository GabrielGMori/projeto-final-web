<?php

require_once __DIR__ . '/src/Util/conexao-bd.php';

function salvar($pdo, $email, $senha, $permissao)
{
    $sql = "INSERT INTO usuario (email, senha, permissao) VALUES (?, ?, ?)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(1, $email);
    $statement->bindValue(2, $senha);
    $statement->bindValue(3, $permissao);
    $statement->execute();
}

salvar($pdo, "email@email.com", "secretpsw", "user");


require_once __DIR__ . '/src/Componentes/header.php';
