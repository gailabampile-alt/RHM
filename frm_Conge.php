<?php
    //session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');
    $matricule = "";
    $date_dem = "";
    $id_demande ="";
    $excercice="";
    $nbrejrdem ="";
    $dateDu = "";
    $dateAu = "";
    $observation = "";
    $creerPar = "";
    $dateCreat = "";
    $conge="";
   

if(isset($_GET['id']))
{
$id_demande = $_GET['id'];

$reqGetInfobar = $db->prepare('SELECT * FROM bdd_paie.t_demandeconge 
INNER JOIN bdd_paie.t_typconge ON t_typconge.id_type_conge=t_demandeconge.id_typeconge
INNER JOIN bdd_paie.t_agent on t_agent.matricule=t_demandeconge.matricule WHERE id_demande=:id_demande');
$reqGetInfobar->bindValue(':id_demande',$id_demande);
$reqGetInfobar->execute();

while($resGetInfobar = $reqGetInfobar->fetch())
{
   // $id_demande =$resGetInfobar['id_demande'];
    $matricule = $resGetInfobar['matricule'];
    $nomComplet_ag = $resGetInfobar['nom_ag'].' '.$resGetInfobar['postnom_ag'].' '.$resGetInfobar['prenom_ag'];
    $conge = $resGetInfobar['libelle_conge'];
    $id_type_conge =  $resGetInfobar['id_type_conge'];
    $excercice = $resGetInfobar['excercice'];
    $date_dem= $resGetInfobar['date_demande'];
    $dateDu = $resGetInfobar['date_debut'];
    $dateAu = $resGetInfobar['date_fin'];
    //$observation = $resGetInfobar['observation'];
    $creerPar = $resGetInfobar['creerPar'];
    $dateCreat = $resGetInfobar['date_demande'];
    $nbrejrdem = $resGetInfobar['nbrejr_solic'];
    $nbrejrAcc = $resGetInfobar['nbrejr_accord'];
    $id_user = $resGetInfobar['creerpar'];
  // $sanction_byte = $resGetInfobar['sanction_byte'];
 
    
}

}else{

}
?>
<h3><i class="fa fa-angle-right"></i> Saisie des Congé</h3>
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
            <form class="form-horizontal style-form" method="POST" action="add_conges.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                    <input type="hidden" class="form-control" name="id_demande" value="<?php echo $id_demande;?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                            
                                <select class="form-control chzn-select" 
                                    onchange="showConge(this.value)" data-placeholder="Selectionnez un Agent"name="matric" required>
                                    <option value="<?php echo $matricule;?>"> <?php echo $matricule.' | '.$nomComplet_ag; ?> </option>
                                        
                                </select>         
                            </div>
                        </div>
                        <div  id="Conge">
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">Type de Congé</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="conge" value="<?php echo  $conge;?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3"> Du</label>
                            <div class="col-md-8">
                                <div class="input-group input-large" data-date="01/01/2024" data-date-format="mm/dd/yyyy">
                                    <input type="text" class="form-control dpd1" name="dateDu" value="<?php echo  $dateDu;?>" readonly>
                                    <span class="input-group-addon">Au</span>
                                    <input type="text" class="form-control dpd2" name="dateAu" value="<?php echo  $dateAu;?>"  readonly>
                                </div>
                                <!--span class="help-block">Selectionner la durée</span-->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre de Jour</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nbrejr" value="<?php echo  $nbrejrAcc;?>">
                            </div>
                        </div>
                        
                        </div>
    
                        
                        
                        
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Document</label>
                            <div class="controls col-md-8">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <span class="btn btn-theme03 btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Choix du fichier</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                        <input type="file" class="default" name="fich_doc" />
                                    </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>
                        
                                    
                    
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Le</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" name="date_creat"readonly>
                            </div>
                        </div>

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
                        
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addAgent"
                            name="addConge" style="margin-left:15px;width:150px;"><i class="fa fa-plus-circle"></i> Ajouter</button>
                            <a href="accueil.php?page=voir_conger_autorise" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        <!--a href="accueil.php?page=Voir_Enfant" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a-->
                    </div>
                    </div>
                </div>
            </form>
        </div>
        <br><br><br><br><br><br><br><br><br>
    </div>
</div>
       
<script>
    function showConge(str) {
  if (str == "") {
      document.getElementById("Conge").innerHTML = "";

    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         document.getElementById("Conge").innerHTML = this.responseText;
         
      }
    };
    xmlhttp.open("GET","showConge.php?q="+str, true);
    xmlhttp.send();
  }

}

</script>   
            
