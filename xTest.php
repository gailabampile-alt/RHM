<?php
    require 'vendor/autoload.php';
    
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    include_once('sys_connexion.php');

    $reqInfoAgent = $db->prepare('SELECT * FROM bdd_paie.v_info_agent WHERE code_activ = :code_activ');
    $reqInfoAgent->bindvalue('code_activ','01');
    $reqInfoAgent ->execute();

    // Création du fichier Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

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

    // Sauvegarde du fichier
    $writer = new Xlsx($spreadsheet);
    $writer->save('etat_excel1.xlsx');

    echo "Fichier Excel généré avec succès.";





?>