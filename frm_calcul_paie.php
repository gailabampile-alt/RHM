
<h3><i class="fa fa-angle-right"></i> Calcul de la Paie</h3>
<!-- BASIC FORM ELELEMNTS -->
<div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
        <?php if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="alert">×</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
            </div>
          <?php } ?>
           <?php
$periode = isset($_POST['periode']) ? $_POST['periode'] : '';
?>
            <h4 class="text-primary">Choix de Critère</h4>
            <form class="form-horizontal style-form" method="POST" action="add_calcul_paie.php">
        


                <div class="row">
                <div class="col-lg-4 col-md-4 col-xl-4">
                <div class="form-group">
                            <label class="control-label col-md-3"><strong>Période</strong></label>
                        <div class="col-md-7">
                            <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="<?php echo date('m/y')?>" class="input-append date dpMonths">
                                <input type="text" name="periode" size="16" class="form-control">
                                <span class="input-group-btn add-on">
                                <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xl-4">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-7">
                                <input type="date" class="form-control" name="date_paie">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xl-4">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type Paie</label>
                            <div class="col-sm-7">
                                <select class="form-control" name ="type_paie">
                                    <option value="N">N -Normal</option>
                                    <option value="G">G -Gratification</option>
                                    <option value="R">R -Rentré Scolaire</option>
                                      <option value="V">V -Rente Viagere</option>
                                </select>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="row centered">
                    <div class="col-lg-4 col-md-4 col-xl-2">
                      
                        <input type="submit" id ="btnCalcul" class="btn btn-round btn-primary col-sm-4" value="Calculer" name="calcule">
                        
                    <!--    <a href="suprimer_paie.php" name ="Annule" class="btn btn-round btn-danger col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"><i class="fa fa-eraser" style="margin-right: 7px;"></i>Annuler Paie</a>-->
                       <button type ="button" class="btn btn-round btn-danger col-sm-2" style="margin-bottom:25px;margin-left:15px;width:170px;"> <i class="fa fa-eraser" data-toggle="modal" data-target="#myModal" >Annuler Paie</i></button>
                    </div>
                    <!-- Message qui s’affiche pendant le calcul -->
  <div id="messageCalcul" style="display:none; color:blue; font-weight:bold;">
        ⏳ Patientez, calcul en cours...
    </div>
</form>
 <!--
<script>
document.getElementById("btnCalcul").addEventListener("click", function() {
    // Afficher le message
    document.getElementById("messageCalcul").style.display = "block";

    // Changer le texte du bouton immédiatement
    this.value = "Calcul en cours...";

    // Désactiver le bouton après un petit délai (pour laisser le submit partir)
    setTimeout(() => {
        this.disabled = true;
    }, 100);
});
</script>
              Modal -->
              
          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Confirmation d'Annulation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>

      <form action="annuler_paie.php" method="POST"> <!-- ✅ formulaire ici -->
        <div class="modal-body">
          Voulez-vous vraiment annuler la paie pour la période <b id="periodeAffiche"></b> ?
          <input type="hidden" name="periode" id="periodeHidden" > <!-- ✅ valeur envoyée -->
          <input type="hidden" name="type_paie" id="typePaieHidden" > <!-- ✅ type de paie envoyé -->
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Oui, annuler</button>
        </div>
      </form>

    </div>
  </div>
</div> 
               </div>
            
        </div>
        <br><br><br><br><br><br><br><br><br><br><br>
    </div>
</div>
       <script>
document.addEventListener("DOMContentLoaded", function() {
    // quand le modal s'ouvre
    $('#myModal').on('show.bs.modal', function () {
        let periode = document.querySelector('input[name="periode"]').value;
        let typePaie = document.querySelector('select[name="type_paie"]').value;
        document.getElementById('periodeAffiche').textContent = periode;
        document.getElementById('periodeHidden').value = periode;
        document.getElementById('typePaieHidden').value = typePaie;
    });
});
</script>

