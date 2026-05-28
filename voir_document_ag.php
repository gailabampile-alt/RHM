<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Document Des Agents</h3>
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
            <a href="accueil.php?page=Documents" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i>Ajouter</a>
            <!--a href="print_doc_ag_all.php" target="_blank" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Imprimer La Liste</a>
            <a href="print_doc_ag_all.php" download ="download" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:70px;"><i class="fa fa-download" style="margin-right: 7px;"></i>PDF</a-->
        
              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>N Réference</th>
                    <th>Libelle</th>
                    <th>Matricule</th>
                    <th class="hidden-phone">Nom, Postnom & Prénom</th>
                    <th class="hidden-phone">Document</th>
                    <!--th class="hidden-phone">Carte Rose</th>
                    <th>Immatriculation</th>
                    <th>Durée</th>
                    <th>Période</th>
                    <th class="hidden-phone">Monnaie</th-->
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
                        $reqInfoEnfant = $db->prepare('SELECT 
                        t_doc_agent.id_doc,t_doc_agent.id_typedoc,t_doc_agent.matricule,t_doc_agent.ref_doc,
                        t_doc_agent.observation,t_doc_agent.document,t_doc_agent.document_byte,t_doc_agent.creerPar,
                        t_doc_agent.datecreat,t_doc_agent.dateModif,t_doc_agent.modifierPar,
                        t_agent.nom_ag,t_agent.postnom_ag,t_agent.prenom_ag,t_type_doc.libelle_typedoc
                        FROM bdd_paie.t_doc_agent
                        INNER JOIN bdd_paie.t_agent ON  t_doc_agent.matricule = t_agent.matricule
                        INNER JOIN bdd_paie.t_type_doc ON t_type_doc.id_typedoc = t_doc_agent.id_typedoc');
                        $reqInfoEnfant ->execute();
                        while($resInfoEnfant=$reqInfoEnfant->fetch()){
                            $id_doc = $resInfoEnfant['id_doc'];
                            $lib_type_doc = $resInfoEnfant['libelle_typedoc'];
                            $nRef = $resInfoEnfant['ref_doc'];
                            $matricule = $resInfoEnfant['matricule'];
                            $nomComplet = $resInfoEnfant['nom_ag'].' '
                                .$resInfoEnfant['postnom_ag'].' '
                                .$resInfoEnfant['prenom_ag'];
                            
                            $doc = "Documents/".$resInfoEnfant['document'];
                            /*$durer = $resInfoVehicule['moisEpuration'];
                            $periode = $resInfoVehicule['periodePret'];
                            $monnaie = $resInfoVehicule['monnaie_ID'];
                            $statut = $resInfoVehicule['statut_ID'];*/
                        

                    ?>
                    <td> <?php echo $i++;?> </td>
                    <td> <?php echo $lib_type_doc;?> </td>
                    <td> <?php echo $nRef;?> </td>
                    <td>  <?php echo $matricule;?></td>
                    <td> <?php echo $nomComplet;?></td>
                    <td> <a target="_blank" href="<?php echo $doc;?>" Donwload="download"> Donwload</a> </td>
                    <td class="hidden-phone">
                        <!--Single button-->
                        <div class="btn-group">
                            <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                             <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Edit_Documents&code_doc_ag=<?php echo $id_doc;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <li class="divider"></li>
                                <li><a target="_blank" href="print_doc_ag_only.php?matric=<?php echo $matricule;?>" style="color:green" > <i class="fa fa-print" style="margin-right: 2px;"></i> Imprimer</a></li>
                                <!--li><a href="update_vehicule.php?code_vehic_desac=<?php /*echo $code_vehic;*/?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li-->
                                
                            </ul>
                            
                        </div>
                        <!--Single button-->
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