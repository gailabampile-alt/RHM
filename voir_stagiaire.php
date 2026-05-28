<?php
    //session_start();
    include_once('sys_connexion.php');
    
  //Requête de mise à jour
  /*
  $sql = "UPDATE bdd_paie.t_stagiare SET statut_ID = :statut_ID,dateFin_stg = NOW(),modifierPar = :modifierPar
      WHERE dateFin_stg < CURDATE()";

  // Préparer et exécuter
  $stmt = $db->prepare($sql);
  $stmt->execute([
      ':statut_ID' => 'desac',
      ':modifierPar' => $_SESSION['id_utilisateur']
  ]);
  */

?>

<h3><i class="fa fa-angle-right"></i> Liste Des Stagiaires</h3>
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
            <a href="accueil.php?page=frm_stagiaire" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:130px;"><i class="fa fa-user" style="margin-right: 7px;"></i>Nouveau </a>
            <a href="print_stagiaire.php" target="_blank" style="margin-left:15px;"><img src="img/icons8_PDF_32.png"></a>
            <a href="rapport/xlsx/xPrint_stagiaire.php" target="_blank" style="margin-left:10px;"><img src="img/icons8_Microsoft_Excel_32.png"></a>
            <!--a href="#" target="_blank" style="margin-left:10px;"><img src="img/icons8_Microsoft_Word_32.png"></a-->

              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Nom Complet</th>
                    <th>Sexe</th>
                    <th class="hidden-phone">Niveau</th>
                    <th class="hidden-phone">Siège</th>
                    <th class="hidden-phone">Direction</th>
                    <th>Date Debut</th>
                    <th>Date Fin</th>
                    <th>Etat</th>
                    <!--th class="hidden-phone">Syndicat</th-->
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
                        $reqInfoAgent = $db->prepare('SELECT * FROM bdd_paie.t_stagiare');
                        //$reqInfoAgent->bindvalue('statut_ID','act');
                        $reqInfoAgent ->execute();
                        while($resInfoAgent=$reqInfoAgent->fetch()){
                            $id_stg = $resInfoAgent['id_stg'];
                            $nomComplet = $resInfoAgent['nom_stg'].' '.$resInfoAgent['postnom_stg'].' '.$resInfoAgent['prenom_stg'];
                            $sex = $resInfoAgent['sexe_stg'];
                            $nivEtud = $resInfoAgent['nivEtude_stg'];
                            $siege = $resInfoAgent['siege_stg'];
                            $dir = $resInfoAgent['dir_stg'];
                            $dateDebut = $resInfoAgent['dateDebut_stage'];
                            $dateFin = $resInfoAgent['dateFin_stg'];
                            $statut = $resInfoAgent['statut_ID'];
                            //$syndicat = $resInfoAgent['libelle_syndi'];
                        

                    ?>
                    <td> <?php echo $id_stg;?> </td>
                    <td> <?php echo $nomComplet;?></td>
                    <td class="hidden-phone">  <?php echo $sex;?></td>
                    <td class="center hidden-phone"> <?php echo $nivEtud;?> </td>
                    <td class="center hidden-phone"> <?php echo $siege;?> </td>
                    <td> <?php echo $dir;?> </td>
                    <td> <?php echo $dateDebut;?> </td>
                    <td> <?php echo $dateFin;?> </td>
                    <td class="center">
                    <?php 
                        if($statut == "act"){
                          echo '<i class="fa fa-check-circle fa-lg" style="margin-right: 5px; color:green;width: 25px"></i>';
                        }else{
                            echo '<i class="fa fa-ban fa-lg" style="margin-right: 15px ;color:red;"></i>';
                        }
                      
                      ?> 
                    </td>
                    <!--td> <?php /* echo $syndicat; */ ?> </td-->
                    <td class="hidden-phone">
                        <!-- Single button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                             <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Edit_Stagiaire&id_stg=<?php echo $id_stg;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <li class="divider"></li>
                                <li><a href="accueil.php?page=Edit_Stagiaire_act&id_stg=<?php echo $id_stg;?>&st=<?php echo $statut;?>" style="color:green" > <i class="fa fa-check-circle fa-lg" style="margin-right: 2px;"></i> Nouveau Stage</a></li>
                                <li><a href="update_stagiaire.php?code_desac_stg=<?php echo $id_stg;?>&dateF=<?php echo $dateFin;?>" style="color:red" > <i class="fa fa-ban" style="margin-right: 2px;"></i> Fin Stage</a></li>
                                <li><a target="_blank" href="print_profil_stagiare.php?id_stg=<?php echo $id_stg;?>" style="color:black"> <i class="fa fa-print" style="margin-right: 2px;"></i> Imprimer</a></li>
                                
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