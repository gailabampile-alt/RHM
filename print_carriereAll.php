<?php
require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

$matricule = '';
if(isset($_GET['code']) || empty($_GET['code'])) {
    $matricule = $_GET['code'];
    
}

class PDF extends FPDF {
    
function Header() {
        // Images à gauche et à droite
        $this->Image('img/Logo CADECO1.jpg', 10, 10, 25); // X=10, Y=10, largeur=25mm
        $this->Image('img/Logo CADECO1.jpg', 250, 10, 25); // X=175 pour positionner à droite

        // Texte centré
        $this->SetFont('Arial','B',15);
        $this->Cell(0,10,"CAISSE GENERALE D'EPARGNE DU CONGO",0,1,'C');
        $this->SetFont('Arial','',12);
        $this->Cell(0,7,iconv('UTF-8', 'iso-8859-1','Société-Anonyme-Unipersonnelle'),0,1,'C');
        $this->Cell(0,7,iconv('UTF-8', 'iso-8859-1','CADECO SAU'),0,1,'C');
        $this->Cell(0,7,iconv('UTF-8', 'iso-8859-1','38.Av Cadeco Kinshasa/Gombe'),0,1,'C');
        $this->Ln(5);
        $this->Cell(0,0,str_repeat('_',90),0,1,'C');
        $this->Ln(10);
    }


    function InfoPersonnel($matricule, $nom) {
        $this->SetFont('Arial','BU',14);
        $this->Cell(0,10,"CHRONOLOGIE DES MOUVEMENTS DE L'AGENT",0,1,'C');
        //$this->SetX($x);
        $this->SetFont('Arial','B',13);
        $titre = 250;
        $x = ($this->GetPageWidth() - $titre) / 2;
        $this->SetX($x);
        $this->Cell(0,10,"Matricule : $matricule",0,1,'L');
        $this->SetX($x);
        $this->Cell(0,10,"Nom complet : $nom",0,1,'L');
        $this->Ln(5);
    }

    
function EnteteTableau() {
    $this->SetFont('Arial','B',13);
    $tableWidth = 250;
    $x = ($this->GetPageWidth() - $tableWidth) / 2;
    $this->SetX($x);

    // Cellule "Mouvement" fusionnée verticalement (hauteur = 20)
    $this->Cell(40,20,iconv('UTF-8', 'iso-8859-1','Mouvement N°'),1,0,'C');

    // Cellule "Chronologie de mouvement" fusionnée horizontalement
    $this->Cell(210,10,'Chronologie de mouvement',1,0,'C');
    $this->Ln();

    // Deuxième ligne : sous-titres
    $this->SetX($x + 40); // Décalage après "Mouvement"
    $this->Cell(110,10,iconv('UTF-8', 'iso-8859-1','Direction'),1,0,'L');
    $this->Cell(50,10,iconv('UTF-8', 'iso-8859-1','Date Début'),1,0,'C');
    //$this->Cell(30,10,iconv('UTF-8', 'iso-8859-1','Siège Fin'),1,0,'C');
    $this->Cell(50,10,'Date Fin',1,0,'C');
    $this->Ln();
}


    function LigneTableau($mvt, $dir, $date_debut, $date_fin) {
        $this->SetFont('Arial','',12);
        $tableWidth = 250;
        $x = ($this->GetPageWidth() - $tableWidth) / 2;
        $this->SetX($x);
        $this->Cell(40,10,$mvt,1,0,'C');
        $this->Cell(110,10,$dir,1,0,'L');
        $this->Cell(50,10,$date_debut,1,0,'C');
        //$this->Cell(30,10,$siege_fin,1);
        $this->Cell(50,10,$date_fin,1,0,'C');
        $this->Ln();
    }
}

$pdf = new PDF();
//$pdf = new PDF('P','mm','A4');
$pdf->SetAutoPageBreak(true, 15);

    // Requête pour récupérer les données triées par type de mouvement
    $result = $db->prepare("SELECT
    a.matricule, concat(a.nom_ag,' ',a.postnom_ag, ' ',a.prenom_ag) AS noms,a.dateNaiss_ag,a.dateEngagemnt_ag,a.sexe_ag,a.etatCiv_ag,s.code_sieg,s.libelle_sieg,s.typeSiege_ID,
    d.code_dir,d.libelle_dir,g.code_grade,g.libelle_grade,f.codeFonct,f.libelleFonct,soc.code_soc,soc.libelle_soc,
    dad.dateDebut AS debutFonct,dad.dateFin as finFonct,dad.statut_ID AS statutFonct,das.dateDebut AS debutSiege,das.dateFin AS finSiege,das.statut_ID AS statutSiege,dso.dateDebut AS debutSociete, dso.dateFin AS finSociete, dso.statut_ID AS statutSociete,dg.dateDebut AS debutGrade, dg.dateFin AS finGrade,dg.statut_ID AS statutGrade,df.dateDebut AS debutfonct,df.dateFin AS finFonct,df.statut_ID AS statutFonct
    FROM t_agent a
    JOIN detail_agent_siege das ON das.agent_ID = a.matricule
    JOIN detail_agent_direction dad ON dad.agent_ID = a.matricule
    JOIN detail_agent_societe dso ON dso.agent_ID = a.matricule
    JOIN detail_agent_grade dg ON dg.agent_ID = a.matricule
    JOIN detail_agent_fonction df ON df.agent_ID = a.matricule
    JOIN t_siege s ON s.code_sieg = das.siege_ID
    JOIN t_direction d ON d.code_dir = dad.direction_ID
    JOIN t_societe soc ON soc.code_soc = dso.societe_ID
    JOIN t_grade g ON g.code_grade = dg.grade_ID
    JOIN t_fonction f ON f.codeFonct = df.fonction_ID
    WHERE a.matricule = '04392';  ORDER BY agd.agent_ID, agd.dateDebut");
    $result->bindValue(':agent_ID', $matricule);
    $result->execute();

    $comp = 1;
    $last_mvt = null;
    foreach ($result as $row) {
        if ($row['agent_ID'] != $last_mvt) {
            $pdf->AddPage();
            $pdf->InfoPersonnel($row['agent_ID'], $row['noms']); // À remplacer par le nom réel si disponible
            $pdf->EnteteTableau();
            $last_mvt = $row['agent_ID']; 
        }

        $pdf->LigneTableau($comp, iconv('UTF-8', 'iso-8859-1',$row['libelle_dir']), formatDateFr($row['dateDebut'], 'long'), formatDateFr($row['dateFin'], 'long'));
        $comp += 1;
    }
    $pdf->Ln();
    $pdf->SetFont('Arial','',9);
    $txt = "Fait à Kinshasa, Le ". date('d-m-Y');
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(260,5,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C'); $pdf->ln(8);
    $txt = "David KASONGO";
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(260,5,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C'); 
    $pdf->Output('I', 'etat_carriere.pdf');
?>