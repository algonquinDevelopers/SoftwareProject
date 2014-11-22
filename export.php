<?php

require_once("dompdf/dompdf_config.inc.php");
$html = $_POST['html'];
// $html = "planView.php";

$dompdf = new DOMPDF();
$dompdf->load_html_file($html);
$dompdf->render();
$dompdf->stream("sample.pdf");

?>