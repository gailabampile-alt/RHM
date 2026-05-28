<?php
    include_once('sys_connexion.php');

    $nomComplet = '';

?>

<h3><i class="fa fa-angle-right"></i> Liste Des Agents Par Activité</h3>
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
            <a href="accueil.php?page=Carriere" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i> Mouvement </a>
            <!--a target="_blank" href="print_agent_activiter_act.php" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Imprimer</a>
            <a href="accueil.php?page=#" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Imprimer Act</a>
            <a href="print_agent_siege_act.php" download ="download" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:70px;"><i class="fa fa-download" style="margin-right: 7px;"></i>PDF</a-->

              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>MATRICULE</th>
                    <th>NOMS</th>
                    <th>ETAT</th>
                    <th>DATE DEBUT</th>
                    <th>CREER PAR</th>
                    <th class="hidden-phone">MODIFIER PAR</th>
                    <th class="hidden-phone">STATUT</th>
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
                      	$compt = 0;
                        $reqAgent_Siege = $db->prepare("SELECT 
                        aga.agent_ID,aga.code_activ_ID,aga.dateDebut,aga.dateFin,aga.statut_ID,aga.creerPar,aga.modifierPar,
                        CONCAT(ag.nom_ag,' ',ag.postnom_ag,' ',ag.prenom_ag) AS noms,ag.activiter_ID,
                        act.libelle_activ
                        FROM bdd_paie.detail_agent_activ AS aga
                        INNER JOIN bdd_paie.t_agent AS ag ON aga.agent_ID = ag.matricule
                        INNER JOIN bdd_paie.t_activite AS act ON aga.code_activ_ID = act.code_activ
                        WHERE aga.statut_ID = 'act' ");
                        $reqAgent_Siege ->execute();
                        while($resAgent_Siege=$reqAgent_Siege->fetch()){
                            $matric = $resAgent_Siege['agent_ID'];
                            $noms = $resAgent_Siege['noms'];
                            $code_act = $resAgent_Siege['code_activ_ID'];
                            $lib_act = $resAgent_Siege['libelle_activ'];
                            $dateDebut = $resAgent_Siege['dateDebut'];
                            $dateFin = $resAgent_Siege['dateFin'];
                            $creerPar = $resAgent_Siege['creerPar'];
                            $modifierPar = $resAgent_Siege['modifierPar'];
                            $statut = $resAgent_Siege['statut_ID'];
                            $compt++;
                    ?>
                    <td> <?php echo $compt;?> </td>
                    <td> <?php echo $matric;?></td>
                    <td> <?php echo $noms;?> </td>
                    <td> <?php echo $code_act.' | '.$lib_act;?></td>
                    <td> <?php echo $dateDebut;?></td>
                    <td>  
                    <?php 
                        if($creerPar == "sysAdmin"){
                          echo $creerPar;
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
                    <td > 
                    <?php 
                        if($modifierPar == "sysAdmin"){
                          echo $modifierPar;
                        }else{
                          $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                          WHERE id_user = :modifierPar');
                          $reqGetInfoUser->bindValue(':modifierPar',$modifierPar);
                          $reqGetInfoUser->execute();
                          while ($resGetInfoUser = $reqGetInfoUser->fetch()) {
                            $nom_postnom = $resGetInfoUser['nom_ag'].' '.$resGetInfoUser['postnom_ag'];
                            $prenom = ucfirst(strtolower($resGetInfoUser['prenom_ag']));
                            $noms = $nom_postnom.' '.$prenom;
                          }
                          echo $noms;
                        }
                      
                      ?>
                    </td>
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
                                <li><a target="_blank" href="printMoveActiviter.php?code=<?php echo $matric;?>" style="color:darkblue"> <i class="fa fa-print" style="margin-right: 2px;"></i> Imprimer</a></li>
                                <!--li class="divider"></li>
                                <li><a href="print_carriereAll.php?code=<?php //echo  $matric;?>" style="color:green" > <i class="fa fa-file-o" style="margin-right: 2px;"></i> Print Carrière</a></li>
                                <li><a href="update_fonction.php?code_fonct_desac=<?php //echo $code_code_sieg;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li-->
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