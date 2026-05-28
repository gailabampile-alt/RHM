<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Liste Des Avances</h3>

        
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
            <a href="accueil.php?page=avance_Interet" class="btn btn-round btn-primary">Ajout A / I</a>
          </div>
          <br>
           <br>
           <br>
            <div class="adv-table" style="margin: 5px;">
              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                   <!--  <th>Grade</th>-->
                    <th>Matricule</th>
                    <th class="hidden-phone">Noms</th>
                    <th class="hidden-phone">Code Paie</th>
                    <th class="hidden-phone">Montant</th>
                    <th class="hidden-phone">Devise</th>
                    <th class="hidden-phone">Période</th>
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
                        $bareme = $db->prepare('select * from bdd_paie.t_avance as A INNER JOIN bdd_paie.t_agent AS U ON U.matricule=a.Agent_ID');
                        $bareme ->execute();
                        while($resbareme=$bareme->fetch()){
                            $id_av = $resbareme['id_avc'];
                            $matr =$resbareme['matricule'];
                            $nom = $resbareme['nom_ag'];
                            $codepaie =$resbareme['code_paie_ID'];
                            $postnom  = $resbareme['postnom_ag'];
                            $Mont = $resbareme['montant'];
                            //$code_devise=$resbareme['code_devise'];
                            $periode = $resbareme['periodeAv'];
                          $devise=$resbareme['code_monnaie'];
                        

                    ?>
                    <td> <?php echo  $matr;?> </td>
                    <td> <?php echo  $nom;?> <?php echo  $postnom;?></td>
                    <td class="center hidden-phone"> <?php echo  $codepaie;?> </td>
                    <td class="center hidden-phone"> <?php echo  $Mont;?> </td>
                    <td class="center hidden-phone"> <?php echo  $devise;?> </td>
                    <td class="center hidden-phone"> <?php echo $periode;?> </td>
                  
                   
               
                    <td class="hidden-phone">
                        <!-- Single button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                             <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Edit_avance_interet&id=<?php echo $id_av;?>" style="color:darkblue"><i class="fa fa-edit" style="margin-right: 2px;"></i>Modifier</a></li>
                                <li><a href="Update_Avance.php?code=<?php echo $id_av;?>" style="color:green"><i class="fa fa-check-circle" style="margin-right: 2px;"></i>Activer</a></li>
                                <li><a href="Update_Avance.php?code=<?php echo $id_av;?>" style="color:red"><i class="fa fa-ban" style="margin-right: 2px;"></i>Désactiver</a></li>
                                <!--li class="divider"></li>
                                <li><a href="#">Separated link</a></li-->
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