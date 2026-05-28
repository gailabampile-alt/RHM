<?php
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


    include_once('sys_connexion.php');

    // Création du document
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 🔖 Titre principal
    $drawing = new Drawing();
    $drawing->setName('Logo');
    $drawing->setPath('img/404.png');
    $drawing->setCoordinates('A1');
    $drawing->setWorksheet($sheet);

    $sheet->mergeCells('A1:H1');    $sheet->mergeCells('A5:H5');
    $sheet->mergeCells('A2:H2');    $sheet->mergeCells('A6:H6');
    $sheet->mergeCells('A3:H3');    $sheet->mergeCells('A7:H7');
    $sheet->mergeCells('A4:H4');    $sheet->mergeCells('A8:H8');
    $sheet->mergeCells('A1:A8');

    $sheet->setCellValue('A1', "CAISSE GENERALE D'EPARGNE DU CONGO");
    $sheet->setCellValue('A2', "Société Anonyme Unipersonnelle - \"CADECO S.A\"");
    $sheet->setCellValue('A3', "38, Av Cadeco/ Kinshasa - Gombe");
    $sheet->setCellValue('A4', "CD/KIN/RCCM/ 14-B-04334");
    $sheet->setCellValue('A5', "ID. NAT : 01-510-N 59769N");
    $sheet->setCellValue('A6', "NIF : A0905417Z");
    $sheet->setCellValue('A7', "Votre banque de famille, votre banque de proximité");
    $sheet->setCellValue('A8', "LISTE DES AGENTS A LA DATE DU " . date('d/m/Y'));
    //$sheet->setCellValue('A1', "LISTE DES AGENTS A LA DATE DU " . date('d/m/Y'));
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    //$sheet->getStyle('A2')->getFont()->setBold(false)->setSize(14);
    $sheet->getStyle('A8')->getFont()->setBold(true)->setSize(16);

    

    
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // 🧾 En-têtes de colonnes
     //$sheet->freezePane('A2'); // Fige la ligne 1
    $headers = ['N°', 'Référence', 'Montant payé', 'Montant validé', 'Montant non validé', 'Montant frais', 'Montant net', 'Entité'];
    $sheet->fromArray($headers, null, 'A9');
    $sheet->setAutoFilter('A9:H9'); // Ajout du filtre ici
    $sheet->getStyle('A9:H9')->getFont()->setBold(true);
    $sheet->getStyle('A9:H9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A9:H9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9D9D9');


    $reqInfoAgent = $db->prepare('SELECT * FROM bdd_paie.v_info_agent WHERE code_activ = :code_activ');
    $reqInfoAgent->bindvalue('code_activ','01');
    $reqInfoAgent ->execute();
    $row = 10; // Commence à la ligne 11 pour les données
    $counter = 1; // Compteur pour la colonne N°
    //$data[] = ""; // Ajouter les en-têtes au tableau de données
    
    //$sheet->fromArray($data, null, 'A4');
    while ($resInfoAgent=$reqInfoAgent->fetch()){
        $matricule = $resInfoAgent['matricule'];
        $nomComplet = $resInfoAgent['nom_ag'].' '.$resInfoAgent['postnom_ag'].' '.$resInfoAgent['prenom_ag'];
        $compte = $resInfoAgent['NumCompt'];
        $siege = $resInfoAgent['libelle_sieg'];
        $direction = $resInfoAgent['libelle_dir'];
        $fonction = $resInfoAgent['libelleFonct'];
        $grade = $resInfoAgent['libelle_grade'];
        $cnss = $resInfoAgent['NumCNSS_ag'];

        $sheet->setCellValue("A".$row, $counter);
        $sheet->setCellValue("B".$row, $matricule);
        $sheet->setCellValue("C".$row, $nomComplet);
        $sheet->setCellValue("D".$row, $compte);
        $sheet->setCellValue("E".$row, $siege);
        $sheet->setCellValue("F".$row, $direction);
        $sheet->setCellValue("G".$row, $fonction);
        $sheet->setCellValue("H".$row, $cnss);

        /*
        $sheet->setCellValue('A' . $row, $matricule);
        $sheet->setCellValue('B' . $row, $nomComplet);
        $sheet->setCellValue('C' . $row, $siege);
        $sheet->setCellValue('D' . $row, $cnss);
        */
        //$sheet->getColumnDimension($col)->setAutoSize(true);
        $counter++;
        $row++;
        //$data[] = [$matricule, $nomComplet, $siege, $cnss];
    }

    /*
    $sheet->fromArray($data, null, 'A4');

    // 💅 Mise en forme des colonnes
    foreach (range('A', 'H') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }*/

    // 🧱 Bordures
    //$lastRow = count($data) + 3;
    // Bordures
   

    $sheet->getStyle("A1:H" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);


    //$sheet->getStyle("A3:H$lastRow")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // 💾 Sauvegarde du fichier
    $writer = new Xlsx($spreadsheet);
    $writer->save('releve_frais_cadeco.xlsx');


?>