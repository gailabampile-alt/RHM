<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Agent / Voiture</h3>
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
            <a href="accueil.php?page=Vehicule" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i>Ajouter</a>
            <a target="_blank" href="print_vehicule_ag.php" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Imprimer La Liste</a>
            <!--a href="print_vehicule_ag.php" download ="rpt_grade" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:70px;"><i class="fa fa-download" style="margin-right: 7px;"></i>PDF</a-->

              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Matricule</th>
                    <th>Nom Complet</th>
                    <th>Modèle</th>
                    <th class="hidden-phone">Num Chassis</th>
                    <th class="hidden-phone">Num Permis</th>
                    <th class="hidden-phone">Carte Rose</th>
                    <th>Immatriculation</th>
                    <!--th>Durée</th>
                    <th>Période</th>
                    <th class="hidden-phone">Monnaie</th-->
                    <th>Statut</th>
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
                        $reqInfoVehicule = $db->prepare('SELECT * FROM bdd_paie.t_vehicule
                        INNER JOIN bdd_paie.t_agent ON t_vehicule.agent_ID = t_agent.matricule');
                        $reqInfoVehicule ->execute();
                        while($resInfoVehicule=$reqInfoVehicule->fetch()){
                            $code_vehic = $resInfoVehicule['id_veh'];
                            $matricule = $resInfoVehicule['matricule'];
                            $nomComplet = $resInfoVehicule['nom_ag'].' '.$resInfoVehicule['postnom_ag'].' '.$resInfoVehicule['prenom_ag'];
                            $modele = $resInfoVehicule['modele'];
                            $numChassis = $resInfoVehicule['numChassis'];
                            $numPermis = $resInfoVehicule['numPermis'];
                            $numCarteRose = $resInfoVehicule['numCarteRose'];
                            $immatriculation = $resInfoVehicule['immatriculation'];
                            $statut = $resInfoVehicule['statut_ID'];
                            /*$durer = $resInfoVehicule['moisEpuration'];
                            $periode = $resInfoVehicule['periodePret'];
                            $monnaie = $resInfoVehicule['monnaie_ID'];
                            $statut = $resInfoVehicule['statut_ID'];*/
                        

                    ?>
                    <td> <?php echo $matricule;?> </td>
                    <td> <?php echo $nomComplet;?></td>
                    <td >  <?php echo $modele;?></td>
                    <td > <?php echo $numChassis;?> </td>
                    <td > <?php echo $numPermis;?> </td>
                    <td> <?php echo $numCarteRose;?> </td>
                    <td> <?php echo $immatriculation;?> </td>
                    
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
                                <li><a href="accueil.php?page=Edit_Vehicule&code_vehic=<?php echo $code_vehic;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <li class="divider"></li>
                                <li><a href="update_vehicule.php?code_vehic_act=<?php echo $code_vehic;?>" style="color:green" > <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                                <li><a href="update_vehicule.php?code_vehic_desac=<?php echo $code_vehic;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li>
                                
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
        <br><br><br><br><br><br>
        <!-- /row -->