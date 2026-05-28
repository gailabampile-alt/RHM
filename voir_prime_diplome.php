<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> LISTE PRIME DIPLOME</h3>
        <div class="row mb">
          <!-- page start-->
          
          <div class="content-panel" style="margin: 15px;">
          <?php if (isset($_GET['debug_session']) && $_GET['debug_session'] == '1') { ?>
            <div class="alert alert-warning"><pre style="white-space:pre-wrap;">Session ID: <?php echo session_id(); ?>
<?php echo htmlspecialchars(print_r($_SESSION, true)); ?></pre></div>
          <?php } ?>
          <?php if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="alert">×</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
            </div>
          <?php } ?>
            <div class="adv-table" style="margin: 5px;">
            <a href="accueil.php?page=PrimeDiplome" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i> Ajouter </a>
            <!--a href="accueil.php?page=#" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:90px;"><i class="fa fa-print" style="margin-right: 7px;"></i> Liste</a-->

              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Libellé</th>
                    <th>Montant</th>
                    <th>Dévise</th>
                    <th>Créer Par</th>
                    <th class="hidden-phone">Modifier Par</th>
                    <th class="hidden-phone">Statut</th>
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
                        $reqGetProvince = $db->prepare('SELECT 
                        detail_nivetude_montant.niv_etude_ID,detail_nivetude_montant.montant,detail_nivetude_montant.monnaie_ID,detail_nivetude_montant.statut_ID,detail_nivetude_montant.id_det_nivetud_mont,detail_nivetude_montant.creerPar,detail_nivetude_montant.modifierPar,t_niv_etud.libelle_niv_etud
                        FROM bdd_paie.detail_nivetude_montant
                        INNER JOIN bdd_paie.t_niv_etud ON t_niv_etud.id_niv_etud = detail_nivetude_montant.niv_etude_ID');
                        $reqGetProvince ->execute();
                        while($resGetProvince=$reqGetProvince->fetch()){
                            $id_nivEtu = $resGetProvince['id_det_nivetud_mont'];
                            $code = $resGetProvince['niv_etude_ID'];
                            $lib = $resGetProvince['libelle_niv_etud'];
                            $montant = $resGetProvince['montant'];
                            $devise = $resGetProvince['monnaie_ID'];
                            $creerPar = $resGetProvince['creerPar'];
                            $modifierPar = $resGetProvince['modifierPar'];
                            $statut = $resGetProvince['statut_ID'];
                    ?>
                    <td> <?php echo $code;?> </td>
                    <td> <?php echo $lib;?></td>
                    <td> <?php echo $montant;?> </td>
                    <td> <?php echo $devise;?></td>
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
                          $noms = "";
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
                                <?php if($statut == "act"){ ?>
                                <li><a href="accueil.php?page=Edit_PrimeDiplome&code=<?php echo $id_nivEtu;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <?php } else { ?>
                                <li><a href="#" style="color:gray" data-toggle="modal" data-target="#disabledPrimeModal"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <?php } ?>
                                <li class="divider"></li>
                                <li><a href="update_prime_diplome.php?code_act=<?php echo $id_nivEtu;?>" style="color:green" > <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                                <li><a href="update_prime_diplome.php?code_desac=<?php echo $id_nivEtu;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li>
                            </ul>
                        </div>
                        <!--div class="pull-left hidden-phone">
                          <a class="btn btn-success btn-xs" ><i class=" fa fa-check"></i></a>
                          <a class="btn btn-primary btn-xs" href="accueil.php?page=Edit_Province&code_prov=<?php echo $code_prov;?>"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                        </div-->
                        
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
        
        <!-- Modal: prime désactivée -->
        <div class="modal fade" id="disabledPrimeModal" tabindex="-1" role="dialog" aria-labelledby="disabledPrimeModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="disabledPrimeModalLabel">Prime désactivée</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Cette prime est désactivée, pas moyen de modifier.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>
