<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Liste Des Codes Paie Avec Imputation</h3>

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

            <div class="col-lg-2">
              <a href="accueil.php?page=Code_Paie_Imputation" class="btn btn-round btn-primary">Code Paie & imputation</a>
           </div>
           <br>
           <br>
           <br>
            <div class="adv-table" style="margin: 5px;">
              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                   <!--  <th>Grade</th>-->
                    <th>Code Paie</th>
                    <th class="hidden-phone">Code Equipe Compt</th>
                    <th class="hidden-phone">Imputation</th>
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
                        $bareme = $db->prepare('SELECT * FROM bdd_paie.detail_codepaie_compt_eqcompt');
                        $bareme ->execute();
                        while($resbareme=$bareme->fetch()){
                          $Id_codepaie_imput=$resbareme['Id_codepaie_imput'];
                          $codepaie = $resbareme['code_paie_ID'];
                          $code_compt_ID  = $resbareme['code_compt_ID'];
                          $code_EqCompt = $resbareme['code_EqCompt'];
                          
                           // $modifierPar = $resbareme['modifierPar'];
                            //$Date_Modif = $resbareme['Date_Modif'];
                            //$statut = $resbareme['libelle_st'];
                           
                       // $nom_utilisateur=$resbareme['nom_ag'];
                       // $postnom_utilisateur=$resbareme['postnom_ag'];
                       // $prenom_utilisateur=$resbareme['prenom_ag'];
                      //  $nomComplet= $nom_utilisateur." ".$postnom_utilisateur." ".$prenom_utilisateur
                       
                    ?>
                    <td> <?php echo  $codepaie ;?> </td>
                    <td class="center hidden-phone"> <?php echo  $code_EqCompt?> </td>
                    <td> <?php echo  $code_compt_ID;?></td>
                   
                    <td class="hidden-phone">
                        <!-- Single button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                             <span class="caret"></span>
                            </button>
                            
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Edit_CodePaie_imput&id=<?php echo $Id_codepaie_imput ;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <!--li class="divider"></li>
                                <li><a href="Update_CodePaie_Imput.php?code_paieImput_act=<?php //echo $Id_codepaie_imput;?>" style="color:green" > <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                                <li><a href="Update_CodePaie_Imput.php?code_paieImput_desac=<?php //echo $Id_codepaie_imput;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li-->
                                
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
          <br><br><br><br><br><br><br><br><br><br>
        </div>
        <!-- /row -->