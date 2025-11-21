<?php

function criarParamsGet(?string $modo, ?int $id, int $limite, int $pagina) : string {
    $limite = $limite == 10 ? null : $limite;
    $pagina = $pagina == 1 ? null : $pagina;

    $params = "";
    if ($modo != null) {
        $params = strlen($params) == 0 ? "?" : $params . "&";
        $params = $params . "modo=" . $modo;
    }
    if ($id != null) {
        $params = strlen($params) == 0 ? "?" : $params . "&";
        $params = $params . "id=" . $id;
    }
    if ($limite != null) {
        $params = strlen($params) == 0 ? "?" : $params . "&";
        $params = $params . "limite=" . $limite;
    }
    if ($pagina != null) {
        $params = strlen($params) == 0 ? "?" : $params . "&";
        $params = $params . "pagina=" . $pagina;
    }

    return $params;
}
