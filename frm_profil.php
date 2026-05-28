<?php
//session_start();
include_once('sys_connexion.php');
$fonction = '';
$siege = '';
$societe = '';
$direction = '';
$grade = '';
$matricule = '';
$reqGetInfoUser = $db->prepare("SELECT * FROM  bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
$reqGetInfoUser->bindvalue(':id_user', $_SESSION['id_utilisateur']);
$reqGetInfoUser->execute();
while ($resGetInfoUser = $reqGetInfoUser->fetch()) {
  $creerPar = $resGetInfoUser['creerPar'];
  $modifierPar = $resGetInfoUser['modifierPar'];
  $nomCompteUser = $resGetInfoUser['username'];
  $dateCreate = $resGetInfoUser['dateCreation'];
  $dateModif = $resGetInfoUser['dateLast_Modifi'];
  $matricule = $resGetInfoUser['agent_ID'];
  $nom_Complet = $resGetInfoUser['nom_ag'] . ' ' . $resGetInfoUser['postnom_ag'] . ' ' . $resGetInfoUser['prenom_ag'];
  $role = $resGetInfoUser['libelle_role'];
  $nomPhoto = $resGetInfoUser['photo'];
  $direction = $resGetInfoUser['libelle_dir'];
}
$reqGetInfoAgent = $db->prepare("SELECT * FROM bdd_paie.v_info_agent WHERE matricule = :matricule");
$reqGetInfoAgent->bindValue(':matricule', $matricule);
$reqGetInfoAgent->execute();
while ($resGetInfoAgent = $reqGetInfoAgent->fetch()) {
  $fonction = $resGetInfoAgent['libelleFonct'];
  $siege = $resGetInfoAgent['libelle_sieg'];
  $societe = $resGetInfoAgent['libelle_soc'];
  //$direction = $resGetInfoAgent['username'];
  $grade = $resGetInfoAgent['libelle_grade'];
  /*$matricule = $resGetInfoAgent['agent_ID'];
    $nom_Complet = $resGetInfoAgent['nom_ag'].' '.$resGetInfoUser['postnom_ag'].' '.$resGetInfoUser['prenom_ag'];
    $role = $resGetInfoAgent['libelle_role'];
    */
}

?>
<br><br><br><br><br>
<div class="row content-panel" style="margin: 25px;">
  <div class="col-md-3 profile-text mt mb centered">
    <div class="right-divider hidden-sm hidden-xs">

      <h4>Siège</h4>
      <h6> <?php echo $siege; ?> </h6>

      <h4>Regoupement</h4>
      <h6> <?php echo $societe; ?> </h6>

      <h4>Direction</h4>
      <h6> <?php echo $direction; ?> </h6>

      <h4>Fonction</h4>
      <h6><?php echo $fonction; ?> </h6>
    </div>
  </div>
  <!-- /col-md-4 -->
  <div class="col-md-5 profile-text">
    <br><br><br>
    <h3> <span class="centered"> <?php echo $nom_Complet; ?> </span> </h3>
    <h5 class=""> <?php echo $role; ?> </h5>
    <p> <b>GRADE : </b> <?php echo $grade; ?></p>
    <br>
    <!--p><button class="btn btn-theme"><i class="fa fa-envelope"></i> Send Message</button></p-->
  </div>
  <!-- /col-md-4 -->
  <br><br>
  <div class="col-md-3 ">
    <div class="profile-pic">
      <p><img src="photoAgent/<?php echo $nomPhoto; ?>" alt="" /></p>
      <!--p>
          <button class="btn btn-theme"><i class="fa fa-check"></i> Follow</button>
          <button class="btn btn-theme02">Add</button>
        </p-->
    </div>
  </div>

  <!-- /col-md-4 -->
</div>
<!-- /row -->
<br><br><br><br><br><br><br><br><br><br>