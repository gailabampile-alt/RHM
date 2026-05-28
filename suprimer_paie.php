<?php

//session_start();

include_once('sys_connexion.php');
include_once('sys_fonction.php');

$periode = ""; // initialisation pour éviter "undefined"

if (isset($_POST['periode'])) {
    $periode = $_POST['periode']; // récupération de la valeur envoyée par le formulaire
}

if (isset($_POST['valider'])) {
    if (empty($periode)) {
        $_SESSION['typeMsg'] = "danger";
        $_SESSION['Msg'] = "Selectionner la Période svp!";
        header("location:accueil_pai.php?page=Calcul-Paie");
        exit();
    }
}
?>
<!--<div class="modal fade" id="supprimer<?php echo htmlspecialchars($periode); ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Suppression</h5>
      </div>
      <div class="modal-body">
        Êtes-vous sûr de vouloir supprimer <?php echo htmlspecialchars($periode); ?> ?
      </div>
    </div>
  </div>
</div>
 Modal -->
              <div class="modal fade" id="supprimer<?php echo htmlspecialchars($periode); ?>" tabindex="-1" role="dialog" aria-labelledby="suprimer" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="suprimer">Annulation Paie</h4>
                    </div>
                    <div class="modal-body">
                     ⚠️ Êtes-vous sûr de vouloir annuler cette paie ?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>
            
                     <!-- modalel-->