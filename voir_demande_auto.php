<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Liste Des Congés autorisés</h3>
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
            <a href="accueil.php?page=Demande_Conger" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i> Ajouter </a>
          <!--   <a target="_blank" href="print_grade_ag.php" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Imprimer La Liste</a>
           <a href="print_grade_ag.php" download ="rpt_grade" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:70px;"><i class="fa fa-download" style="margin-right: 7px;"></i>PDF</a>-->

              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Matricule</th>
                    <th>Noms</th>
                    <th>Type de Congé</th>
                    <th>Excercice</th>
                    <th >Nombre de jour demandé</th>
                    <th >Nombre de jour accordé</th>
                    <th >Ecart</th>
                    <th>Date début</th>
                    <th >Date fin</th>
                    <th >Statut</th>
                    <th >Action</th>
                    
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
                  
                  <tr class="gradeC">
                  <?php
                        $reqGrade = $db->prepare('SELECT * FROM bdd_paie.t_demandeconge INNER JOIN bdd_paie.t_typconge ON t_typconge.id_type_conge=t_demandeconge.id_typeconge INNER JOIN bdd_paie.t_agent ON t_agent.matricule=t_demandeconge.matricule WHERE statut =:statut and etat=:etat');
                        $reqGrade -> bindValue(':statut',"auto");
                        $reqGrade -> bindValue(':etat',"act");
                        $reqGrade ->execute();

                        while($resGrade=$reqGrade->fetch()){
                          $id_dem_conge = $resGrade['id_demande'];
                            $matricule = $resGrade['matricule'];
                            $mon = $resGrade['nom_ag'];
                            $postnom = $resGrade['postnom_ag'];
                            $prenom = $resGrade['prenom_ag'];
                            $conge = $resGrade['libelle_conge'];
                            $date_demande = $resGrade['date_demande'];
                            $dateDu = $resGrade['date_debut'];
                            $dateAu = $resGrade['date_fin'];
                            $excercice = $resGrade['excercice'];
                            $nbresol = $resGrade['nbrejr_solic'];
                            $nbreAcc =  $resGrade['nbrejr_accord'];
                            $statut = $resGrade['statut'];
                            $creerPar = $resGrade['statut'];
                    ?>
                    <td> <?php echo $matricule;?> </td>
                    <td> <?php echo $mon;?> <?php echo $postnom;?></td>
                    <td> <?php echo $conge;?> </td>
                    <td> <?php echo $excercice;?> </td>
                    <td> <?php echo $nbresol;?> </td>
                    <td> <?php echo $dateDu;?> </td> 
                    <td> <?php echo $dateAu;?> </td> 
                    
                    <td class="center">
                    <?php 
                        if($statut == "aprv"){
                          echo '<i class="fa fa-check-circle fa-lg" style="margin-right: 5px; color:green;width: 25px"></i>';
                        }else{
                          echo '<i class="fa fa-ban fa-lg" style="margin-right: 15px ;color:red;"></i>';
                        }
                      
                      ?>
                    </td>
                    <td class="hidden-phone">
                        <!-- Single button -->
                        <div class="btn-group">
                           <!--  <button type="button" class="btn btn-theme " data-toggle="dropdown">
                             <span class="caret" style="width: 25px;"></span>
                            </button>
                             <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Autorisation_Conger&id=<?php echo $id_dem_conge;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <li class="divider"></li>
                              <li><a href="update_grade.php?code_gr_act=<?php echo $code_grade;?>" style="color:green" > <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                                <li><a href="update_grade.php?code_gr_desac=<?php echo $code_grade;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li>
                               
                            </ul>-->
                            <a href="accueil.php?page=Autorisation_Conger&id=<?php echo $id_dem_conge;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> </a></li>
                        </div>
                        

                        <!--Single button -->
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