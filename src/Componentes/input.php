<?php
function gerarInput(string $name, string $type, string $label, string $placeholder, string $mainDir)
{
    echo '<link rel="stylesheet" href="'.htmlspecialchars($mainDir).'/css/input.css">';
    echo '<label class="label-padrao" for="' . htmlspecialchars($name) . '">' . htmlspecialchars($label) . '</label>';
    echo '<input class="input-padrao" type="' . htmlspecialchars($type) . '" min="0" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '" placeholder="' . htmlspecialchars($placeholder) . '">';
}

function gerarInputComValue(string $name, string $type, string $label, string $placeholder, string $value, string $mainDir)
{
    echo '<link rel="stylesheet" href="'.htmlspecialchars($mainDir).'/css/input.css">';
    echo '<label class="label-padrao" for="' . htmlspecialchars($name) . '">' . htmlspecialchars($label) . '</label>';
    echo '<input class="input-padrao" type="' . htmlspecialchars($type) . '" min="0" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '" placeholder="' . htmlspecialchars($placeholder) . '" value="' . htmlspecialchars($value) . '">';
}

function gerarInputDecimal(string $name, string $step, string $label, string $placeholder, string $mainDir) {
    echo '<link rel="stylesheet" href="'.htmlspecialchars($mainDir).'/css/input.css">';
    echo '<label class="label-padrao" for="' . htmlspecialchars($name) . '">' . htmlspecialchars($label) . '</label>';
    echo '<input class="input-padrao" type="number" step="' . htmlspecialchars($step) . '" min="0" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '" placeholder="' . htmlspecialchars($placeholder) . '">';
}

function gerarInputDecimalComValue(string $name, string $step, string $label, string $placeholder, string $value, string $mainDir) {
    echo '<link rel="stylesheet" href="'.htmlspecialchars($mainDir).'/css/input.css">';
    echo '<label class="label-padrao" for="' . htmlspecialchars($name) . '">' . htmlspecialchars($label) . '</label>';
    echo '<input class="input-padrao" type="number" step="' . htmlspecialchars($step) . '" min="0" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '" placeholder="' . htmlspecialchars($placeholder) . '" value="' . htmlspecialchars($value) . '">';
}

function gerarInputImagem(string $name, string $accept, string $label, string $mainDir) {
    echo '<link rel="stylesheet" href="'.htmlspecialchars($mainDir).'/css/input.css">';
    echo '<label class="label-imagem" for="'.htmlspecialchars($name).'">'.htmlspecialchars($label).'</label>';
    echo '<input class="input-imagem" min="0" id="'.htmlspecialchars($name).'" name="'.htmlspecialchars($name).'" type="file" accept="'.htmlspecialchars($accept).'">';
}
