<?php
    //session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');
    $id_pret = "";
    $nomComplet = "";
    $durer = "";
    $periode = "";
    $nRef = "";
    $montPreter = "";
    $solde = "";
    $aPayer = "";
    $dateDebut = "";
    $interet ="" ;
    $cod_paie = "";
    $lib_paie = "";
    $statut = "";
    $monnaie = "";
    $creerPar = "";
    $matric = "";
if(isset($_GET['id_pret'])){
$id_pret = $_GET['id_pret'];
$req = $db->prepare("SELECT * FROM bdd_paie.v_info_pret WHERE id_pret = :id_pret");
$req->bindvalue(':id_pret',$id_pret);
$req->execute();

while ($reqResultat = $req->fetch()) {
    $nomComplet = $reqResultat['nom_ag'].' '.$reqResultat['postnom_ag'].' '.$reqResultat['prenom_ag'];
    $durer = $reqResultat['moisEpuration'];
    $periode = $reqResultat['periodePret'];
    $nRef = $reqResultat['N_refPret'];
    $montPreter = $reqResultat['montantPreter'];
    $solde = $reqResultat['solde'];
    $aPayer = $reqResultat['montant_a_retenir'];
    $dateDebut = $reqResultat['dateDebut_retenir'];
    $interet = $reqResultat['taux_Interet'];
    $cod_paie = $reqResultat['codePaie'];
    $lib_paie = $reqResultat['libelle_codePaie'];
    $statut = $reqResultat['statut_ID'];
    $monnaie = $reqResultat['monnaie_ID'];
    $creerPar = $reqResultat['creerPar'];
    $modifierPar = $reqResultat['modifierPar'];
    $dateModif = $reqResultat['dateModifier'];
    $matric = $reqResultat['matricule'];
    $nomModif = "";
    $id_pret= $reqResultat['id_pret'];
}

}else{
      
}
?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
});
</script>
<h3><i class="fa fa-angle-right"></i> Octroi des Prêts</h3>

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
            <form class="form-horizontal style-form" method="POST" action="update_pret.php">
                <div class="row">
                
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">N° OP</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nRef" value="<?php echo $nRef; ?>" required readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <input type="hidden" value="<?php echo $id_pret;?>" name="id_pret">
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="matric" required>
                                <option value="<?php echo $matric;?>"> <?php echo $matric.' | '.$nomComplet;?> </option>
                                    <?php
                                        $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent');
                                        $reqGetMatriculeAgent->execute();
                                        while($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()){
                                            $matric = $resGetMatriculeAgent['matricule']; 
                                            $nomComplets = $resGetMatriculeAgent['nom_ag'].' '.$resGetMatriculeAgent['postnom_ag'].' '.$resGetMatriculeAgent['prenom_ag'];?>
                                        <option value="<?php echo $matric;?>"> <?php echo $matric.' | '.$nomComplets;?> </option>
                                    <?php } ?>   
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Code Paie</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="codePaie" required>
                                <option value="<?php echo $cod_paie;?>"> <?php echo $cod_paie.' | '.$lib_paie;?> </option>
                                    <?php
                                        $reqGetMatriculeAgent = $db->prepare('SELECT codePaie,libelle_codePaie FROM bdd_paie.t_codepaie');
                                        $reqGetMatriculeAgent->execute();
                                        while($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()){
                                            $cod_paie = $resGetMatriculeAgent['codePaie']; 
                                            $lib_paie = $resGetMatriculeAgent['libelle_codePaie'];?>
                                        <option value="<?php echo $cod_paie;?>"> <?php echo $cod_paie.' | '.$lib_paie;?> </option>
                                    <?php } ?>   
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Période</label>
                            <div class="col-sm-7">
                                <!--input type="month" class="form-control"-->
                                <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="01/2014" class="input-append date dpMonths">
                                    <input type="text" value="<?php echo $periode;?>" name="periode" size="16" class="form-control" required>
                                    <span class="input-group-btn add-on">
                                        <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Début</label>
                            <div class="col-sm-8">
                                <input type="date" value="<?php echo $dateDebut;?>" class="form-control" name="dateDebut" require>
                            </div>
                        </div>
                                         
                        <div class="form-group">
                            <label class="col-sm-3 control-label">CréerPar</label>
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
                                 <input type="text" class="form-control" name="DateModif" value="<?php echo $nomComplet;?>" readonly>
                              
                            <?php } ?>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Montant Prêter</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $montPreter;?>" class="form-control" id="Detailspret" name="montPreter" required>
                            </div>
                            <label class="col-sm-2 control-label">Taux en %</label>
                            <div class="col-sm-3">
                            <input type="text" value="<?php echo $interet;?>" class="form-control" name="interet" id="Detailstaux" onchange="calculesolde(this.value)" required>
                                
                            </div>
                        </div>
                        <div class="form-group" id="solde_aPayer">
                            <label class="col-sm-3 control-label">Solde</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?php echo $solde;?>" class="form-control" name="solde" id="DetailSolde" required readonly>
                            </div>
                            <label class="col-sm-2 control-label">Durée</label>
                            <div class="col-sm-3">
                            <input type="text" value="<?php echo $durer;?>" class="form-control"  name="durer" id="DetailsDuree"  onchange="calculeretenir(this.value)" required>
                               
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">A Payer</label>
                            <div class="col-sm-4">
                            <input type="text" value="<?php echo $aPayer;?>" class="form-control" name="aPayer" id="Detailsretenir" required readonly>
                   
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Monnaie</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="monnaie" required>
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
                                 <input type="text" class="form-control" name="DateModif" value="<?php echo $nomComplet;?>" readonly>
                              
                            <?php } ?>
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Modification </label>
                            <div class="col-sm-8">
                                <input type="date" value="<?php echo $dateModif;?>" class="form-control" name="dateModif" require readonly>
                            
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id=""
                            name="modifierPret" style="margin-left:15px;width:150px;"><i class="fa fa-money"></i> Modifier</button>
                        <button type="submit" name="deletePret" formaction="delete_pret.php?id_pret=<?php echo $id_pret;?>" class="btn btn-round btn-danger col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-eraser"></i> Supprimer</button>
                        <a href="accueil.php?page=Voir_Prets" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
            <?php include_once('confirm_modify_modal.php'); ?>
        </div>
  
    </div>
</div>
<br><br>
<script>
    /*
      function calculPret(str) {
          var xmlhttp = new XMLHttpRequest();
          var durer = document.getElementById("durer").value;
          var montPreter = document.getElementById("montantPreter").value;
          var interet = document.getElementById("interet").value;
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("solde_aPayer").innerHTML = this.responseText;
            }
          };
          xmlhttp.open("GET","showCalculPret.php?durer=" +durer+ "&montPreter=" +montPreter+ "&interet=" +interet, true);
          xmlhttp.send();
        }
        

        function calculPret()
        {
        var durer = document.getElementById("durer").value;
        var montPreter = document.getElementById("montantPreter").value;
        var interet = document.getElementById("interet").value;
        $.ajax({
            type: 'GET',
            url: 'showCalculPret.php',
            data: {
            durer:durer,
            montPreter:montPreter,
            interet:interet
            },
            success: function (response) {
            $('#solde_aPayer').innerHTML();//html("Vos données seront sauvegardées");
            }
        });
            
        return false;
        }
    
    */
   </script>