<?php
  include_once('sys_connexion.php');

  $chartStmt = $db->query(
      "SELECT id_role, Profif, COUNT(*) AS total
       FROM bdd_paie.v_historique
       GROUP BY id_role, Profif
       ORDER BY total DESC"
  );

  $dataPoints = [];
  while ($row = $chartStmt->fetch(PDO::FETCH_ASSOC)) {
      $dataPoints[] = [
          "label"  => $row['Profif'],
          "symbol" => $row['id_role'],
          "y"      => (int)$row['total']
      ];
  }
?>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2",
	animationEnabled: true,
	title: {
		text: "HISTORIQUE DE CONNEXION"
	},
	data: [{
		type: "doughnut",
		indexLabel: "{symbol} - {y}",
		yValueFormatString: "###\"\"",
		showInLegend: true,
		legendText: "{label} : {y}",
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
            <!--a href="accueil.php?page=#" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Imprimer La Liste</a-->

              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Entité</th>
                    <th>Profil</th>
                    <th>UserID</th>
                    <th>Noms</th>
                    <th>Date Connexion </th>
                    <th class="hidden-phone">Date deconnexion</th>
                    
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
                         $reqPlanningRetraite = $db->prepare("SELECT distinct * from bdd_paie.v_historique ORDER BY `Date_Connexion` DESC");
                         $reqPlanningRetraite ->execute();
                        while($resPlanningRetraite=$reqPlanningRetraite->fetch()){
                            $siege = $resPlanningRetraite['siege'];
                            $entite = $resPlanningRetraite['Profif'];
                            $userid = $resPlanningRetraite['UserID'];
                            $Noms = $resPlanningRetraite['Noms'];
                            $date_con = $resPlanningRetraite['Date_Connexion'];
                            $date_decon = $resPlanningRetraite['date_deconnexion'];
                    ?>
                    <td> <?php echo $siege;?> </td>
                    <td> <?php echo $entite;?></td>
                    <td> <?php echo $userid;?> </td>
                    <td> <?php echo $Noms;?></td>
                    <td> <?php echo  $date_con;?></td>
                   
                    <td ><?php echo $date_decon;?></td></td>
                  </tr>
                  <?php } ?>
                  
                </tbody>
              </table>
            </div>
          </div>
          <!-- page end-->
        </div>


<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>