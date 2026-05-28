<?php
    include('sys_connexion.php');
    include('sys_fonction.php');
    include('fonct_date.php');

    $selectedSiege = (isset($_GET['siege']) && !is_array($_GET['siege'])) ? validation_donnees($_GET['siege']) : '';
    $selectedSiegeLabel = '';

    $reqGetSieges = $db->prepare('SELECT code_sieg, libelle_sieg FROM bdd_paie.t_siege ORDER BY libelle_sieg ASC');
    $reqGetSieges->execute();
    $sieges = $reqGetSieges->fetchAll(PDO::FETCH_ASSOC);

    foreach ($sieges as $siegeItem) {
        if ((string) $siegeItem['code_sieg'] === (string) $selectedSiege) {
            $selectedSiegeLabel = $siegeItem['code_sieg'] . ' | ' . $siegeItem['libelle_sieg'];
            break;
        }
    }

    $printPlanRetraiteUrl = 'print_plan_retraite.php';
    if ($selectedSiege !== '') {
        $printPlanRetraiteUrl .= '?siege=' . urlencode($selectedSiege);
    }
    
    function getPlanningRetraiteParSexe($bdd, $valAge, $symbol, $sexe, $siege = '')
    {
        $operator = ($symbol === '>=') ? '>=' : '=';
        $sql = "
            SELECT COUNT(DISTINCT t_agent.matricule) AS total
            FROM bdd_paie.t_agent
            WHERE YEAR(CURDATE()) - YEAR(dateNaiss_ag) $operator :age
            AND bdd_paie.t_agent.activiter_ID = '01'
            AND bdd_paie.t_agent.sexe_ag = :sexe
        ";

        if ($siege !== '') {
            $sql .= "
            AND EXISTS (
                SELECT 1
                FROM bdd_paie.detail_agent_siege
                WHERE detail_agent_siege.agent_ID = t_agent.matricule
                AND detail_agent_siege.siege_ID = :siege
                AND detail_agent_siege.statut_ID = 'act'
            )";
        }

        $reqPlanningRetraite = $bdd->prepare($sql);
        $reqPlanningRetraite->bindValue(':age', (int)$valAge, PDO::PARAM_INT);
        $reqPlanningRetraite->bindValue(':sexe', $sexe);
        if ($siege !== '') {
            $reqPlanningRetraite->bindValue(':siege', $siege);
        }
        $reqPlanningRetraite->execute();

        return (int)$reqPlanningRetraite->fetchColumn();
    }
/*   
$dataPoints = array(
    array("label"=> "Actif", "y"=> $actif),
    array("label"=> "Retraité", "y"=>  $retraite),
    array("label"=> "Suspendu", "y"=> $suspendu),
    array("label"=> "Détachement ou Mise en Disponibilité", "y"=> $detachement),
    array("label"=> "Fin Contrat", "y"=>  $finContrat),
    array("label"=> "Révocation", "y"=> $revocation),
    array("label"=> "Démission d'office", "y"=>$demission),
    array("label"=> "Licenciement", "y"=> $licen),
    array("label"=> "Décédé", "y"=> $deced)
);*/
/*
$dataPoints = array(
    
  array("label"=> "0 an", "y"=> $age65),
	array("label"=> "2024", "y"=> $age64),
	array("label"=> "2025", "y"=> $age63),
	array("label"=> "2026", "y"=> $age62),
	array("label"=> "2027", "y"=> $age61),
	array("label"=> "2028", "y"=> $age60),
  array("label"=> "2029", "y"=> $age59),
    array("label"=> "Glissement > à 65 ans", "y"=> $ageSup65 )
);
*/	
$dataPointsHommes = array();
$dataPointsFemmes = array();
$currentYear = date('Y');
for ($i = 0; $i < 5; $i++) {
    $year = $currentYear + $i;
    $ageVar = 65 - $i;
    $dataPointsHommes[] = array("label" => "$year", "y" => getPlanningRetraiteParSexe($db, $ageVar, '=', 'M', $selectedSiege));
    $dataPointsFemmes[] = array("label" => "$year", "y" => getPlanningRetraiteParSexe($db, $ageVar, '=', 'F', $selectedSiege));
}
$dataPointsHommes[] = array("label" => "Glissement > à 65 ans", "y" => getPlanningRetraiteParSexe($db, '66', '>=', 'M', $selectedSiege));
$dataPointsFemmes[] = array("label" => "Glissement > à 65 ans", "y" => getPlanningRetraiteParSexe($db, '66', '>=', 'F', $selectedSiege));

$totalHommes = array_sum(array_column($dataPointsHommes, 'y'));
$totalFemmes = array_sum(array_column($dataPointsFemmes, 'y'));
$totalGeneral = $totalHommes + $totalFemmes;
?>

<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: "PLANNING DE SORTIE DES RETRAITES 1-5ans"
	},
	subtitles: [{
		text: "Hommes: <?php echo $totalHommes; ?> | Femmes: <?php echo $totalFemmes; ?> | Total: <?php echo $totalGeneral; ?>"
	}],
	axisY: {
		title: "Nombres"
	},
	toolTip: {
		shared: true
	},
	data: [
		{
			type: "stackedColumn",
			name: "Hommes",
			showInLegend: true,
			indexLabel: "{y}",
			indexLabelFontColor: "#333",
			dataPoints: <?php echo json_encode($dataPointsHommes, JSON_NUMERIC_CHECK); ?>
		},
		{
			type: "stackedColumn",
			name: "Femmes",
			showInLegend: true,
			indexLabel: "{y}",
			indexLabelFontColor: "#333",
			dataPoints: <?php echo json_encode($dataPointsFemmes, JSON_NUMERIC_CHECK); ?>
		}
	]
});
chart.render();
 
}
</script>

