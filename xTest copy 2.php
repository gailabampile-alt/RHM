<?php
    require 'vendor/autoload.php';
    
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

    include_once('sys_connexion.php');

    $reqInfoAgent = $db->prepare('SELECT * FROM bdd_paie.v_info_agent WHERE code_activ = :code_activ');
    $reqInfoAgent->bindvalue('code_activ','01');
    $reqInfoAgent ->execute();

    // Création du fichier Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();


    
// Données de l'entête
$entete = [
    "CAISSE GENERALE D'EPARGNE DU CONGO",
    "S.A.",
    "CADECO",
    "Société Anonyme Unipersonnelle",
    "\"CADECO S.A\"",
    "38, Av Cadeco/ Kinshasa - Gombe",
    "CD/KIN/RCCM/ 14-B-04334",
    "ID. NAT : 01-510-N 59769N",
    "NIF : A0905417Z",
    "Votre banque de famille, votre banque de proximité",
    "DIRECTION PROVINCIALE DE KINSHASA",
    "GUICHET DGI DE GOMBE",
    "Tiré le 9/15/2025 2:13:58 PM",
    "Page 1 de 1",
    "RELEVE DES FRAIS VALIDES EN CDF PAR CAISSE DU 15/09/2025 AU 15/09/2025 DE L'ENTITE GUICHET DGI DE GOMBE",
    "CAISSE : CAISSE 1 GUICHET DGI DE GOMBE"
];

        // 🖼️ Ajout du logo
    $drawing = new Drawing();
    $drawing->setName('Logo');
    $drawing->setDescription('Logo de l’entreprise');
    $drawing->setPath('img/404.png'); // Remplace par le chemin réel
    $drawing->setHeight(50); // Hauteur en pixels
    $drawing->setCoordinates('A1');
    $drawing->setWorksheet($sheet);

     // 📝 Ajout de l’entête
    $sheet->mergeCells('B1:E1');
    $sheet->setCellValue('B1', json_encode($entete) );
    $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(16);



    // En-têtes
    $sheet->setCellValue('A1', 'Matricule');
    $sheet->setCellValue('B1', 'Nom Complet');
    $sheet->setCellValue('C1', 'Libelle Siège');
    $sheet->setCellValue('D1', 'CNSS');



    // Remplissage des données
    $row = 4; // Commence à la ligne 2
    //$reqInfoAgent->execute();  Réexécuter la requête pour obtenir les
    while ($resInfoAgent=$reqInfoAgent->fetch()){
        $matricule = $resInfoAgent['matricule'];
        $nomComplet = $resInfoAgent['nom_ag'].' '.$resInfoAgent['postnom_ag'].' '.$resInfoAgent['prenom_ag'];
        $compte = $resInfoAgent['NumCompt'];
        $siege = $resInfoAgent['libelle_sieg'];
        $direction = $resInfoAgent['libelle_dir'];
        $fonction = $resInfoAgent['libelleFonct'];
        $grade = $resInfoAgent['libelle_grade'];
        $cnss = $resInfoAgent['NumCNSS_ag'];

        $sheet->setCellValue('A' . $row, $matricule);
        $sheet->setCellValue('B' . $row, $nomComplet);
        $sheet->setCellValue('C' . $row, $siege);
        $sheet->setCellValue('D' . $row, $cnss);
        $row++;
    }



   

    // 💾 Sauvegarde du fichier
    $writer = new Xlsx($spreadsheet);
    $writer->save('rapport.xlsx');


    echo "Fichier Excel généré avec succès.";





?>