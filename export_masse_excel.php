
<?php
include('sys_connexion.php');

$periode = $_GET['periode'] ?? '';

if ($periode == '') die('Période non définie');

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=masse_salariale_$periode.xls");

$sql = "
SELECT 
    periode,
    type_paie,
    CASE
        WHEN codeEiPaie = 999 THEN 'NET A PAYER'
        WHEN codeEiPaie = 412 THEN 'RETENUE SYNDICALE'
        WHEN codeEiPaie = 408 THEN 'RETENUE CNSS'
        WHEN codeEiPaie = 409 THEN 'RETENUE IPR'
    END AS nature_montant,
    SUM(
        CASE 
            WHEN codeEiPaie = 999 THEN montant_payer
            ELSE Montant_a_retenir
        END
    ) AS total_montant
FROM bdd_paie.t_paie
WHERE codeEiPaie IN (999,412,408,409)
  AND periode = :periode
GROUP BY periode, type_paie, nature_montant
ORDER BY type_paie, nature_montant
";

$stmt = $db->prepare($sql);
$stmt->execute([':periode'=>$periode]);

echo "PERIODE\tTYPE PAIE\tNATURE\tMONTANT\n";

while ($r = $stmt->fetch()) {
    echo "{$r['periode']}\t{$r['type_paie']}\t{$r['nature_montant']}\t{$r['total_montant']}\n";
}
