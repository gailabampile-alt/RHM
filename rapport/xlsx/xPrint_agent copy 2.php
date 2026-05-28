<?php
    $file = __DIR__ . '/../../vendor/autoload.php';
    if (!file_exists($file)) {
        die("Fichier autoload.php introuvable à l'emplacement : $file");
    }
    require $file;
    session_start();

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
    use PhpOffice\PhpSpreadsheet\RichText\RichText;
    use PhpOffice\PhpSpreadsheet\RichText\Run;
    use PhpOffice\PhpSpreadsheet\Style\Color;

    include_once(__DIR__ . '/../../sys_connexion.php');

    // Création du document
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 🔖 Titre principal
    $drawing = new Drawing();
    $drawing->setName('Logo');
    $drawing->setPath(__DIR__ . '/../../img/Logo CADECO1.jpg');
    $drawing->setCoordinates('A1');
    // 📏 Redimensionner le logo
    $drawing->setOffsetX(10);    // Décalage horizontal
    $drawing->setOffsetY(10);    // Décalage vertical
    $drawing->setHeight(80); // Hauteur en pixels
    $drawing->setWidth(120); // Largeur en pixels

    $drawing->setWorksheet($sheet);

    
    /*
    $sheet->mergeCells('A1:H1');    $sheet->mergeCells('A5:H5'); // Fusionne les cellules A1 à H1
    */
    $sheet->mergeCells('A1:Q1'); // Fusionne les cellules A1 à H1

    // Créer un objet RichText
    $richText = new RichText();

    // Ligne 1 - en gras et taille 14
    $line1 = $richText->createTextRun("CAISSE GENERALE D'EPARGNE DU CONGO\n");
    $line1->getFont()->setBold(true)->setSize(16);

    $line2 = $richText->createTextRun("CADECO sa\n");
    $line2->getFont()->setBold(true)->setSize(14);
    $line3 = $richText->createTextRun("Société Anonyme Unipersonnelle\n");
    $line3->getFont()->setBold(true)->setitalic(true)->setSize(12);//->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF0000'));
    $line4 = $richText->createTextRun("38, Av Cadeco/ Kinshasa - Gombe\n");
    $line4->getFont()->setBold(true)->setitalic(true)->setSize(12);
    $line5 = $richText->createTextRun("CD/KIN/RCCM/ 14-B-04334\n");
    $line5->getFont()->setBold(true)->setitalic(true)->setSize(12);
    $line6 = $richText->createTextRun("ID. NAT : 01-510-N 59769N\n");
    $line6->getFont()->setBold(true)->setitalic(true)->setSize(12);
    $line7 = $richText->createTextRun("NIF : A0905417Z\n");
    $line7->getFont()->setBold(true)->setitalic(true)->setSize(12);
    $line8 = $richText->createTextRun("Votre banque de famille, votre banque de proximité\n");
    $line8->getFont()->setBold(true)->setSize(14);
    $line9 = $richText->createTextRun("DIRECTION GENERALE DE KINSHASA\n");
    $line9->getFont()->setBold(true)->setSize(14);//->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('008000'));
    $line1->getFont()->setBold(true)->setSize(14);

// Ligne 2 - italique et taille 12
//$line2 = $richText->createTextRun("Ligne 2\n");
//$line2->getFont()->setItalic(true)->setSize(12)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('0000FF'));

// Ligne 3 - normal et taille 10
//$line3 = $richText->createTextRun("Ligne 3");
//$line3->getFont()->setSize(10)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('008000'));

// Appliquer à la cellule
$sheet->getCell('A1')->setValue($richText);

// Activer le retour à la ligne
$sheet->getStyle('A1')->getAlignment()->setWrapText(true);

