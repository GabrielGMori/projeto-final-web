<?php
function gerarInput(string $id, string $type, string $label, string $placeholder)
{
    echo '<link rel="stylesheet" href="css/input.css">';
    echo '<label class="label-padrao" for="' . htmlspecialchars($id) . '">' . htmlspecialchars($label) . '</label>';
    echo '<input class="input-padrao" type="' . htmlspecialchars($type) . '" id="' . htmlspecialchars($id) . '" name="' . htmlspecialchars($id) . '" placeholder="' . htmlspecialchars($placeholder) . '">';
}

function gerarInputComValue(string $id, string $type, string $label, string $placeholder, string $value)
{
    echo '<link rel="stylesheet" href="css/input.css">';
    echo '<label class="label-padrao" for="' . htmlspecialchars($id) . '">' . htmlspecialchars($label) . '</label>';
    echo '<input class="input-padrao" type="' . htmlspecialchars($type) . '" id="' . htmlspecialchars($id) . '" name="' . htmlspecialchars($id) . '" placeholder="' . htmlspecialchars($placeholder) . '" value="' . htmlspecialchars($value) . '">';
}
