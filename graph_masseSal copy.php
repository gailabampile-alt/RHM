<?php
    include('sys_connexion.php');
    include('sys_fonction.php');

    //get_MasseSal($db,$typePaie,$codePaie,$periode);

    $dataPoints = array(
    array("y" => 900900909090, "label" => "Janvier"),
    array("y" => 85066677782, "label" => "Fevrier"),
    array("y" => get_MasseSal($db,'N','999','11/2025'), "label" => "Mars"),
    array("y" => 652666777888, "label" => "Avril"),
    array("y" => 350666777888, "label" => "Mai"),
    array("y" => 304455342, "label" => "Juin"),
    array("y" => 20000000000, "label" => "Juillet"),
    array("y" => 857666777888, "label" => "Aout"),
    array("y" => 650666777888, "label" => "Septembre"),
    array("y" => 550666777888, "label" => "Octobre"),
    array("y" => 740666777888, "label" => "Novembre"),
    array("y" => 430666777888, "label" => "Decembre")  );
  
  ?>
  <script>
  window.onload = function () {
  
  var chart = new CanvasJS.Chart("chartContainer", {
    title: {
      text: "Masse Salariale"
    },
    axisY: {
      title: "Masse Salariale en (CDF)"
    },
    data: [{
      type: "line",
      dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
  });
  chart.render();
  
  }
  </script>

      <div>
          <div class="form-panel">
              <div class="row">
                  <div class="col-md-12">
                      <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                  </div>
                  <!--div class="col-md-4">
                      
                      <div id="chartContainer1" style="height: 700px; width: 100%;"></div>
                  </div-->

              </div>
          </div>
      </div>


      <div class="row mt-5">
          <!-- page start-->
          
          <div class="content-panel---" style="margin: 15px;">
          <?php /*if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="alert">×</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
            </div>
          <?php } */?>
            <div class="adv-table" style="margin: 5px;">
              <!--a href="accueil.php?page=Fonction" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i> Ajouter </a-->
              <a href="#" target="_blank" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Toute La CADECO</a>
              <a href="#" target="_blank" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-print"></i> Print All</a>
              <!--a href="print_agent_autres.php" target="_blank" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Autres</a-->
          </div>
          <!-- page end-->
           
        </div>
      </div>

      <div class="form-panel">
      
        <div id="zoneDerecherche">
                  <form class="form-horizontal style-form" method="POST" action="traiemnt_print_activite.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-xl-8">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Type Masse</label>
                                <div class="col-sm-8">
                                    <select class="form-control chzn-select" name="activ" required>
                                        <option value="VIDE"> Choisir l'Activiter </option>
                                        <?php
                                            $reqGetActiviter = $db->prepare('SELECT code_activ,libelle_activ FROM bdd_paie.t_activite');
                                            $reqGetActiviter->execute();
                                            while($resGetActiviter = $reqGetActiviter->fetch()){
                                                $cod_activ = $resGetActiviter['code_activ']; 
                                                $lib_activ = $resGetActiviter['libelle_activ'];?>
                                            <option value="<?php echo $cod_activ;?>"> <?php echo validation_donnees($lib_activ);?> </option>
                                        <?php } ?>  
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-8">
                                  <select class="form-control chzn-select" name="siege">
                                      <option value=""> Choisir du Siège </option>
                                      <?php
                                          $reqGetSiege = $db->prepare('SELECT code_sieg,libelle_sieg FROM bdd_paie.t_siege');
                                          $reqGetSiege->execute();
                                          while($resGetSiege = $reqGetSiege->fetch()){
                                              $cod_sieg = $resGetSiege['code_sieg'];
                                              $lib_sieg = $resGetSiege['libelle_sieg']; ?>
                                          <option value="<?php echo(trim($cod_sieg))?>"> <?php echo $cod_sieg.' | '.$lib_sieg;?> </option>
                                      <?php } ?>
                                  </select>         
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-lg-3 col-md-3 col-xl-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addAgent"
                                    name="printBy" style="margin-left:15px;width:150px;">
                                    <i class="fa fa-print"></i> Print by</button>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xl-3">
                            <div class="form-group">
                                
                            </div>
                        </div>
                        
                    </div>

                </form>  

              </div>

              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Code Siège</th>
                    <th>Type Siège</th>
                    <th>Libellé Siège </th>
                    <th>Matricule</th>
                    <th>Noms</th>
                    <th>Sexe </th>
                    <th>Activiter </th>
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
                        $reqInfoAgent = $db->prepare("SELECT * FROM bdd_paie.t_agent 
                        INNER JOIN bdd_paie.t_activite ON t_activite.code_activ = t_agent.activiter_ID 
                        INNER JOIN bdd_paie.detail_agent_siege ON detail_agent_siege.agent_ID = t_agent.matricule 
                        INNER JOIN bdd_paie.t_siege ON t_siege.code_sieg = detail_agent_siege.siege_ID 
                        INNER JOIN bdd_paie.t_type_siege ON t_type_siege.code_typSieg = t_siege.typeSiege_ID
                        WHERE t_agent.activiter_ID = '01'
                        ORDER BY libelle_activ");
                        //$reqInfoAgent ->bindValue(':code_activ',$activite);
                        $reqInfoAgent ->execute();
                        $nombre = $reqInfoAgent->rowCount();
                         
                        while($resInfoAgent=$reqInfoAgent->fetch()){
                            $cod_sieg = $resInfoAgent['code_sieg'];
                            $type_sieg = $resInfoAgent['libelle_typSieg'];
                            $lib_sieg = $resInfoAgent['libelle_sieg'];
                            $matric = $resInfoAgent['matricule'];
                            $noms = $resInfoAgent['nom_ag'].' '.$resInfoAgent['postnom_ag'].' '.$resInfoAgent['prenom_ag'];
                            $sexe = $resInfoAgent['sexe_ag'];
                            $activiter = $resInfoAgent['libelle_activ'];
                           // $age = $resInfoAgent['DiffDate'];
                    ?>
                    <td> <?php echo $cod_sieg;?> </td>
                    <td> <?php echo $type_sieg;?></td>
                    <td> <?php echo $lib_sieg;?> </td>
                    <td> <?php echo $matric;?> </td>
                    <td> <?php echo $noms;?></td>
                    <td> <?php echo $sexe;?> </td>
                    <td> <?php echo $activiter;?> </td>
                  </tr>
                  <?php } ?>
                  
                </tbody>
              </table>
            </div>
      </div>
        



<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    

