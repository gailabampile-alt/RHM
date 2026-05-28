<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Liste Des Utilisateurs</h3>
        <div class="row mb">
          <!-- page start-->
          
          <div class="content-panel" style="margin: 15px;">
          <?php if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="alert">×</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
            </div>
          <?php } ?>
            <div class="adv-table" style="margin: 5px;">
            <a href="accueil.php?page=Utilisateurs" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:100px;"><i class="fa fa-user" style="margin-right: 7px;"></i>Ajouter</a>
            <a href="print_user.php" target="_blank" style="margin-left:15px;"><img src="img/icons8_PDF_32.png"></a>
            <a href="rapport/xlsx/xPrint_user.php" target="_blank" style="margin-left:10px;"><img src="img/icons8_Microsoft_Excel_32.png"></a>
            
              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Matricule</th>
                    <th>Nom Complet</th>
                    <th class="hidden-phone">Compte Utilisateur</th>
                    <th class="hidden-phone">CréerPar</th>
                    <th class="hidden-phone">ModifierPar</th>
                    <th>Statut</th>
                    <th>Rôle</th>
                    <th class="hidden-phone">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <!--tr class="gradeX">
                    <td>Trident</td>
                    <td>Internet Explorer 4.0</td>
                    <td class="hidden-phone">Win 95+</td>
                    <td class="center hidden-phone">4</td>
                    <td class="center hidden-phone">X</td>
                  </tr-->
                  <tr class="gradeC_">
                    <?php
                        $reqAffUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user <> :id_user");
                        $reqAffUtilisateur ->bindValue(':id_user',$_SESSION['id_utilisateur']);
                        $reqAffUtilisateur ->execute();
                        while($resAffUtilisateur=$reqAffUtilisateur->fetch()){
                            $id_user = $resAffUtilisateur['id_user'];
                            $matricule = $resAffUtilisateur['agent_ID'];
                            $nomComplet = $resAffUtilisateur['nom_ag'].' '.$resAffUtilisateur['postnom_ag'].' '.$resAffUtilisateur['prenom_ag'];
                            $compte = $resAffUtilisateur['username'];
                            $creerPar = $resAffUtilisateur['creerPar'];
                            $modifierPar = $resAffUtilisateur['modifierPar'];
                            $statut = $resAffUtilisateur['code_st'];
                            $role = $resAffUtilisateur['libelle_role'];
                    ?>
                    <td> <?php echo $matricule;?> </td>
                    <td> <?php echo $nomComplet;?></td>
                    <td class="hidden-phone">  <?php echo $compte;?></td>
                    <td class="center hidden-phone"> 
                    <?php
                        $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                        $reqGetNomUtilisateur->bindvalue(':id_user',$creerPar);
                        while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                            $nomComplet = $resGetNomUtilisateur['nom_ag'].' '.$resGetNomUtilisateur['postnom_ag'].' '.$resGetNomUtilisateur['prenom_ag'];
                        }
                        echo($creerPar!="sysAdmin")?"$nomComplet":"sysAdmin";
                    ?>
                    </td>
                    <td class="center hidden-phone"> 
                    <?php
                        $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                        $reqGetNomUtilisateur->bindvalue(':id_user',$modifierPar);
                        while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                            $nomComplet = $resGetNomUtilisateur['nom_ag'].' '.$resGetNomUtilisateur['postnom_ag'].' '.$resGetNomUtilisateur['prenom_ag'];
                        }
                        echo($modifierPar!="sysAdmin")?"$nomComplet":"sysAdmin";
                    ?>
                    </td>
                    <td>
                    <?php 
                        if($statut == "act"){
                          echo '<i class="fa fa-check-circle fa-lg" style="margin-right: 5px; color:green;width: 25px"></i>';
                        }else{
                          echo '<i class="fa fa-ban fa-lg" style="margin-right: 15px ;color:red;"></i>';
                        }
                      
                      ?>
                    </td>
                    <td> <?php echo $role;?> </td>
                    <td class="hidden-phone">
                        <!-- Single button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                             <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Edit_Utilisateur&id=<?php echo $id_user;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <li class="divider"></li>
                                <li><a href="update_utilisateur.php?id_act=<?php echo $id_user;?>" style="color:green" > <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                                <li><a href="update_utilisateur.php?id_des=<?php echo $id_user;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li>
                                <li><a href="update_utilisateur.php?id_reinit=<?php echo $id_user;?>"> <i class="fa fa-undo" style="margin-right: 2px;"></i> Réinitialiser</a></li>
                            </ul>
                        </div>
                        <!-- Single button -->
                    </td>
                  </tr>
                <?php } ?>  
                </tbody>
              </table>
            </div>
          </div>
          <!-- page end-->
        </div>
        <!-- /row -->