<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Liste Des Prêts</h3>
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
            <a href="accueil.php?page=Pret" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-money" style="margin-right: 7px;"></i>Octroyer Prêt</a>
            <a href="accueil.php?page=Pret_Print" target="_blank" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:90px;"><i class="fa fa-print" style="margin-right: 7px;"></i> Liste</a>

              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Matricule</th>
                    <th>Nom Complet</th>
                    <th>Réference</th>
                    <th class="hidden-phone">Libelle Paie</th>
                    <th class="hidden-phone">Montant Preter</th>
                    <th class="hidden-phone">A Rembourser</th>
                    <th>A Retenir/mois</th>
                    <th>Durée</th>
                    <th>Période</th>
                    <th class="hidden-phone">Monnaie</th>
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
                        $reqInfoPret = $db->prepare('SELECT * FROM bdd_paie.v_info_pret');
                        $reqInfoPret ->execute();
                        while($resInfoPret=$reqInfoPret->fetch()){
                            $id_pret = $resInfoPret['id_pret'];
                            $matricule = $resInfoPret['matricule'];
                            $nomComplet = $resInfoPret['nom_ag'].' '.$resInfoPret['postnom_ag'].' '.$resInfoPret['prenom_ag'];
                            $nRef = $resInfoPret['N_refPret'];
                            $cod_paie = $resInfoPret['codePaie'];
                            $lib_paie = $resInfoPret['libelle_codePaie'];
                            $montantPreter = $resInfoPret['montantPreter'];
                            $solde = $resInfoPret['solde'];
                            $aPayer = $resInfoPret['montant_a_retenir'];
                            $durer = $resInfoPret['moisEpuration'];
                            $periode = $resInfoPret['periodePret'];
                            $monnaie = $resInfoPret['monnaie_ID'];
                            $statut = $resInfoPret['statut_ID'];
                        

                    ?>
                    <td> <?php echo $matricule;?> </td>
                    <td> <?php echo $nomComplet;?></td>
                    <td >  <?php echo $nRef;?></td>
                    <td > <?php echo $cod_paie.' | '.$lib_paie;?> </td>
                    <td > <?php echo $montantPreter;?> </td>
                    <td> <?php echo $solde;?> </td>
                    <td> <?php echo $aPayer;?> </td>
                    <td> <?php echo $durer;?> </td>
                    <td> <?php echo $periode;?> </td>
                    <td> <?php echo $monnaie;?> </td>
                    <td> <?php echo $statut;?> </td>
                    <td class="hidden-phone">
                        <!-- Single button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                             <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Edit_Prets&id_pret=<?php echo $id_pret;?>"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <!--li><a href="update_agent.php?id_act=<?php //echo $matricule;?>">Activer</a></li>
                                <li><a href="update_agent.php?id_des=<?php //echo $matricule;?>">Désactiver</a></li>
                                <li class="divider"></li>
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
        <br><br><br><br><br><br>
        <!-- /row -->