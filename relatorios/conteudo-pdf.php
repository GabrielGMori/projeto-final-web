<?php

require "../src/conexao-bd.php";
require "../src/Repositorio/VendaRepositorio.php";
require "../src/Repositorio/ReposicaoRepositorio.php";
require "../src/Repositorio/PecaRepositorio.php";
require "../src/Repositorio/CategoriaRepositorio.php";

date_default_timezone_set('America/Sao_Paulo'); // ajuste conforme sua timezone
$rodapeDataHora = date('d/m/Y H:i');

$repoVenda = new VendaRepositorio($pdo);
$repoReposicao = new ReposicaoRepositorio($pdo);
$repoPeca = new PecaRepositorio($pdo);
$repoCategoria = new CategoriaRepositorio($pdo);

$totalVendas = 0;
$vendas = $repoVenda->listarPorData($inicio, $fim);
$vendasPecas = [];
foreach ($vendas as $venda) {
    $pecas = $repoVenda->getPecas($venda->getId());
    foreach ($pecas as $peca) {
        $adicionada = false;
        foreach ($vendasPecas as $i => $pecaAdicionada) {
            if ($pecaAdicionada['id'] == $peca['id']) {
                $vendasPecas[$i]['quantidade'] += $peca['quantidade'];
                $vendasPecas[$i]['preco'] += $peca['preco'];
                $adicionada = true;
            }
        }
        if ($adicionada === false) {
            $vendasPecas[] = $peca;
        }
        $totalVendas += $peca['preco'];
    }
}

$totalReposicoes = 0;
$Reposicoes = $repoReposicao->listarPorData($inicio, $fim);
$reposicoesPecas = [];
foreach ($Reposicoes as $Reposicao) {
    $pecas = $repoReposicao->getPecas($Reposicao->getId());
    foreach ($pecas as $peca) {
        $adicionada = false;
        foreach ($reposicoesPecas as $i => $pecaAdicionada) {
            if ($pecaAdicionada['id'] === $peca['id']) {
                $reposicoesPecas[$i]['quantidade'] += $peca['quantidade'];
                $reposicoesPecas[$i]['preco'] += $peca['preco'];
                $adicionada = true;
            }
        }
        if ($adicionada === false) {
            $reposicoesPecas[] = $peca;
        }
        $totalReposicoes += $peca['preco'];
    }
}

$lucroTotal = $totalVendas - $totalReposicoes;
$prefixoLucro = "+";
if ($lucroTotal < 0) {
    $prefixoLucro = "-";
    $lucroTotal = -$lucroTotal;
}

?>
<head>
    <meta charset="UTF-8">

<style>
    body,
    table,
    th,
    td,
    h3 {
        font-family: Arial, Helvetica, sans-serif;
    }

    table {
        width: 90%;
        margin: auto 0;
    }

    table,
    th,
    td {
        border: 2px solid #000;
        
    }

    table th {
        padding: 11px 0 11px;
        font-weight: bold;
        font-size: 14px;
        text-align: left;
        padding: 8px;
    }

    table tr {
        border: 1px solid #000;
    }

    table td {
        font-size: 12px;
        padding: 8px;
    }

    h3 {
        margin-top: 0.5rem;
        margin-bottom: 1rem;
    }

    h1 {
        text-align: center;
        margin-top: 40px;
        font-size: 30px;
    }

    .pdf-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 30px;
        text-align: center;
        font-size: 12px;
        color: #444;
        border-top: 1px solid #ddd;
        padding-top: 6px;
    }

    /* Dá margem inferior para que o conteúdo da tabela não fique sobre o rodapé */
    body {
        margin-bottom: 50px;
        margin-top: 0;
    }

    .pdf-img {
        width: 100px;
    }
</style>
</head>

<h1>Relatório <?= $inicio->format('d/m/Y') ?> - <?= $fim->format('d/m/Y') ?></h1>

<br>

<h2>Lucro total: <?= $prefixoLucro ?>R$ <?= number_format($lucroTotal, 2, ",", ".") ?></h2>

<br>

<h3>Vendas - Total: R$ <?= number_format($totalVendas, 2, ",", ".") ?></h3>

<table>
    <thead>
        <tr>
            <th>Peça</th>
            <th>Categoria</th>
            <th>Quantidade</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vendasPecas as $vendaPeca): ?>
            <?php $peca = $repoPeca->buscarPorId($vendaPeca['id']); ?>
            <?php $categoria = $repoCategoria->buscarPorId($peca->getCategoriaId()); ?>
            <tr>
                <td><?= $peca->getNome() ?></td>
                <td><?= $categoria->getNome() ?></td>
                <td><?= $vendaPeca['quantidade'] ?></td>
                <td><?= $vendaPeca['preco'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>

<h3>Reposições - Total: R$ <?= number_format($totalReposicoes, 2, ",", ".") ?></h3>

<table>
    <thead>
        <tr>
            <th>Peça</th>
            <th>Categoria</th>
            <th>Quantidade</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reposicoesPecas as $reposicaoPeca): ?>
            <?php $peca = $repoPeca->buscarPorId($reposicaoPeca['id']); ?>
            <?php $categoria = $repoCategoria->buscarPorId($peca->getCategoriaId()); ?>
            <tr>
                <td><?= $peca->getNome() ?></td>
                <td><?= $categoria->getNome() ?></td>
                <td><?= $reposicaoPeca['quantidade'] ?></td>
                <td><?= $reposicaoPeca['preco'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="pdf-footer">
    Gerado em: <?= htmlspecialchars($rodapeDataHora) ?>
</div>