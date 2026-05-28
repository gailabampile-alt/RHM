
<?php
require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

$matric = isset($_GET['matric']) ? trim($_GET['matric']) : '';

if ($matric === '') {
    die('Matricule manquant.');
}

/**
 * Récupérer le nom complet de l’agent
 */
$sqlAgent = $db->prepare("
    SELECT CONCAT(nom_ag, ' ', postnom_ag, ' ', prenom_ag) AS nom_complet
    FROM bdd_paie.t_agent
    WHERE matricule = :matric
    LIMIT 1
");
$sqlAgent->bindValue(':matric', $matric);
$sqlAgent->execute();
$rowAgent = $sqlAgent->fetch(PDO::FETCH_ASSOC);

$nomAgent = $rowAgent && !empty($rowAgent['nom_complet']) ? $rowAgent['nom_complet'] : '— Inconnu —';

/**
 * Petite fonction pour la date en français (marche partout)
 */
function date_fr_courte($dateSqlOuTimestamp = 'now') {
    if ($dateSqlOuTimestamp === 'now') {
        $ts = time();
    } else {
        $ts = is_numeric($dateSqlOuTimestamp) ? (int)$dateSqlOuTimestamp : strtotime($dateSqlOuTimestamp);
    }
    $mois = [
        "01" => "janvier","02" => "février","03" => "mars","04" => "avril","05" => "mai","06" => "juin",
        "07" => "juillet","08" => "août","09" => "septembre","10" => "octobre","11" => "novembre","12" => "décembre"
    ];
    $j = date('d', $ts);
    $m = date('m', $ts);
    $y = date('Y', $ts);
    return $j.' '.$mois[$m].' '.$y;
}

class PDF extends FPDF
{
    private $nomAgent;

    public function __construct($orientation, $unit, $size, $nomAgent)
    {
        parent::__construct($orientation, $unit, $size);
        $this->nomAgent = $nomAgent;
    }

    // En-tête
    function Header()
    {
        // Logos
        $this->Image('img/Logo CADECO1.jpg', 10, 6, 18, 20);
        $this->Image('img/Logo CADECO1.jpg', 185, 6, 18, 20);

        // Lignes d'entête société
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 3, "CAISSE GENERALE D'EPARGNE DU CONGO", 0, 0, 'C');

        $this->Ln(5);
        $this->Cell(80);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(30, 3, iconv('UTF-8', 'ISO-8859-1', 'Société-Anonyme-Unipersonnelle'), 0, 0, 'C');

        $this->Ln(6);
        $this->Cell(80);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(30, 3, 'CADECO SAU', 0, 0, 'C');

        $this->Ln(6);
        $this->Cell(80);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(30, 3, iconv('UTF-8', 'ISO-8859-1', '38.Av Cadeco Kinshasa/Gombe'), 0, 0, 'C');

        $this->Ln(5);
        $this->Cell(80);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(
            30,
            3,
            iconv('UTF-8', 'ISO-8859-1', '_________________________________________________________________________'),
            0,
            2,
            'C'
        );

        // Titre du rapport (avec le nom de l’agent)
        $this->Ln(6);
        $this->SetFont('Times', 'B', 14);

        $titre = "L I S T E  D E  D O C U M E N T S  D E  L'  A G E N T : ".$this->nomAgent;

        // Si le titre est trop long, utilise une MultiCell centrée
        $this->SetX(10);
        $this->SetFillColor(255,255,255);
        $this->MultiCell(
            190,
            9,
            iconv('UTF-8', 'ISO-8859-1', $titre),
            0,
            'C',
            false
        );
    }

    // Pied de page
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }

    function BasicTable($header, $data)
    {
        // Calcul des largeurs
        $widths = array_map(function($col) {
            return $this->GetStringWidth($col) + 5;
        }, $header);

        foreach ($data as $row) {
            foreach ($row as $index => $col) {
                $text = (string)$col;
                $w = $this->GetStringWidth($text) + 13;
                if ($w > $widths[$index]) {
                    $widths[$index] = $w;
                }
            }
        }

        // En-tête
        foreach ($header as $i => $col) {
            $this->SetFillColor(200, 220, 255);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell($widths[$i], 7, iconv('UTF-8', 'ISO-8859-1', $col), 1, 0, '', true);
        }
        $this->Ln();

        // Données
        foreach ($data as $row) {
            foreach ($row as $i => $col) {
                $this->SetFont('Arial', '', 9);
                // encoder les chaînes avec accents si besoin
                $val = is_string($col) ? iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $col) : $col;
                $this->Cell($widths[$i], 7, $val, 1);
            }
            $this->Ln();
        }
    }
}

// Instanciation
$pdf = new PDF('P', 'mm', 'A4', $nomAgent);
$pdf->AliasNbPages();
$pdf->AddPage();

// Requête des documents
$header = ['N°','REFERENCE','LIBELLE'];

// IMPORTANT : initialiser $data
$data = [];

$result = $db->prepare('
    SELECT 
        t_doc_agent.id_doc,
        t_doc_agent.id_typedoc,
        t_doc_agent.matricule,
        t_doc_agent.ref_doc,
        t_doc_agent.observation,
        t_doc_agent.document,
        t_doc_agent.document_byte,
        t_doc_agent.creerPar,
        t_doc_agent.datecreat,
        t_doc_agent.dateModif,
        t_doc_agent.modifierPar,
        t_agent.nom_ag,
        t_agent.postnom_ag,
        t_agent.prenom_ag,
        t_type_doc.libelle_typedoc
    FROM bdd_paie.t_doc_agent
    INNER JOIN bdd_paie.t_agent 
        ON t_doc_agent.matricule = t_agent.matricule
    INNER JOIN bdd_paie.t_type_doc 
        ON t_type_doc.id_typedoc = t_doc_agent.id_typedoc
    WHERE t_doc_agent.matricule = :matricule
    ORDER BY t_doc_agent.id_doc ASC
');
$result->bindValue(':matricule', $matric);
$result->execute();

$compt = 1;
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
   
    $libelle       = $row['libelle_typedoc'];
    $ref_doc       = $row['ref_doc'];
    $matricule     = $row['matricule'];

    $data[] = [
        $compt,
        $ref_doc,
        $libelle,
        
    ];
    $compt++;
}

$pdf->SetFont('Arial','',9);
$pdf->Ln(5);
$pdf->BasicTable($header, $data);

$pdf->Ln(12);
$pdf->SetFont('Arial','',11);
$txt = "Fait à Kinshasa, le ".iconv('UTF-8','ISO-8859-1', date_fr_courte('now'));
$pdf->Cell(0, 8, $txt, 0, 1, 'R');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0, 8, 'KASONGO NGOY', 0, 1, 'R');

$pdf->Output();
