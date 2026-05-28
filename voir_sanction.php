<?php
include_once('sys_connexion.php');
?>

<h3><i class="fa fa-angle-right"></i> Liste des Agents Sancionnés </h3>
<div class="row mb">
  <div class="content-panel" style="margin: 15px;">
    <?php if (isset($_SESSION['message'])) { ?>
      <div class="alert alert-<?php echo ($_SESSION['typeMsg']); ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <span><?php echo $_SESSION['message'];
              unset($_SESSION['message']);
              unset($_SESSION['typeMsg']); ?></span>
      </div>
    <?php } ?>
    <div class="adv-table" style="margin: 5px;">
      <a href="accueil.php?page=Disciplinaire" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:130px;">
        <i class="fa fa-plus-circle" style="margin-right: 7px;"></i>Ajouter
      </a>

      <a href="print_liste_sanction.php" target="_blank" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:90px;">
        <i class="fa fa-print" style="margin-right: 7px;"></i> Liste
      </a>

      <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
        <thead>
          <tr>
            <th>Numéro</th>
            <th>Agent</th>
            <th>Sanction</th>
            <th>Numéro ref</th>
            <th class="hidden-phone">Date</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th class="hidden-phone">Document</th>
            <th>Statut</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $reqInfosanct = $db->prepare('SELECT * FROM bdd_paie.t_sanct_agent 
              INNER JOIN bdd_paie.t_type_sanct ON t_type_sanct.id_typesanct = t_sanct_agent.id_typesanct 
              INNER JOIN bdd_paie.t_agent ON t_agent.matricule = t_sanct_agent.matricule 
              ORDER BY t_sanct_agent.date_debut DESC');
          $reqInfosanct->execute();

          while ($resInfosanct = $reqInfosanct->fetch()) {
            $id_sanct = $resInfosanct['id_sanct'];
            $matricule = $resInfosanct['matricule'];
            $typesanct = $resInfosanct['libelle_typesanct'];
            $mumref = $resInfosanct['ref_sanct'];
            $date = $resInfosanct['datecreat'];
            $datedu = $resInfosanct['date_debut'];
            $dateAu = $resInfosanct['date_fin'];
            $sanction = "Documents/" . $resInfosanct['sanction'];
            $agent = $resInfosanct['nom_ag'] . ' ' . $resInfosanct['postnom_ag'] . ' ' . $resInfosanct['prenom_ag'];
            $statut = $resInfosanct['statut_sanct'];

            // Vérification de la date de fin
            if (strtotime($dateAu) < strtotime(date('Y-m-d')) && $statut == "act") {
              $updateStatut = $db->prepare("UPDATE bdd_paie.t_sanct_agent SET statut_sanct = 'desac' WHERE id_sanct = ?");
              $updateStatut->execute([$id_sanct]);
              $statut = "desac";
            }
          ?>
            <tr class="gradeC_">
              <td><?php echo $i++; ?></td>
              <td><?php echo $agent; ?></td>
              <td><?php echo $typesanct; ?></td>
              <td><?php echo $mumref; ?></td>
              <td><?php echo $date; ?></td>
              <td><?php echo $datedu; ?></td>
              <td><?php echo $dateAu; ?></td>
              <td><a href="<?php echo $sanction; ?>" download target="_blank">Download</a></td>
              <td>
                 <?php
                if ($statut == "act") {
                  echo '<i class="fa fa-check-circle fa-lg" style="margin-right: 5px; color:green;width: 25px"></i>';
                } else {
                  echo '<i class="fa fa-ban fa-lg" style="margin-right: 15px ;color:red;"></i>';
                }
                ?>
              </td>
              <td class="hidden-phone">
                <div class="btn-group">
                  <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="accueil.php?page=Edit_discipline&id=<?php echo $id_sanct; ?>" style="color:darkblue">
                        <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                    <li class="divider"></li>
                    <li><a href="update_sanction.php?id_sanct_act=<?php echo $id_sanct; ?>" style="color:green">
                        <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                    <li><a href="update_sanction.php?id_sanct_desac=<?php echo $id_sanct; ?>" style="color:red">
                        <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li>
                  </ul>
                </div>
               
              </td>
              
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<br><br><br>
