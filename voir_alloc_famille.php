<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Allocation Familial</h3>
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
            <a href="accueil.php?page=Frm_alloc_famille" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i>Ajouter</a>
            <!--a target="_blank" href="print_enfant_ag.php" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Imprimer La Liste</a>
            <a href="print_enfant_ag.php" download ="download" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:70px;"><i class="fa fa-download" style="margin-right: 7px;"></i>PDF</a-->
            
              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Code Paie</th>
                    <th>Libelle</th>
                    <th class="hidden-phone">Montant</th>
                    <th>Date Création</th>
                    <th class="hidden-phone">Date Modif</th>
                    <th>ModifierPar</th>
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
                        $i = 1;
                        $reqInfoEnfant = $db->prepare('SELECT * FROM bdd_paie.t_alloc_famille');
                        $reqInfoEnfant ->execute();
                        while($resInfoEnfant=$reqInfoEnfant->fetch()){
                            $code = $resInfoEnfant['id_alloc'];
                            $codepaie = $resInfoEnfant['codepaie'];
                            $lib = $resInfoEnfant['libelle_alloc'];
                            $montant = $resInfoEnfant['montant_alloc'];
                            
                            $dateCreat = $resInfoEnfant['date_creat'];
                            $dateModif = $resInfoEnfant['date_modif'];
                            $modifierPar = $resInfoEnfant['modifierPar'];
                            $statut = $resInfoEnfant['statut_ID'];
                    ?>
                    <td> <?php echo $i++;?> </td>
                    <td> <?php echo $codepaie;?></td>
                    <td>  <?php echo $lib;?></td>
                    <td> <?php echo $montant;?></td>
                    
                    <td> <?php echo $dateCreat;?> </td>
                    <td> <?php echo $dateModif;?> </td>
                    <td> 
                    <?php 
                        if($modifierPar == "sysAdmin"){
                          echo $modifierPar;
                        }else{
                          $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                          WHERE id_user = :creerPar');
                          $reqGetInfoUser->bindValue(':creerPar',$modifierPar);
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
                    <td class="hidden-phone">
                      <a href="accueil.php?page=Edit_alloc_famille&code=<?php echo $code;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 5px;"></i></a>
                           
                        <!-- Single button -->
                        <!--div class="btn-group">
                            <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                             <span class="caret"></span>
                            </button>
                             <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Edit_Enfant&code_enfant=<?php //echo $code_enf;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <li class="divider"></li>
                                <li><a href="update_enfant.php?code_enfant_act=<?php //echo $code_enf;?>" style="color:green" > <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                                <li><a href="update_enfant.php?code_enfant_desac=<?php //echo $code_enf;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li>
                                
                            </ul>
                            
                        </div-->
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
        <br><br><br><br><br><br><br><br><br><br>
        <!-- /row -->