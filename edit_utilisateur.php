?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
});
</script>
<h3><i class="fa fa-angle-right"></i> Modifier utilisateur</h3>
            $dateCreation ="" ;
            $dateModif = "";
    if(isset($_GET['id'])){
        $id_user = $_GET['id'];
        $req = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
        $req->bindvalue(':id_user',$id_user);
        $req->execute();

        while ($reqResultat = $req->fetch()) {
            $nomComplet = $reqResultat['nom_ag'].' '.$reqResultat['postnom_ag'].' '.$reqResultat['prenom_ag'];
            $username = $reqResultat['username'];
            $matricule = $reqResultat['agent_ID'];
            $id_user = $reqResultat['id_user'];
            $creerPar = $reqResultat['creerPar'];
            $modifierPar = $reqResultat['modifierPar'];
            $libelle_statut = $reqResultat['libelle_st'];
            $code_statut = $reqResultat['code_st'];
            $code_role = $reqResultat['id_role'];
            $libelle_role = $reqResultat['libelle_role'];
            $dateCreation = $reqResultat['dateCreation'];
            $dateModif = $reqResultat['dateLast_Modifi'];
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
<h3><i class="fa fa-angle-right"></i> Modification Des Utilisateurs</h3>
<!-- BASIC FORM ELELEMNTS -->
<br>
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
            <form class="form-horizontal style-form" method="POST" action="update_utilisateur.php">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                                <input type="hidden" name="id_user" value="<?php echo $id_user;?>">
                                <select class="form-control chzn-select" name="matriAg" required>
                                    <option value="<?php echo $matricule;?>"> <?php echo $matricule;?> </option>
                                    <?php
                                        $reqGetMatriculeAg = $db->prepare('SELECT matricule FROM bdd_paie.t_agent');
                                        $reqGetMatriculeAg->execute();
                                        while($resGetMatriculeAg = $reqGetMatriculeAg->fetch()){
                                            $matricules = $resGetMatriculeAg['matricule']; ?>
                                    <option value="<?php echo $matricules;?>"> <?php echo $matricules;?> </option>
                                    <?php } ?>
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Compte</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="nomUtilisateur" value="<?php echo $username;?>"  required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Création</label>
                            <div class="col-md-8">
                                <div class="input-group date form_datetime-component">
                                    <input type="text" class="form-control" value="<?php echo($dateCreation);?>" readonly size="16" name="dateCreation">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-theme date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">CréerPar</label>
                            <div class="col-sm-8">
                            <?php 
                                if($creerPar == "sysAdmin"){
                                ?>
                                <input type="text" value="<?php echo $creerPar;?>" class="form-control" readonly>
                                <?php 
                                }else{
                                $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                                WHERE id_user = :creerPar');
                                $reqGetInfoUser->bindValue(':creerPar',$creerPar);
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Rôle Utilisateur</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="roleAg">
                                    <option value="<?php echo $code_role;?>"> <?php echo $libelle_role;?> </option>
                                    <?php
                                        $reqGetMatriculeAg = $db->prepare('SELECT * FROM bdd_paie.t_role_user');
                                        $reqGetMatriculeAg->execute();
                                        while($resGetMatriculeAg = $reqGetMatriculeAg->fetch()){
                                            $id_role = $resGetMatriculeAg['id_role']; 
                                            $libelle_role = $resGetMatriculeAg['libelle_role']; ?>
                                    <option value="<?php echo $id_role?>"> <?php echo $libelle_role;?> </option>
                                    <?php } ?>  
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Modifier" name="modifierUser" style="margin:15px;width:150px;">
                            <a href="accueil.php?page=Voir_Utilisateur" class="btn btn-round btn-warning col-sm-2" style="margin:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>

                        </div>
                        
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nom Complet</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $nomComplet;?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Statut</label>
                            <div class="col-sm-8">
                                
                                <select class="form-control" name="statut">
                                    <option value="<?php echo ($code_statut == "act") ?"act":"desac";?>"> <?php echo ($code_statut=="act")?"Activer":"Désactiver";?></option>
                                    <option value="<?php echo ($code_statut != "act") ?"act":"desac";?>"> <?php echo ($code_statut=="act")?"Désactiver":"Activer";?></option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Modification</label>
                            <div class="col-md-8">
                                <div class="input-group date form_datetime-component">
                                    <input type="date" class="form-control" value="<?php echo $dateModif?>" readonly="" size="16" name="dateModif">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-theme date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">ModifierPar</label>
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
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><strong>Réinitialisation Mot de Passe</strong></label>
                            <div class="col-sm-2 text-center" style="margin: 10px;">
                                <input type="checkbox" name="reinit" value="act" data-toggle="switch" >
                            </div>  
                        </div>
                        
                    </div>
                  
                </div>
            </form>
            <?php include_once('confirm_modify_modal.php'); ?>
        </div>
        <br><br>
    </div>
</div>
          
            