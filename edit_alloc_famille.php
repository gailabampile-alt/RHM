<?php
    include_once('sys_connexion.php');
    $code = '';
    $codepaie = '';
    $lib = '';
    $montant= '';
    $dateCreation = '';
    $dateModif = '';
    $modifierPar = '';
    $creerPar = '';
    if(isset($_GET['code'])){
        $code = $_GET['code'];
        $reqCarburant = $db->prepare('SELECT * FROM bdd_paie.t_alloc_famille
            WHERE id_alloc = :id_alloc');
        $reqCarburant->bindValue(':id_alloc',$code);
        $reqCarburant->execute();
        while($resCarburant=$reqCarburant->fetch()){
            $codepaie = $resCarburant['codepaie'];
            $lib = $resCarburant['libelle_alloc'];
            $montant = $resCarburant['montant_alloc'];
            $dateCreation = $resCarburant['date_creat'];
            $dateModif = $resCarburant['date_modif'];
            $modifierPar = $resCarburant['modifierPar'];
        }
    }
?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
});
</script>
<h3><i class="fa fa-angle-right"></i> Edit Allocation Familial</h3>
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
            <form class="form-horizontal style-form" method="POST" action="update_alloc_famille.php">
                <div class="row centered">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Code Paie</label>
                            <div class="col-sm-8">
                                <input type="hidden" value="<?php echo $code;?>" class="form-control" name="id_alloc" readonly>
                                <input type="text" value="<?php echo $codepaie;?>" class="form-control" name="prix_litr" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Libelle</label>
                            <div class="col-sm-8">
                                <input type="text" value="<?php echo $lib;?>" class="form-control" name="prix_litr" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Montant Actuel</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="montantActuel" value="<?php echo $montant; ?>" readonly style="background-color: #e9ecef;">
                                <small class="form-text text-muted">Le montant ne peut que augmenter ou rester identique.</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nouveau Montant</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="montantNouveau" name="montant_alloc" value="<?php echo $montant; ?>" required>
                                <small class="form-text text-danger" id="montantError" style="display:none;">Le nouveau montant ne peut pas etre inferieur au montant actuel.</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Le</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="val_taux_jr" value="<?php echo $dateCreation; ?>"> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Le</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $dateModif;?>" readonly>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Equipe Compt</label>
                            <div class="col-sm-8">
                                <select name="eqCompt" class="form-control">
                                    <option value="0">Choix Equipe</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                </select>
                            </div>
                        </div-->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <?php 
                                    if($modifierPar == "sysAdmin"){
                                    ?>
                                    <input type="text" value="<?php echo $modifierPar;?>" class="form-control" readonly>
                                    <?php 
                                    }else{
                                    $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                                    WHERE id_user = :modifierPar');
                                    $reqGetInfoUser->bindValue(':modifierPar',$modifierPar);
                                    $reqGetInfoUser->execute();
                                    while ($resGetInfoUser = $reqGetInfoUser->fetch()) {
                                        $nom_postnom = $resGetInfoUser['nom_ag'].' '.$resGetInfoUser['postnom_ag'];
                                        $prenom = ucfirst(strtolower($resGetInfoUser['prenom_ag']));
                                        $nomComplet = $nom_postnom.' '.$prenom;
                                    }?>
                                    <input type="text" value="<?php echo $nomComplet;?>" class="form-control" readonly>
                                <?php } ?>
                            </div>
                        </div>
                    
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div-->
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="update_alloc_familial"
                            name="update_alloc_familial" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i> Modifier</button>
                        <a href="accueil.php?page=Voir_alloc_famille" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
            
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var montantActuelInput = document.getElementById('montantActuel');
    var montantNouveauInput = document.getElementById('montantNouveau');
    var montantErrorMsg = document.getElementById('montantError');
    var formulaire = document.querySelector('form.form-horizontal');
    var btnSubmit = document.getElementById('update_alloc_familial');

    function parseMontant(value) {
        return parseFloat(String(value).replace(/\s/g, '').replace(',', '.')) || 0;
    }

    function verifierMontant() {
        var montantActuel = parseMontant(montantActuelInput.value);
        var montantNouveau = parseMontant(montantNouveauInput.value);
        var montantEnBaisse = montantNouveau < montantActuel;

        montantErrorMsg.style.display = montantEnBaisse ? 'block' : 'none';
        montantNouveauInput.style.borderColor = montantEnBaisse ? 'red' : '';
        btnSubmit.disabled = montantEnBaisse;

        return !montantEnBaisse;
    }

    if (montantNouveauInput) {
        montantNouveauInput.addEventListener('input', verifierMontant);
    }

    if (formulaire) {
        formulaire.addEventListener('submit', function(e) {
            if (!verifierMontant()) {
                e.preventDefault();
                alert('Le montant ne peut pas etre modifie a la baisse.');
                montantNouveauInput.focus();
                return false;
            }
        });
    }
});
</script>
          
            
