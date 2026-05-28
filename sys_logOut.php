<?php
    session_start();
    include_once('sys_connexion.php');
    $reqHistorique =  $db->prepare('UPDATE bdd_paie.t_historique_conn 
    SET date_decon = :date_decon, heure_decon = :heure_decon WHERE id_histori_con = :id_histori_con');
    $date = date('y-m-d');
    $reqHistorique->bindvalue(':date_decon',$date);
    $heure = date('H:i:s');
    $reqHistorique->bindvalue(':heure_decon',$heure);
    /*$reqHistorique->bindvalue(':idHC',$_SESSION['idDate_Heure_Act']);*/
    $reqHistorique->bindvalue(':id_histori_con',$_SESSION['id_histori_con']);
    $reqHistorique->execute();

    session_unset();
?>
<script language="javascript">
document.location="index.php";
</script>