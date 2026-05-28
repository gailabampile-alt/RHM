<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Liste Des Agents</h3>
        <div class="row mb">
          <!-- page start-->
          
          <div class="content-panel" style="margin: 15px;">
          <?php if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="salert">×</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
            </div>
          <?php } ?>
            <div class="adv-table" style="margin: 5px;">
            <a href="accueil.php?page=Signalitique" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-user" style="margin-right: 7px;"></i>Ajouter Agent</a>
            <a href="print_agent_actif.php" target="_blank" style="margin-left:15px;"><img src="img/icons8_PDF_32.png"></a>
            <a href="rapport/xlsx/xPrint_agent.php" target="_blank" style="margin-left:10px;"><img src="img/icons8_Microsoft_Excel_32.png"></a>
            <!--a href="[#" target="_blank" style="margin-left:10px;"><img src="img/icons8_Microsoft_Word_32.png"></a-->

              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Matricule</th>
                    <th>Nom Complet</th>
                    <th>Compte</th>
                    <th class="hidden-phone">Siège</th>
                    <th class="hidden-phone">Direction</th>
                    <th class="hidden-phone">Fonction</th>
                    <th>Grade</th>
                    <th>CNSS</th>
                    <!--th>Activité</th>
                    <th class="hidden-phone">Syndicat</th-->
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
                        $reqInfoAgent = $db->prepare('SELECT * FROM bdd_paie.v_info_agent WHERE code_activ = :code_activ');
                        $reqInfoAgent->bindvalue('code_activ','01');
                        $reqInfoAgent ->execute();
                        while($resInfoAgent=$reqInfoAgent->fetch()){
                            $matricule = $resInfoAgent['matricule'];
                            $nomComplet = $resInfoAgent['nom_ag'].' '.$resInfoAgent['postnom_ag'].' '.$resInfoAgent['prenom_ag'];
                            $compte = $resInfoAgent['NumCompt'];
                            $siege = $resInfoAgent['libelle_sieg'];
                            $direction = $resInfoAgent['libelle_dir'];
                            $fonction = $resInfoAgent['libelleFonct'];
                            $grade = $resInfoAgent['libelle_grade'];
                            $cnss = $resInfoAgent['NumCNSS_ag'];
                            //$activite = $resInfoAgent['libelle_activ'];
                            //$syndicat = $resInfoAgent['libelle_syndi'];
                        

                    ?>
                    <td> <?php echo $matricule;?> </td>
                    <td> <?php echo $nomComplet;?></td>
                    <td class="hidden-phone">  <?php echo $compte;?></td>
                    <td class="center hidden-phone"> <?php echo $siege;?> </td>
                    <td class="center hidden-phone"> <?php echo $direction;?> </td>
                    <td> <?php echo $fonction;?> </td>
                    <td> <?php echo $grade;?> </td>
                    <td> <?php echo $cnss;?> </td>
                    <!--td> <?php /* echo $activite;?> </td>
                    <td> <?php echo $syndicat; */ ?> </td-->
                    <td class="hidden-phone">
                        <!-- Single button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                             <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Edit_Agent&matric=<?php echo $matricule;?>" style="margin-right: 2px;color:blue;"> <i class="fa fa-edit" ></i>Modifier</a></li>
                                <!--li><a href="update_agent.php?id_act=<?php //echo $matricule;?>">Activer</a></li>
                                <li><a href="update_agent.php?id_des=<?php //echo $matricule;?>">Désactiver</a></li-->
                                <li class="divider"></li>
                                <li><a href="print_profil_agent.php?matric=<?php echo $matricule ;?>"style="margin-right: 2px;color:green;" target="_blank"><i class="fa fa-print" ></i>Imprimer</a></li>
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