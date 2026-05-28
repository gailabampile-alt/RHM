?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
    document.addEventListener('click', function(ev){ if(ev.target && ev.target.id === 'confirmModifyBtn'){ $('#confirmModifyModal').modal('hide'); form.submit(); } });
});
</script>
<h3><i class="fa fa-angle-right"></i> Modifier Taux</h3>
    $req = $db->prepare("SELECT * FROM bdd_paie.t_taux WHERE id_taux =:id_taux");
    $req->bindvalue(':id_taux',$code_taux_orig);
    $req->execute();
    while($resCarburant=$req->fetch()){
        $id_taux = $resCarburant['id_taux'];
        $dateTaux = $resCarburant['dateTaux'];
        $montantTaux = $resCarburant['montantTaux'];
        $monnaie = $resCarburant['monnaie_ID'];
        $creerPar = $resCarburant['creerPar'];
        $modifierPar = $resCarburant['modifierPar'];
        $statut = $resCarburant['statut_ID']; 
    }

}
?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var forms = document.querySelectorAll('form');
    forms.forEach(function(f){
        f.addEventListener('submit', function(e){
            if(!confirm('Voulez-vous modifier ?')){ e.preventDefault(); return false; }
        });
    });
});
</script>
<h3><i class="fa fa-angle-right"></i> Modification Taux</h3>
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
            <form class="form-horizontal style-form" method="POST" action="update_taux.php">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateTaux" value="<?php echo $dateTaux;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Monnaie</label>
                            <div class="col-sm-8">
                                <select data-placeholder="Selectionnez la devise" class="form-control chzn-select" name="monnaie" required>
                                <option value="<?php echo $monnaie;?>"> <?php echo $monnaie;?> </option> 
                                    <?php
                                        $reqGetMonnaie = $db->prepare('SELECT code_monnaie,	libelle_monnaie FROM bdd_paie.monnaie
                                        ');
                                        $reqGetMonnaie->execute();
                                        while($resGetMonnaie = $reqGetMonnaie->fetch()){
                                            $cod_mon = $resGetMonnaie['code_monnaie']; 
                                            $lib_mon = $resGetMonnaie['libelle_monnaie'];?>
                                        <option value="<?php echo $cod_mon;?>"> <?php echo $cod_mon.' | '.$lib_mon;?> </option>
                                    <?php } ?>   
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Montant Taux </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="taux" value="<?php echo $montantTaux;?>">
                                <input type="hidden" class="form-control" name="id_taux" value="<?php echo $id_taux;?>">
                            </div>
                        </div>
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
                                <input type="text" class="form-control" readonly>
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
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addCarburant"
                            name="updateTaux" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i> Modifier</button>
                        <a href="accueil.php?page=Voir_taux" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
            
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</div>
          
            