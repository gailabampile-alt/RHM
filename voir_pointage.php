<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Poinatge des Agents par Mois</h3>

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
              <a href="accueil.php?page=Pointage" class="btn btn-round btn-primary">Ajout Pointage</a>
           </div>
           <br>
           <br>
           <br>
            <div class="adv-table" style="margin: 5px;">
              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                   <!--  <th>Grade</th>-->
                    <th>Periode</th>
                    <th class="hidden-phone">Date</th>
                    <th class="hidden-phone">Matricule</th>
                    <th class="hidden-phone">Noms</th>
                    <th class="hidden-phone">Nombre de jours</th>
                    
                    <th>Action</th>
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
                        $bareme = $db->prepare("select * from bdd_paie.t_pointage as A INNER JOIN bdd_paie.t_agent AS U ON U.matricule=A.matric");
                        $bareme ->execute();
                        while($resbareme=$bareme->fetch()){
                            $periode = $resbareme['periode'];
                            $datep  = $resbareme['datep'];
                            $creerPar = $resbareme['creerpar'];
                            $Date_Creat = $resbareme['datecreat'];
                            $modifierPar=$resbareme['modifierPar'];
                            $Date_Modif = $resbareme['datemodif'];
                            //$ph = $resbareme['ph'];
                            $nbrejrs= $resbareme['nbrejrs'];
                            $datefr =$datep;
                           
                        $nom_utilisateur=$resbareme['nom_ag'];
                        $postnom_utilisateur=$resbareme['postnom_ag'];
                        $prenom_utilisateur=$resbareme['prenom_ag'];
                        $nomComplet= $nom_utilisateur." ".$postnom_utilisateur." ".$prenom_utilisateur ;
                        $matricule=$resbareme['matric'];
                        $matric=$resbareme['matricule'];
                        $id_pointage =$resbareme['id_pointage'];
                    ?>
                    <td> <?php echo  $periode;?> </td>
                    <td> <?php echo  $datefr;?></td>
                    <td class="center hidden-phone"> <?php echo  $matricule;?> </td>
                    <td class="center hidden-phone"> <?php echo  $nomComplet;?> </td>
                    <td class="center hidden-phone"> <?php echo $nbrejrs;?> </td>
                    <td class="hidden-phone">
                        <!-- Single button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                             <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Edit_pointage&id=<?php echo $id_pointage;?>">Modifier</a></li>
                                 <!--<li><a href="<?php echo $id_bar;?>">Activer</a></li>
                                <li><a href="<?php echo $id_bar;?>">Désactiver</a></li>
                               li class="divider"></li>
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