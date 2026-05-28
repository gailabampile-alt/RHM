<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Liste Des Elements de Paie</h3>

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

            <div class="col-lg-6">
              <a href="accueil.php?page=Code_Paie" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i>Ajouter</a>
              <a target="_blank" href="print_codePaie.php" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:90px;"><i class="fa fa-print" style="margin-right: 7px;"></i> Liste</a>
              
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
                    <th class="hidden-phone">Libelle </th>
                    <th class="hidden-phone">Sens</th>
                    <th>Imposable</th>
                    <th>Statut</th>
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
                        $bareme = $db->prepare('SELECT * FROM bdd_paie.t_codepaie');
                        $bareme ->execute();
                        while($resbareme=$bareme->fetch()){
                            $codepaie = $resbareme['codePaie'];
                            $Libellepaie  = $resbareme['libelle_codePaie'];
                            $sens_ID = $resbareme['sens_ID'];
                            $imposable= $resbareme['imposable'];
                           // $modifierPar = $resbareme['modifierPar'];
                            //$Date_Modif = $resbareme['Date_Modif'];
                            $statut = $resbareme['statut_ID'];
                           
                       // $nom_utilisateur=$resbareme['nom_ag'];
                       // $postnom_utilisateur=$resbareme['postnom_ag'];
                       // $prenom_utilisateur=$resbareme['prenom_ag'];
                      //  $nomComplet= $nom_utilisateur." ".$postnom_utilisateur." ".$prenom_utilisateur
                       
                    ?>
                    <td> <?php echo  $codepaie ;?> </td>
                    <td> <?php echo  $Libellepaie ;?></td>
                    <td class="center hidden-phone"> <?php echo  $sens_ID;?> </td>
                    <td class="center hidden-phone"> <?php echo   $imposable;?> </td>
                    <td class="center">
                    <?php 
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
                                <li><a href="accueil.php?page=Edit_CodePaie&id=<?php echo $codepaie ;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <li class="divider"></li>
                                <li><a href="update_codepaie.php?CodePaie_act=<?php echo $codepaie;?>" style="color:green" > <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                                <li><a href="update_codepaie.php?CodePaie_desac=<?php echo $codepaie;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li>
                                
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