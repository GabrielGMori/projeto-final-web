<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
}

if (empty($_POST['inicio']) || empty($_POST['fim'])) {
    var_dump("aaa");
    header('Location: ../relatorios?erro=campos-vazios');
    exit;
}

require "../vendor/autoload.php";

use Dompdf\Dompdf;
$dompdf = new Dompdf();
ob_start();

$inicio = new DateTime($_POST['inicio']);
$fim = new DateTime($_POST['fim']);
$fim->modify('+23 hours 59 minutes 59 seconds');
require "conteudo-pdf.php";

$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4');
$dompdf->render();
$filename = 'Relatorio-Loja-Roupas-' . date('dmY') . '.pdf';
$dompdf->stream($filename, ['Attachment' => 1]);
