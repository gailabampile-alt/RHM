<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Enfant / Agent</h3>
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
            <a href="accueil.php?page=Enfant" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i>Ajouter</a>
            <!--<a target="_blank" href="print_enfant_ag.php" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Imprimer La Liste</a>
            <a href="print_enfant_ag.php" download ="download" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:70px;"><i class="fa fa-download" style="margin-right: 7px;"></i>PDF</a>-->
            
              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Nom Parent</th>
                    <th>Matricule</th>
                    <th class="hidden-phone">Nom & Postnom Enfant</th>
                    <th>Sexe</th>
                    <th class="hidden-phone">Acte Naissance</th>
                    <!--th class="hidden-phone">Carte Rose</th>
                    <th>Immatriculation</th>
                    <th>Durée</th>
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
                        $i = 1;
                        $reqInfoEnfant = $db->prepare('SELECT * FROM bdd_paie.t_enfants_agent
                        INNER JOIN bdd_paie.t_agent ON t_enfants_agent.agent_ID = t_agent.matricule');
                        $reqInfoEnfant ->execute();
                        while($resInfoEnfant=$reqInfoEnfant->fetch()){
                            $code_enf = $resInfoEnfant['id_enf'];
                            $matricule = $resInfoEnfant['matricule'];
                            $nomComplet = $resInfoEnfant['nom_ag'].' '
                                .$resInfoEnfant['postnom_ag'].' '
                                .$resInfoEnfant['prenom_ag'];
                            
                            $nomComplet_Enf = $resInfoEnfant['nom_enf'].' '
                                .$resInfoEnfant['postnom_enf'].' '
                                .$resInfoEnfant['prenom_enf'];
                            $sexe = $resInfoEnfant['sexe_enf'];
                            $acte_naiss = "fichierEnf_Agent/".$resInfoEnfant['fichier'];
                            $statut = $resInfoEnfant['statut_ID'];
                            /*$durer = $resInfoVehicule['moisEpuration'];
                            $periode = $resInfoVehicule['periodePret'];
                            $monnaie = $resInfoVehicule['monnaie_ID'];
                            $statut = $resInfoVehicule['statut_ID'];*/
                        

                    ?>
                    <td> <?php echo $i++;?> </td>
                    <td> <?php echo $nomComplet;?></td>
                    <td>  <?php echo $matricule;?></td>
                    
                    <td> <?php echo $nomComplet_Enf;?></td>
                    
                    <td> <?php echo $sexe;?> </td>
                    <td> <a href="<?php echo $acte_naiss;?>"> Donwload</a> </td>
                    
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
                                <li><a href="accueil.php?page=Edit_Enfant&code_enfant=<?php echo $code_enf;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                                                <li><a target="_blank" href="print_enfant_ag.php?matric=<?php echo $matricule;?>" style="color:green" > <i class="fa fa-print" style="margin-right: 2px;"></i> Imprimer</a></li>
                                <li class="divider"></li>
                                <li><a href="update_enfant.php?code_enfant_act=<?php echo $code_enf;?>" style="color:green" > <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                                <li><a href="update_enfant.php?code_enfant_desac=<?php echo $code_enf;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li>
                                
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