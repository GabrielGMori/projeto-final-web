<?php
require_once 'button.php';

function gerarHeader(bool $mostrarUsuarios, string $estiloAdmin, string $email, string $mainDir)
{
    echo '<link rel="stylesheet" href="'. $mainDir .'/css/header.css">';
    echo '<header class="header-principal header-' . ($estiloAdmin == true ? 'admin' : 'user') . '">
            <div class="container-principal">
                <a href="categorias" class="botao-logo"><img src="'. $mainDir .'/img/Logo.png" alt="Início"></a>
                <nav>
                    <a href="categorias">Peças</a>
                    <a href="vendas">Vendas</a>
                    <a href="reposicoes">Reposições</a>
                    <a href="relatorios">Relatórios</a>
                    ' . ($mostrarUsuarios == true ? '<a href="usuarios">Usuários</a>' : '') . '
                </nav>
                <button class="botao-conta '.($email == '' ? 'hidden' : '').'" id="botao-conta"><img src="'. $mainDir .'/img/Conta.png" alt="Conta"></button>
            </div>
            <div class="container-conta hidden" id="container-conta">
            <p>Logado como:</p>
            <p><b>' . htmlspecialchars($email) . ($email == '' ? 'Deslogado' : '') . '</b></p>
            <form action="'.$mainDir.'/logout.php">';
    gerarButton("sair", "Sair", "cancelar", true, $mainDir);
    echo '</form></div></header>';
    echo '<script src="../js/header.js"></script>';
}
