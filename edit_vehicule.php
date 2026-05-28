?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
});
</script>
<h3><i class="fa fa-angle-right"></i> Modification Véhicule</h3>
    $numCarteRose = "";
    $immatriculation = "";
    $statut = "";
    $modifierPar = "";
    $dateCreate = "";

    if(isset($_GET['code_vehic'])){
    $id_veh = $_GET['code_vehic'];
    $req = $db->prepare("SELECT 
        t_vehicule.id_veh,t_vehicule.modele,t_vehicule.agent_ID,t_vehicule.numChassis,
        t_vehicule.numPermis,t_vehicule.numCarteRose,t_vehicule.immatriculation,
        t_vehicule.observation,t_vehicule.creerPar,t_vehicule.date_create,t_vehicule.modifierPar,
        t_vehicule.dateModif,t_vehicule.statut_ID,t_agent.matricule,t_agent.nom_ag,t_agent.postnom_ag,
        t_agent.prenom_ag FROM bdd_paie.t_vehicule
        INNER JOIN bdd_paie.t_agent ON t_vehicule.agent_ID = t_agent.matricule WHERE id_veh = :id_veh");
    $req->bindvalue(':id_veh',$id_veh);
    $req->execute();

    while ($resInfoVehicule = $req->fetch()) {
        $id_veh = $resInfoVehicule['id_veh'];

        //$code_vehic = $resInfoVehicule['id_veh'];
        $matricule = $resInfoVehicule['matricule'];
        $nomComplet = $resInfoVehicule['nom_ag'].' '.$resInfoVehicule['postnom_ag'].' '.$resInfoVehicule['prenom_ag'];
        $modele = $resInfoVehicule['modele'];
        $numChassis = $resInfoVehicule['numChassis'];
        $numPermis = $resInfoVehicule['numPermis'];
        $numCarteRose = $resInfoVehicule['numCarteRose'];
        $immatriculation = $resInfoVehicule['immatriculation'];
        $statut = $resInfoVehicule['statut_ID'];
        $creerPar = $resInfoVehicule['creerPar'];
        $dateCreate = $resInfoVehicule['date_create'];
        $modifierPar = $resInfoVehicule['modifierPar'];
        $dateModif = $resInfoVehicule['dateModif'];
        $observ = $resInfoVehicule['observation'];
    }

    }else{
        
    }
?>
<h3><i class="fa fa-angle-right"></i> Modification Véhicule</h3>
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
            <form class="form-horizontal style-form" method="POST" action="update_vehicule.php">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                                <select class="form-control readonly" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez un Agent"name="matric" readonly>
                                    <option value="<?php echo $matricule;?>"> <?php echo $matricule." | ".$nomComplet;?> </option>
                                        <?php /*
                                            $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent WHERE sexe_ag = :sexe_ag');
                                            $reqGetMatriculeAgent->bindValue(':sexe_ag',"M");
                                            $reqGetMatriculeAgent->execute();
                                                while($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()){
                                                    $matric = $resGetMatriculeAgent['matricule']; 
                                                    $nomComplet = $resGetMatriculeAgent['nom_ag'].' '.$resGetMatriculeAgent['postnom_ag'];?>
                                                <option value="<?php echo $matric;?>"> <?php echo $matric.' | '.$nomComplet;?> </option>
                                            <?php } */?>   
                                </select>         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modèle</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="modele" value="<?php echo $modele;?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Num Chassis</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="numChassis" value="<?php echo $numChassis;?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Num Permis</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="numPermis" value="<?php echo $numPermis;?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Carte Rose</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="numCarteRose" value="<?php echo $numCarteRose;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Immatriculation</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="immatric" value="<?php echo $immatriculation;?>">
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
                            <label class="col-sm-3 control-label">Observation</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="observ" value="<?php echo $observ;?>">
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="control-label col-md-3">Acte De Naissance</label>
                            <div class="controls col-md-8">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <span class="btn btn-theme03 btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Choix du fichier</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                        <input type="file" class="default" />
                                    </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div-->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
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
                            <?php } ?>
                            </div>
                        </div>
                                    
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Le</label>
                            <div class="col-sm-8">
                                <input type="datetime" class="form-control" value="<?php echo $dateCreate;?>"readonly>
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
                                if($modifierPar == "sysAdmin" || $modifierPar == NULL){
                                ?><?php echo $modifierPar;?>
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
                            <label class="col-sm-3 control-label">Modifier Le</label>
                            <div class="col-sm-8">
                                <input type="datetime" class="form-control" value="<?php echo $dateModif;?>"readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Statut</label>
                            <div class="col-sm-2 text-center">
                                <input type="checkbox" name="statutCode" 
                                 <?php echo ($statut == "act") ?"checked":"unchecked";?> data-toggle="switch"/>
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
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addAgent"
                            name="updateVehicule" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i> Modifier</button>
                        <a href="accueil.php?page=Voir_Vehicule" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
            
        </div>
        <br><br>
    </div>
</div>
          
            