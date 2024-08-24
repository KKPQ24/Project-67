<?php
require_once('vendor/setasign/fpdf/fpdf.php');
require_once('vendor/setasign/fpdi/src/autoload.php');

use setasign\Fpdi\Fpdi;

$pdf = new Fpdi();

$pdf->AddPage();

$pdf->setSourceFile('downloadfile/test.pdf');

$tplIdx = $pdf->importPage(1);

$size = $pdf->getTemplateSize($tplIdx);

$pdf->useTemplate($tplIdx, 0, 0, $size['width'], $size['height'], true);

$pdf->SetFont('Arial', '', 13);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(20, 50);
$pdf->Write(0, 'gift code');

$pdf->Output('gift_coupon_generated.pdf', 'D');
?>
