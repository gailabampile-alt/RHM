<?php
    include('sys_connexion.php');
    include('sys_fonction.php');

    $selectedActiv = isset($_GET['activ']) ? $_GET['activ'] : '';
    $selectedSiege = isset($_GET['siege']) ? $_GET['siege'] : '';
    $selectedDateDebut = isset($_GET['dateDebut']) ? $_GET['dateDebut'] : '';
    $selectedDateFin = isset($_GET['dateFin']) ? $_GET['dateFin'] : '';

    $actif = getEtat_activiter_agent($db,'01');
    $retraite = getEtat_activiter_agent($db,'02');
    $suspendu = getEtat_activiter_agent($db,'03');
    $detachement = getEtat_activiter_agent($db,'08');
    $finContrat = getEtat_activiter_agent($db,'09');
    $revocation = getEtat_activiter_agent($db,'05');
    $demission = getEtat_activiter_agent($db,'06');
    $licen = getEtat_activiter_agent($db,'07');
    $deced = getEtat_activiter_agent($db,'04');

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
    );//à¸¿

?>
<script>
    window.onload = function () {
     
    var chart = new CanvasJS.Chart("chartContainer", {
      animationEnabled: true,
      exportEnabled: true,
      title:{
        text: "ACTIVITE DES AGENTS"
      },
      subtitles: [{
        text: "Valeur Exacte: Symboliser Par (=)"
      }],
      data: [{
        type: "pie",
        showInLegend: "true",
        legendText: "{label}",
        indexLabelFontSize: 16,
        indexLabel: "{label} - #percent%",
        yValueFormatString: "=#,##0",
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
          <?php 
          // Afficher les filtres appliquÃ©s
          if ($selectedActiv || $selectedSiege || $selectedDateDebut || $selectedDateFin) {
              echo '<div class="alert alert-info">';
              echo '<strong>Filtres appliqués:</strong> ';
              $filtres = array();
              if ($selectedActiv) {
                  $reqActiv = $db->prepare('SELECT libelle_activ FROM bdd_paie.t_activite WHERE code_activ = :code');
                  $reqActiv->bindValue(':code', $selectedActiv);
                  $reqActiv->execute();
                  $resActiv = $reqActiv->fetch();
                  $filtres[] = 'Statut: ' . $resActiv['libelle_activ'];
              }
              if ($selectedSiege) {
                  $reqSiege = $db->prepare('SELECT libelle_sieg FROM bdd_paie.t_siege WHERE code_sieg = :code');
                  $reqSiege->bindValue(':code', $selectedSiege);
                  $reqSiege->execute();
                  $resSiege = $reqSiege->fetch();
                  $filtres[] = 'Siège: ' . $resSiege['libelle_sieg'];
              }
              if ($selectedDateDebut && $selectedDateFin) {
                  $filtres[] = 'Période: ' . date('d-m-Y', strtotime($selectedDateDebut)) . ' Ã  ' . date('d-m-Y', strtotime($selectedDateFin));
              } elseif ($selectedDateDebut) {
                  $filtres[] = 'à partir du: ' . date('d-m-Y', strtotime($selectedDateDebut));
              } elseif ($selectedDateFin) {
                  $filtres[] = 'Jusqu\'au: ' . date('d-m-Y', strtotime($selectedDateFin));
              }
              echo implode(' | ', $filtres);
              echo '</div>';
          }
          ?>
          <?php /*if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="alert">Ã—</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
            </div>
          <?php } */?>
            <div class="adv-table" style="margin: 5px;">
              <!--a href="accueil.php?page=Fonction" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i> Ajouter </a>
              <a href="print_agent_actif.php" target="_blank" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Actif</a>
              <a href="print_agent_retraite.php" target="_blank" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>RetraitÃ©</a>
              <a href="print_all_agent_statut.php" target="_blank" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-print"></i> Print All</a-->
              <!--a href="print_agent_autres.php" target="_blank" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-print" style="margin-right: 7px;"></i>Autres</a-->
          </div>
          <!-- page end-->
           
        </div>
      </div>

      <div class="form-panel">

        <div id="zoneDerecherche">
          
    <form class="form-horizontal style-form" id="formPrint">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-xl-8">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Statut</label>
                                <div class="col-sm-8">
                                    <select class="form-control chzn-select" id="activSelect" name="activ" onchange="loadTableData()">
                                        <option value=""> Choisir l'Activiter </option>
                                        <?php
                                            $reqGetActiviter = $db->prepare('SELECT code_activ,libelle_activ FROM bdd_paie.t_activite');
                                            $reqGetActiviter->execute();
                                            while($resGetActiviter = $reqGetActiviter->fetch()){
                                                $cod_activ = $resGetActiviter['code_activ']; 
                                                $lib_activ = $resGetActiviter['libelle_activ'];
                                                $selected = ($cod_activ === $selectedActiv) ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo $cod_activ;?>" <?php echo $selected;?>> <?php echo validation_donnees($lib_activ);?> </option>
                                        <?php } ?>  
                                    </select>
                                 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Siège</label>
                                <div class="col-sm-8">
                                  <select class="form-control chzn-select" id="siegeSelect" name="siege" onchange="loadTableData()">
                                      <option value=""> Choisir du Siège </option>
                                      <?php
                                          $reqGetSiege = $db->prepare('SELECT code_sieg,libelle_sieg FROM bdd_paie.t_siege');
                                          $reqGetSiege->execute();
                                          while($resGetSiege = $reqGetSiege->fetch()){
                                              $cod_sieg = trim($resGetSiege['code_sieg']);
                                              $lib_sieg = $resGetSiege['libelle_sieg'];
                                              $selected = ($cod_sieg === $selectedSiege) ? 'selected' : '';
                                      ?>
                                          <option value="<?php echo $cod_sieg?>" <?php echo $selected;?>> <?php echo $cod_sieg.' | '.$lib_sieg;?> </option>
                                      <?php } ?>
                                  </select>         
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Date Début</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="dateDebut" name="dateDebut" value="<?php echo $selectedDateDebut; ?>" onchange="loadTableData()">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Date Fin</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="dateFin" name="dateFin" value="<?php echo $selectedDateFin; ?>" onchange="loadTableData()">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xl-3">
                            <div class="form-group">
                                  
                                
                          <button type="button" 
                              class="btn btn-round btn-primary col-sm-3"
                                id="addAgent" 
                                style="margin-left:15px;width:150px;">
                                <i class="fa fa-print"></i> Imprimer
                          </button>
                          

                            </div>
                            <div class="form-group">
                                  
                                <button type="button" 
                                    class="btn btn-round btn-secondary col-sm-3"
                                    id="resetFilters" 
                                    style="margin-left:15px;width:150px;">
                                    <i class="fa fa-undo"></i> Réinitialiser
                                    
                                </button>
                        </div>
                        
                        <div class="col-lg-3 col-md-3 col-xl-3">
                            <div class="form-group">
                                
                            </div>
                        </div>
                        
                    </div>

                </form>  

<script>
let graphDataTable = null;

function escapeHtml(value) {
    const safeValue = (value === undefined || value === null) ? '' : value;
    return String(safeValue).replace(/[&<>"']/g, function (char) {
        return {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[char];
    });
}

function resetGraphDataTable() {
    try {
        if (graphDataTable && typeof graphDataTable.fnDestroy === 'function') {
            graphDataTable.fnDestroy();
            graphDataTable = null;
            return;
        }

        if (window.jQuery && $.fn.dataTable && $.fn.dataTable.fnIsDataTable) {
            const table = document.getElementById('graph-activite-table');
            if (table && $.fn.dataTable.fnIsDataTable(table)) {
                $('#graph-activite-table').dataTable().fnDestroy();
            }
        }
    } catch (e) {
        console.warn('DataTable reset ignore:', e);
    } finally {
        graphDataTable = null;
    }
}

function initGraphDataTable() {
    if (!window.jQuery || !$.fn || !$.fn.dataTable) return;

    try {
        graphDataTable = $('#graph-activite-table').dataTable({
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [9]
            }],
            "aaSorting": [
                [0, 'asc']
            ]
        });
    } catch (e) {
        console.warn('DataTable init ignore:', e);
        graphDataTable = null;
    }
}

function buildRowHtml(row) {
    const matricule = row.matric || '';
    const matriculeUrl = encodeURIComponent(matricule);

    return `
        <tr>
            <td>${escapeHtml(matricule)}</td>
            <td>${escapeHtml(row.noms || '')}</td>
            <td class="hidden-phone">${escapeHtml(row.compte || '')}</td>
            <td class="center hidden-phone">${escapeHtml(row.siege || '')}</td>
            <td class="center hidden-phone">${escapeHtml(row.direction || '')}</td>
            <td>${escapeHtml(row.fonction || '')}</td>
            <td>${escapeHtml(row.grade || '')}</td>
            <td>${escapeHtml(row.cnss || '')}</td>
            <td>${escapeHtml(row.activiter || '')}</td>
            <td class="hidden-phone">
                <div class="btn-group">
                    <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="accueil.php?page=Edit_Agent&matric=${matriculeUrl}" style="margin-right: 2px;color:blue;"><i class="fa fa-edit"></i>Modifier</a></li>
                        <li class="divider"></li>
                        <li><a href="print_profil_agent.php?matric=${matriculeUrl}" style="margin-right: 2px;color:green;" target="_blank"><i class="fa fa-print"></i>Imprimer</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    `;
}

function renderTableRows(data) {
    const tbody = document.getElementById('graph-table-body');
    if (!tbody) return;

    const rows = data.rows || [];
    resetGraphDataTable();

    if (!rows || rows.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" class="text-center">Aucun agent trouvé pour cette sélection.</td></tr>';
        return;
    }

    tbody.innerHTML = rows.map(row => buildRowHtml(row)).join('');
    initGraphDataTable();
}

function loadTableData() {
    const activSelect = document.getElementById('activSelect');
    const siegeSelect = document.getElementById('siegeSelect');
    const dateDebutInput = document.getElementById('dateDebut');
    const dateFinInput = document.getElementById('dateFin');
    const activ = activSelect ? activSelect.value : '';
    const siege = siegeSelect ? siegeSelect.value : '';
    const dateDebut = dateDebutInput ? dateDebutInput.value : '';
    const dateFin = dateFinInput ? dateFinInput.value : '';
    const tbody = document.getElementById('graph-table-body');
    
    if (tbody) {
        resetGraphDataTable();
        tbody.innerHTML = '<tr><td colspan="10" class="text-center">Chargement en cours...</td></tr>';
    }

    const params = new URLSearchParams();
    if (activ) params.set('activ', activ);
    if (siege) params.set('siege', siege);
    if (dateDebut) params.set('dateDebut', dateDebut);
    if (dateFin) params.set('dateFin', dateFin);

    const url = 'ajax_graph_activite_agent.php?' + params.toString();

    fetch(url, { cache: 'no-store' })
        .then(async response => {
            const text = await response.text();
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ' - ' + text.substring(0, 180));
            }
            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error('Reponse JSON invalide: ' + text.substring(0, 180));
            }
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            renderTableRows(data);
        })
        .catch(error => {
            console.error('Erreur:', error);
            if (tbody) {
                resetGraphDataTable();
                tbody.innerHTML = '<tr><td colspan="10" class="text-center text-danger">Erreur: ' + escapeHtml(error.message) + '</td></tr>';
            }
        });
}

// Initialisation au chargement de la page
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        initializeEvents();
        loadTableData();
    });
} else {
    initializeEvents();
    loadTableData();
}

