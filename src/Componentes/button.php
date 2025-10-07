<?php
function gerarButton(string $texto, string $temaDeCores, bool $widthTotal, bool $submit) {
    echo '<link rel="stylesheet" href="css/button.css">';
    echo '<button '.($submit == true ? 'type="submit"' : '').' class="botao botao-'.htmlspecialchars($temaDeCores).' '.($widthTotal == true ? '' : 'fit-content').'">'.htmlspecialchars($texto).'</button>';
}