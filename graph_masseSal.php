<?php
    include('sys_connexion.php');
    include('sys_fonction.php');

    //get_MasseSal($db,$typePaie,$codePaie,$periode);
/*
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
  */
    
$dataPoints = [];

$sql = "
SELECT 
    periode,
    SUM(
        CASE
            WHEN codeEiPaie = 999 THEN montant_payer
            WHEN codeEiPaie IN (412, 408, 409) THEN Montant_a_retenir
            ELSE 0
        END
    ) AS masse
FROM bdd_paie.t_paie
WHERE codeEiPaie IN (999, 412, 408, 409)
GROUP BY periode
ORDER BY periode
";

$req = $db->prepare($sql);
$req->execute();

while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
    $dataPoints[] = [
        "y" => (float)$row['masse'],
        "label" => $row['periode']
    ];
}

  ?>
  

<script>
window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        title: {
            text: "Masse Salariale Mensuelle – CADECO"
        },
        axisX: {
            title: "Période"
        },
        axisY: {
            title: "Montant (CDF)",
            minimum: 0,
            labelFormatter: function (e) {
                return CanvasJS.formatNumber(e.value, "#,##0");
            }
        },
        data: [{
            type: "column",
            color: "#2E86C1",
            indexLabel: "{y}",
            indexLabelFontSize: 11,
            toolTipContent: "<b>{label}</b><br>Montant : {y} CDF",
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
              <!--a href="#" target="_blank" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Toute La CADECO</a>
              <a href="#" target="_blank" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-print"></i> Print All</a-->
              <!--a href="print_agent_autres.php" target="_blank" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Autres</a-->
          </div>
          <!-- page end-->
           
        </div>
      </div>

      <div class="form-panel">
      
        <!--div id="zoneDerecherche">
                  <form class="form-horizontal style-form" method="POST" action="traitement_print_massByActiviter.php" enctype="multipart/form-data">
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

              </div-->



<div class="form-panel">

    <form method="GET" target="_blank">

        <div class="row">

            <!-- FILTRE PERIODE -->
            <div class="col-md-4">
                <label class="col-sm-3 control-label">Période</label>
                <select name="periode" class="form-control chzn-select" required>
                    <option value="">-- Choisir la période --</option>
                    <?php
                    $reqPeriode = $db->query("
                        SELECT DISTINCT periode
                        FROM bdd_paie.t_paie
                        ORDER BY periode
                    ");
                    while ($p = $reqPeriode->fetch()) {
                        echo "<option value='{$p['periode']}'>{$p['periode']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- BOUTONS -->
            <div class="col-md-8" style="padding-top:25px;">

                <!-- EXCEL -->
                <button
                    type="submit"
                    formaction="export_masse_excel.php"
                    class="btn btn-success"
                >
                    <i class="fa fa-file-excel-o"></i> Export Excel
                </button>

                <!-- PDF -->
                <button
                    type="submit"
                    formaction="export_masse_pdf.php"
                    class="btn btn-danger"
                >
                    <i class="fa fa-file-pdf-o"></i> Export PDF
                </button>

            </div>

        </div>

    </form>

</div>



              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Periode</th>
                    <th>Type Paie</th>
                    <th>Nature du Montant</th>
                    <th>Montant</th>
                    
                  </tr>
                </thead>
                <tbody>
                  
                  <tr class="gradeC_">
                    <?php
                        $reqInfoAgent = $db->prepare("
SELECT 
    periode,
    type_paie,
    CASE
        WHEN codeEiPaie = 999 THEN 'NET A PAYER'
        WHEN codeEiPaie = 412 THEN 'RETENUE SYNDICALE'
        WHEN codeEiPaie = 408 THEN 'RETENUE CNSS'
        WHEN codeEiPaie = 409 THEN 'RETENUE IPR'
    END AS nature_montant,
    SUM(
        CASE 
            WHEN codeEiPaie = 999 
            THEN montant_payer 
            ELSE Montant_a_retenir 
        END
    ) AS total_montant
FROM bdd_paie.t_paie
WHERE codeEiPaie IN (999, 412, 408, 409)
GROUP BY periode, type_paie, nature_montant
ORDER BY periode, type_paie;
;");
                        //$reqInfoAgent ->bindValue(':code_activ',$activite);
                        $reqInfoAgent ->execute();
                        $nombre = $reqInfoAgent->rowCount();
                         
                        while($resInfoAgent=$reqInfoAgent->fetch()){
                            $periode = $resInfoAgent['periode'];
                            $typePaie = $resInfoAgent['type_paie'];
                            $montant = $resInfoAgent['total_montant'];
                           // $age = $resInfoAgent['DiffDate'];
                    ?>
                    <td> <?php echo $periode;?> </td>
                    <td> <?php 
                          switch ($typePaie) {
                                  case 'R': echo "Rentre Scolaire"; break;
                                  case 'G': echo "Gratification";break;
                                  case 'N': echo "Normal";break;
                                  case 'V': echo "Rente Viagere";break;
                                  default:  echo "Inconnu";
                              }
                          ?>
                           
                    </td>
                    <td> <?php echo $resInfoAgent['nature_montant'];?> </td>
                    <td> <?php echo number_format($montant, 2, ',', ' ') . " FC" ;?> </td>
                  </tr>
                  <?php } ?>
                  
                </tbody>
              </table>
            </div>
      </div>
        



<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    