function initializeEvents() {
    if (window.graphActiviteEventsReady) return;
    window.graphActiviteEventsReady = true;

    const activSelect = document.getElementById('activSelect');
    const siegeSelect = document.getElementById('siegeSelect');
    const dateDebut = document.getElementById('dateDebut');
    const dateFin = document.getElementById('dateFin');
    const addAgentButton = document.getElementById('addAgent');
    const resetFiltersButton = document.getElementById('resetFilters');

    if (activSelect) {
        activSelect.addEventListener('change', loadTableData);
    }
    if (siegeSelect) {
        siegeSelect.addEventListener('change', loadTableData);
    }
    if (dateDebut) {
        dateDebut.addEventListener('change', loadTableData);
    }
    if (dateFin) {
        dateFin.addEventListener('change', loadTableData);
    }
    
    if (addAgentButton) {
        addAgentButton.addEventListener('click', function () {
            const activ = activSelect ? activSelect.value : '';
            const siege = siegeSelect ? siegeSelect.value : '';
            const dateDebutValue = dateDebut ? dateDebut.value : '';
            const dateFinValue = dateFin ? dateFin.value : '';

            if (!activ && !siege && !dateDebutValue && !dateFinValue) {
                alert('Sélectionnez au moins un filtre avant d\'imprimer.');
                return;
            }

            const params = new URLSearchParams();
            if (activ) params.set('activ', activ);
            if (siege) params.set('siege', siege);
            if (dateDebutValue) params.set('dateDebut', dateDebutValue);
            if (dateFinValue) params.set('dateFin', dateFinValue);

            window.open('traiemnt_print_activite.php?' + params.toString(), '_blank');
        });
    }
    
    if (resetFiltersButton) {
        resetFiltersButton.addEventListener('click', function () {
            if (activSelect) activSelect.value = '';
            if (siegeSelect) siegeSelect.value = '';
            if (dateDebut) dateDebut.value = '';
            if (dateFin) dateFin.value = '';
            if (window.jQuery) {
                $('#activSelect, #siegeSelect').trigger('chosen:updated');
            }
            loadTableData();
        });
    }

    if (window.jQuery) {
        $('#activSelect, #siegeSelect, #dateDebut, #dateFin')
            .off('change.graphActivite')
            .on('change.graphActivite', loadTableData);
    }
}
</script>

              </div>

<table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="graph-activite-table">
  
                <thead>
                  <tr>
                    <th>Matricule</th>
                    <th>Nom Complet</th>
                    <th>Compte</th>
                    <th class="hidden-phone">Siège</th>
                    <th class="hidden-phone">Direction</th>
                    <th class="hidden-phone">Fonction</th>
                    <th>Grade</th>
                    <th>CNSS</th>
                    <th>Activité</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody id="graph-table-body">
                  <tr>
                    <td colspan="10" class="text-center">Chargement des données...</td>
                  </tr>
                </tbody>
              </table>
            </div>
      </div>
        



<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    

