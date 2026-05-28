<?php
require('fpdf.php');
//https://blog.infiniclick.fr/articles/tutoriel-creer-fichier-pdf-fpdf.html


$position_entete = 58;
// Création de la class PDF
class PDF extends FPDF {
    // Header
    function Header() {
        // Logo
        $this->Image('img/Logo CADECO1.jpg',15,13,40);
        // Saut de ligne
        //$this->Ln(20);
        $this->SetFont('Arial','B',16);

    // Décalage à droite
    $this->Cell(130);
    // Titre
    $this->Cell(30,10,"CAISSE GENERALE D'EPARGNE DU CONGO",0,0,'C');
    $this->Ln(6);

    $this->SetFont('Arial','B',14);
    $this->Cell(130);
    $txt = iconv('UTF-8', 'windows-1252', "<< Société Anonyme >>");
    $this->Cell(30,10,$txt,0,0,'C');
    $this->Ln(7);

    $this->Cell(130);
    $txt = iconv('UTF-8', 'windows-1252', "Capital social de 8.937.470.000 FC");
    $this->Cell(30,10,$txt,0,0,'C');
    $this->Ln(7);

    $this->Cell(130);
    $txt = iconv('UTF-8', 'windows-1252', "38,Av.Cadeco Kinshasa/Gombe");
    $this->Cell(30,10,$txt,0,0,'C');
    $this->Ln(7);

    $this->Cell(130);
    $txt = iconv('UTF-8', 'windows-1252', "CD/KIN/RCCM/14-B-04334");
    $this->Cell(30,10,$txt,0,0,'C');
    $this->Ln(7);

    $this->Cell(130);
    $txt = iconv('UTF-8', 'windows-1252', "ID.NAT : 01-K6500-N73607A");
    $this->Cell(30,10,$txt,0,0,'C');
    $this->Ln(7);

    $this->Cell(130);
    $txt = iconv('UTF-8', 'windows-1252', "NIF : A0905417Z");
    $this->Cell(30,10,$txt,0,0,'C');
    $this->Ln(7);

    $this->Cell(130);
    $txt = iconv('UTF-8', 'windows-1252', "N° import - export : PM/0001/AAX - 19/io12140KIZ");
    $this->Cell(30,10,$txt,0,0,'C');
    $this->Ln(7);

    $this->SetFont('Arial','B',13);
    $this->Cell(20);
    $txt = iconv('UTF-8', 'windows-1252', "DIRECTION GENERALE");
    $this->Cell(10,5,$txt,0,1,'C');
    $this->Ln(1);
    $this->SetFont('Arial','B',13);
    $this->Cell(20);
    $txt = iconv('UTF-8', 'windows-1252', "Département informatique");
    $this->Cell(10,5,$txt,0,1,'C');


    $this->Cell(130);
    $this->Cell(30,10,"_______________________________________________________________",0,0,'C');
    $this->Ln(7);

    $this->SetFont('Arial','B',15);
    $this->Cell(130);
    $txt = iconv('UTF-8', 'windows-1252', "LISTE DES GRADES");
    $this->Cell(30,10,$txt,0,0,'C');
    $this->Ln(7);


    // Saut de ligne
    $this->Ln(15);
    }
    // Footer
    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Adresse
        $txt = iconv('UTF-8', 'windows-1252', "Page N°");
        $this->Cell(196,5,$txt,0,0,'C');
    }
      /*/ Footer
        function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Helvetica','I',9);
        // Numéro de page, centré (C)
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }*/

// Position de l'entête à 10mm des infos (48 + 10)  https://blog.infiniclick.fr/articles/tutoriel-creer-fichier-pdf-fpdf.html
}
// Fonction en-tête des tableaux en 3 colonnes de largeurs variables
function entete_table($position_entete) {
    global $pdf;
    $pdf->SetFont('Arial','B',14);
    $pdf->SetDrawColor(183); // Couleur du fond RVB
    $pdf->SetFillColor(221); // Couleur des filets RVB
    $pdf->SetTextColor(0); // Couleur du texte noir
    $pdf->SetY(100);
    // position de colonne 1 (10mm à gauche)  
    $pdf->SetX(10);
    $pdf->Cell(50,8,'CODE',1,0,'C',1);  // 60 >largeur colonne, 8 >hauteur colonne
    // position de la colonne 2 (70 = 10+60)
    $pdf->SetX(60); 
    $pdf->Cell(120,8,'LIBELLE',1,0,'C',1);
    // position de la colonne 3 (180 = 120+60)
    $pdf->SetX(180); 
    $pdf->Cell(50,8,'EQUIPE PAIE',1,0,'C',1);
    // position de la colonne 3 (190 = 180+50)
    $pdf->SetX(230); 
    $pdf->Cell(60,8,'EQUIPE COMPTABLE',1,0,'C',1);
  
    $pdf->Ln(); // Retour à la ligne
    include_once('sys_connexion.php');
    $position_detail = 108; // Position ordonnée = $position_entete+hauteur de la cellule d'en-tête (60+8)
    $reqGrade = $db->prepare('SELECT * FROM bdd_paie.t_grade');
    $reqGrade ->execute();
    while($resGrade=$reqGrade->fetch()) {
      // position abcisse de la colonne 1 (10mm du bord)
      $pdf->SetY($position_detail);
      $pdf->SetX(10);
      $pdf->MultiCell(50,8,utf8_decode($resGrade['code_grade']),1,'C');
        // position abcisse de la colonne 2 (70 = 10 + 60)  
      $pdf->SetY($position_detail);
      $pdf->SetX(60); 
      $pdf->MultiCell(120,8,utf8_decode($resGrade['libelle_grade']),1,'L');
      // position abcisse de la colonne 3 (130 = 70+ 60)
      $pdf->SetY($position_detail);
      $pdf->SetX(180); 
      $pdf->MultiCell(50,8,$resGrade['Eq_Paie_ID'],1,'C');
      // position abcisse de la colonne 3 (130 = 70+ 60)
      $pdf->SetY($position_detail);
      $pdf->SetX(230); 
      $pdf->MultiCell(60,8,$resGrade['Eq_Compt_ID'],1,'C');
    
      // on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)  
      $position_detail += 8;
      $compteur = 0;
      if($compteur > 8){
        $pdf->AddPage();
        $compteur = 0;
      }
      
      $compteur += $compteur; 
     
    }
    
    
  }
  // AFFICHAGE EN-TÊTE DU TABLEAU
  // Position ordonnée de l'entête en valeur absolue par rapport au sommet de la page (70 mm)
  $position_entete = 70;


    //Activation de la classe

    $pdf = new PDF('L','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Helvetica','',11);
    $pdf->SetTextColor(0);
    entete_table($position_entete);

    $pdf->Output();