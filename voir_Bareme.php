<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Liste Des Barèmes</h3>

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

            <div class="col-lg-6">
              <a href="accueil.php?page=Bareme" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i>Ajouter</a>
              <a target="_blank" href="print_bareme.php" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:90px;"><i class="fa fa-print" style="margin-right: 7px;"></i> Liste</a>
              
           </div>
           <br>
           <br>
           <br>
            <div class="adv-table" style="margin: 5px;">
              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                   <!--  <th>Grade</th>-->
                    <th>Id Barème</th>
                    <th class="hidden-phone">Libelle Barème</th>
                    <th class="hidden-phone">Creer Par</th>
                    <th class="hidden-phone">Date </th>
                    <th>Statut</th>
                    <th class="hidden-phone">Actions</th>
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
                        $bareme = $db->prepare('SELECT 
                        t_bareme.id_bar,t_bareme.LibelleBar,t_bareme.Creat_Par,t_bareme.Date_Creat,
                        t_bareme.modifierPar,t_bareme.Date_Modif,t_bareme.statut_ID,t_agent.nom_ag,
                        t_agent.postnom_ag,t_agent.prenom_ag
                        FROM bdd_paie.t_bareme INNER join bdd_paie.t_utilisateurs on t_bareme.Creat_Par=t_utilisateurs.id_user 
                        INNER JOIN bdd_paie.t_agent on t_agent.matricule=t_utilisateurs.agent_ID 
                        ');//INNER JOIN bdd_paie.t_statut ON t_bareme.statut_ID=t_statut.code_st
                        $bareme ->execute();
                        while($resbareme=$bareme->fetch()){
                            $id_bar = $resbareme['id_bar'];
                            $LibelleBar  = $resbareme['LibelleBar'];
                            $creerPar = $resbareme['Creat_Par'];
                            $Date_Creat = $resbareme['Date_Creat'];
                            $modifierPar=$resbareme['modifierPar'];
                            $Date_Modif = $resbareme['Date_Modif'];
                            $statut = $resbareme['statut_ID'];
                           $datecreatfr= $Date_Creat;

                        $nom_utilisateur=$resbareme['nom_ag'];
                        $postnom_utilisateur=$resbareme['postnom_ag'];
                        $prenom_utilisateur=$resbareme['prenom_ag'];
                        $nomComplet= $nom_utilisateur." ".$postnom_utilisateur." ".$prenom_utilisateur ;
                       
                    ?>
                    <td> <?php echo  $id_bar;?> </td>
                    <td> <?php echo  $LibelleBar;?></td>
                    <td class="center hidden-phone"> <?php echo  $nomComplet;?> </td>
                    <td class="center hidden-phone"> <?php echo  $datecreatfr;?> </td>
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
                              
                                <li><a href="accueil.php?page=Edit_Bareme&id=<?php echo $id_bar;?>">Modifier</a></li>
                                <li><a href="<?php echo $id_bar;?>">Activer</a></li>
                                <li><a href="<?php echo $id_bar;?>">Désactiver</a></li>
                                <!--li class="divider"></li>
                                <li><a href="#">Separated link</a></li-->
                            </ul>
                            <ul class="dropdown-menu" role="menu">
                               <?php if($statut == "act"){ ?>
                                <li><a href="accueil.php?page=Edit_Bareme&id=<?php echo $id_bar;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <?php } else { ?>
                                <li><a href="#" style="color:gray" data-toggle="modal" data-target="#disabledBaremeModal"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <?php } ?>

                                <li class="divider"></li>
                                <li><a href="update_bareme.php?bareme_act=<?php echo $id_bar;?>" style="color:green" > <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                                <li><a href="update_bareme.php?bareme_desac=<?php echo $id_bar;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li>
                                
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
         <!-- Modal: Bareme désactivé -->
        <div class="modal fade" id="disabledBaremeModal" tabindex="-1" role="dialog" aria-labelledby="disabledBaremeModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="disabledBaremeModalLabel">Bareme désactivé</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Ce bareme est désactivé, il est impossible de le modifier.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>