<div class="form-panel" style="margin-bottom: 15px;">
    <form method="GET" action="accueil.php" class="form-horizontal style-form">
        <input type="hidden" name="page" value="Graphic_PlanningRetraite">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Siege</label>
                    <div class="col-sm-9">
                        <select class="form-control chzn-select" name="siege">
                            <option value="">Tous les sieges</option>
                            <?php foreach ($sieges as $siegeItem) { ?>
                                <option value="<?php echo h($siegeItem['code_sieg']); ?>" <?php echo (string) $selectedSiege === (string) $siegeItem['code_sieg'] ? 'selected' : ''; ?>>
                                    <?php echo h($siegeItem['code_sieg'] . ' | ' . $siegeItem['libelle_sieg']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-round btn-primary" type="submit" style="margin-right:8px;"><i class="fa fa-search"></i> Filtrer</button>
                <a class="btn btn-round btn-default" href="accueil.php?page=Graphic_PlanningRetraite"><i class="fa fa-undo"></i> Reinitialiser</a>
            </div>
        </div>
    </form>
    <?php if ($selectedSiege !== '') { ?>
        <div class="alert alert-info" style="margin-top: 10px; margin-bottom: 0;">
            <strong>Filtre applique :</strong> Siege <?php echo h($selectedSiegeLabel !== '' ? $selectedSiegeLabel : $selectedSiege); ?>
        </div>
    <?php } ?>
</div>

<div>
    <div class="form-panel">
        <div class="row">
            <div class="col-md-12">
                <div id="chartContainer" style="height: 400px; width: 100%;"></div>
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
            <a href="<?php echo h($printPlanRetraiteUrl); ?>" target="_blank" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Imprimer La Liste</a>
            <!-- <a href="print_plan_retraite.php" donwload="donwload" class="btn btn-round btn-primary col-sm-2"style="margin-bottom:25px;margin-left:15px;width:70px;"><i class="fa fa-download" style="margin-right: 7px;"></i>PDF</a>-->

              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>Matricule</th>
                    <th>Noms</th>
                    <th>Sexe </th>
                    <th class="hidden-phone">Date Naissance</th>
                    <th class="hidden-phone">Age</th>
                    <th>Année Restant</th>
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
                    <?php
                         $sqlPlanningRetraite = "SELECT t_agent.matricule,t_agent.nom_ag,t_agent.postnom_ag,t_agent.prenom_ag,t_agent.sexe_ag,t_agent.dateNaiss_ag, 
                         YEAR(CURDATE()) - YEAR(dateNaiss_ag) AS DiffDate FROM bdd_paie.t_agent 
                         WHERE YEAR(CURDATE()) - YEAR(dateNaiss_ag) > 59 
                         AND bdd_paie.t_agent.activiter_ID = '01'";

                         if ($selectedSiege !== '') {
                             $sqlPlanningRetraite .= " AND EXISTS (
                                 SELECT 1
                                 FROM bdd_paie.detail_agent_siege
                                 WHERE detail_agent_siege.agent_ID = t_agent.matricule
                                 AND detail_agent_siege.siege_ID = :siege
                                 AND detail_agent_siege.statut_ID = 'act'
                             )";
                         }

                         $reqPlanningRetraite = $db->prepare($sqlPlanningRetraite);
                         if ($selectedSiege !== '') {
                             $reqPlanningRetraite->bindValue(':siege', $selectedSiege);
                         }
                         $reqPlanningRetraite ->execute();
                         $hasPlanningRetraite = false;
                        while($resPlanningRetraite=$reqPlanningRetraite->fetch()){
                            $hasPlanningRetraite = true;
                            $matric = $resPlanningRetraite['matricule'];
                            $noms = $resPlanningRetraite['nom_ag'].' '.$resPlanningRetraite['postnom_ag'].' '.$resPlanningRetraite['prenom_ag'];
                            $sexe = $resPlanningRetraite['sexe_ag'];
                            $dateNaiss = $resPlanningRetraite['dateNaiss_ag'];
                            $dateNaissFr = date_fr($dateNaiss);
                            $age = $resPlanningRetraite['DiffDate'];
                    ?>
                  <tr class="gradeC_">
                    <td> <?php echo $matric;?> </td>
                    <td> <?php echo $noms;?></td>
                    <td> <?php echo $sexe;?> </td>
                    <td> <?php echo $dateNaissFr;?></td>
                    <td> <?php echo $age;?></td>
                   
                    <td class="hidden-phone"> <?php echo 65-$age;?></td>
                  </tr>
                  <?php } ?>
                  <?php if (!$hasPlanningRetraite) { ?>
                  <tr>
                    <td colspan="6" class="text-center">Aucun agent trouve pour ce siege.</td>
                  </tr>
                  <?php } ?>
                  
                </tbody>
              </table>
            </div>
          </div>
          <!-- page end-->
        </div>


<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
