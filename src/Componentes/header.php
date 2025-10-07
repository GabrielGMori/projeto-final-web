<?php
require_once 'button.php';

function gerarHeader(bool $admin, string $email)
{
    echo '<link rel="stylesheet" href="css/header.css">';
    echo '<header class="header-principal header-' . ($admin == true ? 'admin' : 'user') . '">
            <div class="container-principal">
                <a href="categorias.php" class="botao-logo"><img src="img/Logo.png" alt="Início"></a>
                <nav>
                    <a href="categorias.php">Peças</a>
                    <a href="vendas.php">Vendas</a>
                    <a href="reposicoes.php">Reposições</a>
                    <a href="relatorios.php">Relatórios</a>
                    ' . ($admin == true ? '<a href="usuarios.php">Usuários</a>' : '') . '
                </nav>
                <button class="botao-conta '.($email == '' ? 'hidden' : '').'" id="botao-conta"><img src="img/Conta.png" alt="Conta"></button>
            </div>
            <div class="container-conta hidden" id="container-conta">
            <p>Logado como:</p>
            <p><b>' . htmlspecialchars($email) . ($email == '' ? 'Deslogado' : '') . '</b></p>
            <form action="logout.php">';
    gerarButton("Sair", "cancelar", false, true);
    echo '</form></div></header>';
    echo '<script src="js/header.js"></script>';
}
