<?php
function gerarInput(string $id, string $type, string $label, string $placeholder, string $mainDir)
{
    echo '<link rel="stylesheet" href="'.htmlspecialchars($mainDir).'/css/input.css">';
    echo '<label class="label-padrao" for="' . htmlspecialchars($id) . '">' . htmlspecialchars($label) . '</label>';
    echo '<input class="input-padrao" type="' . htmlspecialchars($type) . '" id="' . htmlspecialchars($id) . '" name="' . htmlspecialchars($id) . '" placeholder="' . htmlspecialchars($placeholder) . '">';
}

function gerarInputComValue(string $id, string $type, string $label, string $placeholder, string $value, string $mainDir)
{
    echo '<link rel="stylesheet" href="'.htmlspecialchars($mainDir).'/css/input.css">';
    echo '<label class="label-padrao" for="' . htmlspecialchars($id) . '">' . htmlspecialchars($label) . '</label>';
    echo '<input class="input-padrao" type="' . htmlspecialchars($type) . '" id="' . htmlspecialchars($id) . '" name="' . htmlspecialchars($id) . '" placeholder="' . htmlspecialchars($placeholder) . '" value="' . htmlspecialchars($value) . '">';
}

function gerarInputImagem(string $id, string $accept, string $label, string $mainDir) {
    echo '<link rel="stylesheet" href="'.htmlspecialchars($mainDir).'/css/input.css">';
    echo '<label class="label-imagem" for="'.htmlspecialchars($id).'">'.htmlspecialchars($label).'</label>';
    echo '<input class="input-imagem" id="'.htmlspecialchars($id).'" name="'.htmlspecialchars($id).'" type="file" accept="'.htmlspecialchars($accept).'">';
}