// Ajuster la hauteur de ligne
/*
$sheet->getRowDimension(1)->setRowHeight(60);


    $texte = "CAISSE GENERALE D'EPARGNE DU CONGO".PHP_EOL.
        "CADECO sa".PHP_EOL.
        "Société Anonyme Unipersonnelle" .PHP_EOL. 
        "38, Av Cadeco/ Kinshasa - Gombe"   .PHP_EOL.
        "CD/KIN/RCCM/ 14-B-04334" .PHP_EOL.   
        "ID. NAT : 01-510-N 59769N".PHP_EOL.
        "NIF : A0905417Z".PHP_EOL.
        "Votre banque de famille, votre banque de proximité".PHP_EOL.
        "DIRECTION GENERALE DE KINSHASA" .PHP_EOL."";
    $sheet->setCellValue('A1', $texte);
    // Active le retour à la ligne automatique
    $sheet->getStyle('A1')->getAlignment()->setWrapText(true);
    */
    $sheet->mergeCells('A2:Q2'); // Fusionne les cellules A2 à H2
    $texte = "LISTE DES AGENTS A LA DATE DU " . date('d/m/Y');
    $sheet->setCellValue('A2', $texte);

    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D8D9D9');



    // Optionnel : alignement vertical et horizontal
    $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Optionnel : ajuster la hauteur de la ligne
    $sheet->getRowDimension(1)->setRowHeight(170);

    // 🧾 En-têtes de colonnes
     //$sheet->freezePane('A2'); // Fige la ligne 1
    $headers = ['N°', 'Matricule', 'Nom Complets', 'Sexe', 'EtatCivil', 'DateNaissance', 'LieuNaissance', 'DateEngagement'
               ,'NivEtude', 'CNSS', 'nbrEnfant', 'Grade', 'Siège', 'Fonction', 'Direction', 'Compte Bancaire','Carburant'];
    $sheet->fromArray($headers, null, 'A3');
    $sheet->setAutoFilter('A3:Q3'); // Ajout du filtre ici
    $sheet->getStyle('A3:Q3')->getFont()->setBold(true);
    $sheet->getStyle('A3:Q3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A3:Q3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9D9D9');


    $reqInfoAgent = $db->prepare('SELECT * FROM bdd_paie.v_info_agent WHERE code_activ = :code_activ');
    $reqInfoAgent->bindvalue('code_activ','01');
    $reqInfoAgent ->execute();
    $row = 4; // Commence à la ligne 4 pour les données
    $counter = 1; // Compteur pour la colonne N°
    //$data[] = ""; // Ajouter les en-têtes au tableau de données
    
    //$sheet->fromArray($data, null, 'A4');
    while ($resInfoAgent=$reqInfoAgent->fetch()){
        $matricule = $resInfoAgent['matricule'];
        $nomComplet = $resInfoAgent['nom_ag'].' '.$resInfoAgent['postnom_ag'].' '.$resInfoAgent['prenom_ag'];
        $sexe = $resInfoAgent['sexe_ag'];
        $etatCiv = $resInfoAgent['etatCiv_ag'];
        $dateNaiss = $resInfoAgent['dateNaiss_ag'];
        $proNaiss = $resInfoAgent['provNaiss'];
        $dateEngag = $resInfoAgent['dateEngagemnt_ag'];
        $nivEtude = $resInfoAgent['NivEtude_ag'];
        $cnss = $resInfoAgent['NumCNSS_ag'];
        $nEnfant = $resInfoAgent['nbreEnfant_ag'];
        $grade = $resInfoAgent['code_grade'];
        $siege = $resInfoAgent['code_sieg'];
        $fonction = $resInfoAgent['libelleFonct'];
        $direction = $resInfoAgent['libelle_dir'];
        $compte = $resInfoAgent['NumCompt'];
        $carburant = $resInfoAgent['indiceCarburant'];
        
        
        
        
        

        $sheet->setCellValue("A".$row, $counter);
        $sheet->setCellValue("B".$row, $matricule);
        $sheet->setCellValue("C".$row, $nomComplet);
        $sheet->setCellValue("D".$row, $sexe);
        $sheet->setCellValue("E".$row, $etatCiv);
        $sheet->setCellValue("F".$row, $dateNaiss);
        $sheet->setCellValue("G".$row, $proNaiss);
        $sheet->setCellValue("H".$row, $dateEngag);
        $sheet->setCellValue("I".$row, $nivEtude);
        $sheet->setCellValue("J".$row, $cnss);
        $sheet->setCellValue("K".$row, $nEnfant);
        $sheet->setCellValue("L".$row, $grade);
        $sheet->setCellValue("M".$row, $siege);
        $sheet->setCellValue("N".$row, $fonction);
        $sheet->setCellValue("O".$row, $direction);
        $sheet->setCellValue("P".$row, $compte);
        $sheet->setCellValue("Q".$row, $carburant);

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
   
    //$lastRow = $row - 1; // Dernière ligne avec des données
    //$sheet->getStyle("A3:Q {$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle("A1:Q1" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $fileName = "rapport_".$_SESSION['id_utilisateur']."_".date('d-m-Y')."_.xlsx";

    // Préparation du téléchargement
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' .$fileName. '"');
    header('Cache-Control: max-age=0');

    // Envoi du fichier au navigateur
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

    // 💾 Sauvegarde du fichier
    //$writer = new Xlsx($spreadsheet);
    //$writer->save('releve_frais_cadeco1.xlsx');


?>