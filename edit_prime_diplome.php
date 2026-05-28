<?php
    //session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    $primeTrouvee = false;

    if(isset($_GET['code'])){
        $code_enf = $_GET['code'];
        $reqInfoEnfant = $db->prepare("SELECT detail_nivetude_montant.id_det_nivetud_mont,
        detail_nivetude_montant.niv_etude_ID,detail_nivetude_montant.codepaie,
        detail_nivetude_montant.montant,detail_nivetude_montant.monnaie_ID,
        detail_nivetude_montant.statut_ID,detail_nivetude_montant.dateDebut,
        detail_nivetude_montant.dateFin,detail_nivetude_montant.creerPar,
        detail_nivetude_montant.modifierPar,t_codepaie.libelle_codePaie,t_niv_etud.libelle_niv_etud
            FROM bdd_paie.detail_nivetude_montant
            INNER JOIN bdd_paie.t_codepaie ON t_codepaie.codePaie = detail_nivetude_montant.codepaie
            INNER JOIN bdd_paie.t_niv_etud ON t_niv_etud.id_niv_etud = detail_nivetude_montant.niv_etude_ID
            WHERE id_det_nivetud_mont = :id_det_nivetud_mont");
        $reqInfoEnfant->bindvalue(':id_det_nivetud_mont',$code_enf);
        $reqInfoEnfant->execute();

        while($resInfoEnfant=$reqInfoEnfant->fetch()){
            $primeTrouvee = true;
            $id_niv = $resInfoEnfant['id_det_nivetud_mont'];
            $niv_etude_ID = $resInfoEnfant['niv_etude_ID'];
            $libelle_niv_etud = $resInfoEnfant['libelle_niv_etud'];
            $codepaie = $resInfoEnfant['codepaie'];
            
            $montant = $resInfoEnfant['montant'];
            $monnaie_ID = $resInfoEnfant['monnaie_ID'];
            $statut = $resInfoEnfant['statut_ID'];
            $dateDebut = $resInfoEnfant['dateDebut'];
            $dateFin = $resInfoEnfant['dateFin']; 
            $creerPar = $resInfoEnfant['creerPar'];
            //$date_creat = $resInfoEnfant['dateCreate'];
            $modifierPar = $resInfoEnfant['modifierPar'];
            
        }

        if($primeTrouvee && $statut != "act"){
            $_SESSION['message']  = "Cette prime est désactivée, pas moyen de modifier.";
            $_SESSION['typeMsg']  = "warning";
            echo '<script>window.location.href="accueil.php?page=Voir_PrimeDiplome";</script>';
            return;
        }

    }
?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
});
</script>
<h3><i class="fa fa-angle-right"></i> Prime Diplôme</h3>
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
            <form class="form-horizontal style-form" method="POST" action="update_prime_diplome.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Niveau Etude</label>
                            <input type="hidden" value="<?php echo $id_niv;?>" name="id_niv">
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="nivEtude" required>
                                    <option value="<?php echo $niv_etude_ID;?>"> <?php echo $niv_etude_ID.' | '.$libelle_niv_etud;?> </option> </option>
                                        <?php
                                            $reqGetNivEtude = $db->prepare('SELECT id_niv_etud,libelle_niv_etud FROM bdd_paie.t_niv_etud');
                                            $reqGetNivEtude->execute();
                                                while($resGetNivEtude = $reqGetNivEtude->fetch()){
                                                    $id = $resGetNivEtude['id_niv_etud']; 
                                                    $lib = $resGetNivEtude['libelle_niv_etud'];?>
                                                <option value="<?php echo $id;?>"> <?php echo $id.' | '.$lib;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dévise</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" data-placeholder="Selectionnez une dévise"name="devise" required>
                                    <option value="<?php echo $monnaie_ID;?>"> <?php echo $monnaie_ID;?> </option>
                                        <?php
                                            $reqGetDevise = $db->prepare('SELECT code_monnaie,libelle_monnaie FROM bdd_paie.monnaie');
                                            $reqGetDevise->execute();
                                                while($resGetDevise = $reqGetDevise->fetch()){
                                                    $code = $resGetDevise['code_monnaie']; 
                                                    $lib = $resGetDevise['libelle_monnaie'];?>
                                                <option value="<?php echo $code;?>"> <?php echo $code.' | '.$lib;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Montant Actuel</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="montantActuel" value="<?php echo $montant;?>" readonly style="background-color: #e9ecef;">
                                <small class="form-text text-muted">Le montant ne peut que augmenter ou rester identique</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nouveau Montant</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="montantNouveau" name="montant" value="<?php echo $montant;?>" required>
                                <small class="form-text text-danger" id="montantError" style="display:none;">Le nouveau montant ne peut pas être inférieur au montant actuel!</small>
                            </div>
                        </div>

                        

                    
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                                <?php /*
                                    $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                                    $reqGetNomUtilisateur->bindvalue(':id_user',$_SESSION['id_utilisateur']);
                                    $reqGetNomUtilisateur->execute();
                                    while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                                        $nomComplet = $resGetNomUtilisateur['nom_ag'].' '.$resGetNomUtilisateur['postnom_ag'].' '.$resGetNomUtilisateur['prenom_ag'];
                                    }
                                ?>
                                <input type="text" class="form-control" name="creerPar" value="<?php echo $nomComplet; */?>" readonly>
                            </div>
                        </div-->
                        
                        
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                                <?php
                                    $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                                    $reqGetNomUtilisateur->bindvalue(':id_user',$_SESSION['id_utilisateur']);
                                    $reqGetNomUtilisateur->execute();
                                    while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                                        $nomComplet = $resGetNomUtilisateur['nom_ag'].' '.$resGetNomUtilisateur['postnom_ag'].' '.$resGetNomUtilisateur['prenom_ag'];
                                    }
                                ?>
                                <input type="text" class="form-control" name="creerPar" value="<?php echo $nomComplet; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Le</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo $dateDebut;?>" name="" readonly>
                            </div>
                        </div>

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
                            <label class="col-sm-3 control-label">Modifier Le</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php //echo $dateFin;?>" readonly>
                            </div>
                        </div-->
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
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
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
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addAgent"
                            name="updatePrime_dip" style="margin-left:15px;width:150px;"><i class="fa fa-plus-circle"></i> Modifier</button>
                            <a href="accueil.php?page=Voir_PrimeDiplome" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
            
        </div>
        <br><br><br>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const montantActuelInput = document.getElementById('montantActuel');
    const montantNouveauInput = document.getElementById('montantNouveau');
    const montantErrorMsg = document.getElementById('montantError');
    const formulaire = document.querySelector('form');
    const btnSubmit = document.getElementById('addAgent');

    // Validation en temps réel
    if (montantNouveauInput) {
        montantNouveauInput.addEventListener('input', function() {
            const montantActuel = parseFloat(montantActuelInput.value) || 0;
            const montantNouveau = parseFloat(this.value) || 0;

            if (montantNouveau < montantActuel) {
                montantErrorMsg.style.display = 'block';
                this.classList.add('is-invalid');
                this.style.borderColor = 'red';
                btnSubmit.disabled = true;
            } else {
                montantErrorMsg.style.display = 'none';
                this.classList.remove('is-invalid');
                this.style.borderColor = '';
                btnSubmit.disabled = false;
            }
        });
    }

    // Validation à la soumission du formulaire
    if (formulaire) {
        formulaire.addEventListener('submit', function(e) {
            const montantActuel = parseFloat(montantActuelInput.value) || 0;
            const montantNouveau = parseFloat(montantNouveauInput.value) || 0;

            if (montantNouveau < montantActuel) {
                e.preventDefault();
                alert('Le montant ne peut pas être diminué!\n\nMontant actuel: ' + montantActuel);
                montantErrorMsg.style.display = 'block';
                montantNouveauInput.focus();
                return false;
            }
        });
    }
});
</script>
          
            
