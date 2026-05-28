<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Liste De Congés Encours</h3>
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
             <!-- <a href="accueil.php?page=Demande_Conger" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i> Ajouter </a>-->
            <a target="_blank" href="print_liste_conge.php" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:90px;"><i class="fa fa-print" style="margin-right: 7px;"></i> Liste</a>
            

              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                  <th>Matricule</th>
                    <th>Noms</th>
                    <th>Congé</th>
                    <th>Excercice</th>
                    <th>Nombre de jour</th>
                    <th>date debut</th>
                    <th>date fin</th>
                    <th class="hidden-phone">document</th>
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
                  
                  <tr class="gradeC">
                  <?php
                        $reqGrade = $db->prepare('SELECT * FROM bdd_paie.t_conge INNER JOIN bdd_paie.t_demandeconge ON t_demandeconge.id_demande =t_conge.id_dem_conge INNER JOIN bdd_paie.t_typconge ON t_typconge.id_type_conge=t_demandeconge.id_typeconge INNER JOIN bdd_paie.t_agent ON t_agent.matricule=t_demandeconge.matricule WHERE CURDATE() BETWEEN t_conge.date_debut AND t_conge.date_fin AND t_conge.statut=:statut');
                        $reqGrade -> bindValue(':statut',"act");
                        $reqGrade ->execute();

                        while($resGrade=$reqGrade->fetch()){
                            $matricule= $resGrade['matricule'];
                            $agent = $resGrade['nom_ag'].' '.$resGrade['postnom_ag'].' '.$resGrade['prenom_ag'];
                            $conge = $resGrade['libelle_conge'];
                            $date_demande = $resGrade['date_demande'];
                            $dateDu = $resGrade['date_debut'];
                            $dateAu = $resGrade['date_fin'];
                            $excercice = $resGrade['excercice'];
                            $nbrejr = $resGrade['nbre_jour'];
                           // $nbreben = $resGrade['nbrejr_accord'];
                            $statut = $resGrade['statut'];
                            $creerPar = $resGrade['statut'];
                            $doc = "Documents/".$resGrade['document'];
                            //$doc = "Documents/".$resInfoEnfant['document'];
                            $document =$resGrade['document'];
                            
                    ?>
                    <td> <?php echo $matricule;?> </td>
                    <td> <?php echo $agent;?> </td>
                    <td> <?php echo $conge;?> </td>
                    <td> <?php echo $excercice;?> </td>
                    <td> <?php echo $nbrejr;?> </td>
            
                    <td> <?php echo $dateDu;?> </td> 
                    <td> <?php echo $dateAu;?> </td> 
                    <td> <?php echo $document;?> </td>
                    <td> <a target="_blank" href="<?php echo $doc;?>" Donwload="download"> Donwload</a> </td>
                    <td> 
                      <?php 
                      
                          $reqsanct = $db->prepare("SELECT * FROM bdd_paie.t_sanct_agent WHERE matricule = :matricule");
                          $reqsanct->bindValue(':matricule',$matricule);
                          $reqsanct->execute();
                          while ($ressanct=$reqsanct->fetch()) {
                      ?>
                           
                          <?php
                            };
                          ?> 
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