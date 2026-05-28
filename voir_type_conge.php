<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> LISTE DE CONGE</h3>
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
            <a href="accueil.php?page=Type_conge" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i> Ajouter </a>
         <!--    <a href="accueil.php?page=#" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Imprimer La Liste</a>-->

              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Id Type Congé</th>
                    <th>Libellé</th>
                    <th>Créer Par</th>
                    <th class="hidden-phone">Statut</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <tr class="gradeC_">
                    <?php
                        $reqGetProvince = $db->prepare('SELECT * FROM bdd_paie.t_typconge');
                        $reqGetProvince ->execute();
                        while($resGetProvince=$reqGetProvince->fetch()){
                            $Id_conge = $resGetProvince['id_type_conge'];
                            $lib = $resGetProvince['libelle_conge'];
                            $creerPar = $resGetProvince['creerPar'];
                          //  $nomComplet = $resGetProvince['nom_ag'].' '.$resGetProvince['postnom_ag'];
                           
                            $statut = $resGetProvince['statut'];
                    ?>
                    <td> <?php echo $Id_conge;?> </td>
                    <td> <?php echo $lib;?></td>
                    <td>
                    <?php 
                        if($creerPar=="sysAdmin"){
                         echo $creerPar ;
                        }else{
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
                    
                    <td class="center">
                    <?php 
                        if($statut =="act"){
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
                                <li><a href="accueil.php?page=Edit_type_conge&id=<?php echo $Id_conge;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <li class="divider"></li>
                                <li><a href="update_type_conge.php?id_act=<?php echo $Id_conge;?>" style="color:green" > <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                                <li><a href="update_type_conge.php?id_desac=<?php echo $Id_conge;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li>
                            </ul>
                        </div>
                        
                        
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