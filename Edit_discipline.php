<?php
    //session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');
            $matricule = "";
            $nomComplet_ag = "";
            $sanct ="";
            $id_typesanct ="";
            $Numref ="";
            $ate_sanct= "";
            $dateDu = "";
            $dateAu = "";
            $observation = "";
            $creerPar = "";
            $dateCreat = "";
            $sanction = "";
           $sanction_byte = "";

    if(isset($_GET['id']))
{
        $id_sanct = $_GET['id'];
     
        $reqGetInfobar = $db->prepare('SELECT t_sanct_agent.matricule,nom_ag,postnom_ag,prenom_ag, libelle_typesanct,t_sanct_agent.id_typesanct, ref_sanct,datecreat,t_sanct_agent.date_debut,t_sanct_agent.date_fin, t_sanct_agent.date_debut, t_sanct_agent.date_fin, observation,t_sanct_agent.creerPar, t_sanct_agent.datecreat, t_sanct_agent.modifierPar, t_sanct_agent.dateModif, t_sanct_agent.sanction,t_sanct_agent.sanction_byte FROM bdd_paie.t_sanct_agent 
        INNER join bdd_paie.t_utilisateurs on t_sanct_agent.creerPar =t_utilisateurs.id_user 
        INNER JOIN bdd_paie.t_agent on t_agent.matricule=t_sanct_agent.matricule
        INNER JOIN bdd_paie.t_type_sanct ON t_type_sanct.id_typesanct=t_sanct_agent.id_typesanct 
        WHERE t_sanct_agent.id_sanct=:id_sanct');
        $reqGetInfobar->bindValue(':id_sanct',$id_sanct);
        $reqGetInfobar->execute();
    
        while($resGetInfobar = $reqGetInfobar->fetch())
    {

            $matricule = $resGetInfobar['matricule'];
            $nomComplet_ag = $resGetInfobar['nom_ag'].' '.$resGetInfobar['postnom_ag'].' '.$resGetInfobar['prenom_ag'];
            $sanct = $resGetInfobar['libelle_typesanct'];
            $id_typesanct =  $resGetInfobar['id_typesanct'];
            $Numref = $resGetInfobar['ref_sanct'];
            $ate_sanct= $resGetInfobar['datecreat'];
            $dateDu = $resGetInfobar['date_debut'];
            $dateAu = $resGetInfobar['date_fin'];
            $observation = $resGetInfobar['observation'];
            $creerPar = $resGetInfobar['creerPar'];
            $dateCreat = $resGetInfobar['datecreat'];
            $modifPar = $resGetInfobar['modifierPar'];
            $datemodif = $resGetInfobar['dateModif'];
            $sanction = $resGetInfobar['sanction'];
           $sanction_byte = $resGetInfobar['sanction_byte'];
         
            
    }
      
}else{
      
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
<h3><i class="fa fa-angle-right"></i> Modification Action Disciplinaire</h3>
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
            <form class="form-horizontal style-form" method="POST" action="update_sanction.php" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-xl-6">
                  <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez un Agent"name="matric" required>
                                    <option value="<?php echo $matricule;?>"> <?php echo $matricule.' | '.$nomComplet_ag; ?> </option>
                                        <?php
                                            $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent ');
                                            //$reqGetMatriculeAgent->bindValue(':sexe_ag',"M");
                                            $reqGetMatriculeAgent->execute();
                                                while($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()){
                                                    $matric = $resGetMatriculeAgent['matricule']; 
                                                    $nomComplet = $resGetMatriculeAgent['nom_ag'].' '.$resGetMatriculeAgent['postnom_ag'];?>
                                                <option value="<?php echo $matric;?>"> <?php echo $matric.' | '.$nomComplet;?> </option>
                                            <?php } ?>   
                                </select> 
                                <input type="hidden" class="form-control" name="id_sanct" value="<?php echo $id_sanct;?>">
                                <input type="hidden" class="form-control" name="$sanction_byte" value="<?php echo $sanction_byte;?>">        
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sanction</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez une sanction" name="sanct" required>
                                    <option value="<?php echo $id_typesanct ;?>"> <?php echo $sanct;?> </option>
                                        <?php
                                            $reqGetMatriculeAgent = $db->prepare('SELECT * FROM bdd_paie.t_type_sanct ');
                                            //$reqGetMatriculeAgent->bindValue(':sexe_ag',"M");sexe_ag = :sexe_ag AND 
                                            //$reqGetMatriculeAgent->bindValue(':activiter_ID',"01");
                                            $reqGetMatriculeAgent->execute();
                                                while($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()){
                                                    $sanct = $resGetMatriculeAgent['libelle_typesanct']; 
                                                    $code_sanct = $resGetMatriculeAgent['id_typesanct']; 
                                                    ?>
                                                <option value="<?php echo  $code_sanct;?>"> <?php echo  $sanct;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Numéro Ref</label>
                            <div class="col-sm-8">
                                <input type="" class="form-control" name="Numref" value="<?php echo  $Numref;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="date_sanct" value="<?php echo  $dateCreat;?>">
                            </div>
                        </div>

                   <!--     <div class="form-group">
                            <label class="col-sm-3 control-label">Exercice</label>
                            <div class="col-sm-8">
                                <input type="" class="form-control" name="excercice">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nbre jour</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nbrjr">
                            </div>
                        </div>-->

                        <div class="form-group">
                            <label class="control-label col-md-3"> Du</label>
                            <div class="col-md-8">
                                <div class="input-group input-large" data-date="01/01/2024" data-date-format="mm/dd/yyyy">
                                    <input type="text" class="form-control dpd1" name="dateDu" value="<?php echo  $dateDu;?>" readonly>
                                    <span class="input-group-addon">Au</span>
                                    <input type="text" class="form-control dpd2" name="dateAu"value="<?php echo  $dateAu;?>" readonly>
                                </div>
                                <!--span class="help-block">Selectionner la durée</span-->
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Acte De Naissance</label>
                            <div class="controls col-md-8">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <span class="btn btn-theme03 btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Modifier : <?php echo $sanction;?></span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                        <input type="file" class="default" name="fich_sanct"/>
                                        <input type="hidden" class="default" name="fich_sanct_Exist" value="<?php echo $documents;?>" />
                                    </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>


                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Sexe</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sexe_enf" required>
                                    <option value="">Choisir un sexe</option>
                                    <option value="M">M - Masculin</option>
                                    <option value="F">F - Feminin</option>
                                </select>
                            </div>
                        </div-->
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
                                <textarea rows="4"class="form-control" name="observation"> <?php echo $observation;?> </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                                <?php
                                    $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                                    $reqGetNomUtilisateur->bindvalue(':id_user',$creerPar);
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
                                <input type="date" class="form-control" value="<?php echo $dateCreat;?>" name= 'datecreat'readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <?php
                                    $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                                    $reqGetNomUtilisateur->bindvalue(':id_user',$modifPar);
                                    $reqGetNomUtilisateur->execute();
                                    while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                                        $nomComplet = $resGetNomUtilisateur['nom_ag'].' '.$resGetNomUtilisateur['postnom_ag'].' '.$resGetNomUtilisateur['prenom_ag'];
                                    }
                                ?>
                                <input type="text" class="form-control" name="modifierPar" value="<?php echo $nomComplet; ?>" readonly>
                            </div>
                        </div>
                                    
                        

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Le</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo $datemodif;?>" name= 'dateModif'readonly>
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
                            name="addsanction" style="margin-left:15px;width:150px;"><i class="fa fa-plus-circle"></i> Modifier</button>
                            <a href="accueil.php?page=voir_sanction" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        <!--a href="accueil.php?page=Voir_Enfant" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a-->
                    </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>
<br><br>
            