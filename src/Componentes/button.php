<?php
function gerarButton(string $id, string $texto, string $temaDeCores, bool $submit, string $mainDir)
{
    echo '<link rel="stylesheet" href="'.htmlspecialchars($mainDir).'/css/button.css">';
    echo '<button id="' . htmlspecialchars($id) . '" ' . ($submit == true ? 'type="submit"' : '') . ' class="botao botao-' . htmlspecialchars($temaDeCores)  . '">' . htmlspecialchars($texto) . '</button>';
}

function gerarLink(string $href, string $texto, string $temaDeCores, string $mainDir)
{
    echo '<link rel="stylesheet" href="'.htmlspecialchars($mainDir).'/css/button.css">';
    echo '<a href="' . htmlspecialchars($href) . '" class="botao botao-' . htmlspecialchars($temaDeCores) . '">' . htmlspecialchars($texto) . '</a>';
}
