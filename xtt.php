<?php
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;

// Créer le fichier Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Bonjour Gamaliel');
$sheet->setCellValue('A2', 'Ce document sera exporté en PDF');

// Définir le moteur PDF (ici mPDF)
\PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', Mpdf::class);

// Créer le writer PDF
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');

// Sauvegarder le PDF sur le serveur
$writer->save('document.pdf');

?>