<?php
    include_once('sys_connexion.php');
  
?>

<h3><i class="fa fa-angle-right"></i> Liste Des Directions</h3>
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
            <a href="accueil.php?page=Direction" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i> Ajouter </a>
            <a target="_blank" href="print_direction_ag.php" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:90px;"><i class="fa fa-print" style="margin-right: 7px;"></i> Liste</a>
            
              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Libellé</th>
                    <th>Créer Par</th>
                    <th class="hidden-phone">Modifier Par</th>
                    <th class="center">Statut</th>
                    <th>Action</th>
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
                        $reqInfoPret = $db->prepare('SELECT * FROM bdd_paie.t_direction');
                        $reqInfoPret ->execute();
                        while($resInfoPret=$reqInfoPret->fetch()){
                            $code_dir = $resInfoPret['code_dir'];
                            $lib_dir = $resInfoPret['libelle_dir'];
                            $creerPar = $resInfoPret['creePar'];
                            $modifierPar = $resInfoPret['modifierPar'];
                            $statut = $resInfoPret['statut_ID'];
                    ?>
                    <td> <?php echo $code_dir;?> </td>
                    <td> <?php echo $lib_dir;?></td>
                    <td>
                    <?php 
                        if($creerPar == "sysAdmin"){
                          echo $creerPar;
                        }else{
                          $nomComplet = "";
                          $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                          WHERE id_user = :creerPar');
                          $reqGetInfoUser->bindValue(':creerPar',$creerPar);
                          $reqGetInfoUser->execute();
                          while ($resGetInfoUser = $reqGetInfoUser->fetch()) {
                            $nom_postnom = $resGetInfoUser['nom_ag'].' '.$resGetInfoUser['postnom_ag'];
                            $prenom = ucfirst(strtolower($resGetInfoUser['prenom_ag']));
                            $nomComplet = $nom_postnom.' '.$prenom;
                          }
                          echo $nomComplet;
                        }
                      
                      ?>
                    </td>
                    <td >
                    <?php 
                        if($modifierPar == "sysAdmin"){
                          echo $modifierPar;
                        }else{
                          $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                          WHERE id_user = :modifierPar');
                          $reqGetInfoUser->bindValue(':modifierPar',$modifierPar);
                          $reqGetInfoUser->execute();
                          while ($resGetInfoUser = $reqGetInfoUser->fetch()) {
                            $nom_postnom = $resGetInfoUser['nom_ag'].' '.$resGetInfoUser['postnom_ag'];
                            $prenom = ucfirst(strtolower($resGetInfoUser['prenom_ag']));
                            $noms = $nom_postnom.' '.$prenom;
                          }
                          echo $noms;
                        }
                      
                      ?>
                    </td>
                    <td class="center"> <?php 
                      if($statut == "act"){
                        echo '<i class="fa fa-check-circle fa-lg" style="margin-right: 5px; color:green;width: 25px"></i>';
                      }else{
                        echo '<i class="fa fa-ban fa-lg" style="margin-right: 15px ;color:red;"></i>';
                      }
                      ?> 
                    </td>
                    <td class="hidden-phone">
                        <!-- Single button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                             <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Edit_Direction&code_dir=<?php echo $code_dir;?>" style="color:darkblue;"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <li class="divider"></li>
                                <li><a href="update_direction.php?code_dir_act=<?php echo $code_dir;?>" style="color:green" > <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                                <li><a href="update_direction.php?code_dir_desac=<?php echo $code_dir;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li>
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