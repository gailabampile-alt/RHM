<?php


require_once('sys_connexion.php');

$ecrire = fopen('agent.txt',"w");

$reqInfoAgent = $db->prepare('SELECT * FROM bdd_paie.v_info_agent');
$reqInfoAgent ->execute();
$data ='';
$retourchariot ="\n";

while($resInfoAgent=$reqInfoAgent->fetch())
{
    $nomComplet = $resInfoAgent['nom_ag'].' '.$resInfoAgent['postnom_ag'].' '.$resInfoAgent['prenom_ag'];

  $data = $resInfoAgent['matricule'].';'.$nomComplet. ';'.$resInfoAgent['code_grade'].';'.$resInfoAgent['libelle_sieg'].';'.
  $resInfoAgent['libelleFonct'].';'.$resInfoAgent['libelle_dir'];
    $ecrire = fopen('agent.txt',"a+");
    fputs($ecrire,$data);
    fputs($ecrire,"\n");
    echo $data;
    
}
header("location: imprimer_agent.php");
 