<?php
    //session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');
    $code_gr = "";
    $libelle_gr = "";
    $eqPaie = "";
    $eqCompt = "";
    $creerPar = "";
    $date_creat = "";
    $modifierPar = "";
    $dateModif = "";
    $statut = "";
if(isset($_GET['code_gr'])){
$code_grade_orig = $_GET['code_gr'];
$req = $db->prepare("SELECT * FROM bdd_paie.t_grade WHERE code_grade = :code_grade ");
$req->bindvalue(':code_grade',$code_grade_orig);
$req->execute();

while ($reqResultat = $req->fetch()) {
    $code_gr = $reqResultat['code_grade'];
    $libelle_gr = $reqResultat['libelle_grade'];
    $eqPaie = $reqResultat['Eq_Paie_ID'];
    $eqCompt = $reqResultat['Eq_Compt_ID'];
    $creerPar = $reqResultat['creePar'];
    $date_creat = $reqResultat['Date_Creat'];
    $modifierPar = $reqResultat['modifierPar'];
    $dateModif = $reqResultat['Date_Modif'];
    $statut = $reqResultat['statut_ID'];
    
}

}
?>
<h3><i class="fa fa-angle-right"></i> Modification Grade</h3>
<!-- BASIC FORM ELELEMNTS -->

<div class="row mt">
    <div class="col-lg-12">
        
        <div class="form-panel">
            <form class="form-horizontal style-form" method="POST" action="update_grade.php">
                <div class="row centered">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Code Grade</label>
                            <div class="col-sm-8">
                                <input type="hidden" class="form-control" value="<?php echo $code_grade_orig;?>" name="code_Orig">
                                <input type="text" class="form-control" value="<?php echo $code_gr;?>" name="cod_gr">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Libellé Grade</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $libelle_gr;?>" name="lib_gr">
                            </div>
                        </div>
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
                                }?>
                                <input type="text" value="<?php echo $nomComplet;?>" class="form-control" readonly>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Création</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo $date_creat;?>" readonly>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Equipe Paie</label>
                            <div class="col-sm-8">
                                <select name="eqPaie" class="form-control">
                                    <option value="<?php echo $eqPaie;?> "> <?php echo $eqPaie;?> </option>
                                    <?php 
                                        $reqGetEqPaie = $db->prepare('SELECT code_eqPaie,libelle_eqPaie FROM bdd_paie.t_eqpaie');
                                        $reqGetEqPaie->execute();
                                        while($resGetEqPaie = $reqGetEqPaie->fetch()){
                                            $code_eqPaie = $resGetEqPaie['code_eqPaie'];
                                            $lib_eqPaie = $resGetEqPaie['libelle_eqPaie'];?>
                                        <option value="<?php echo $code_eqPaie; ?>"> <?php echo $lib_eqPaie; ?> </option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Equipe Compt</label>
                            <div class="col-sm-8">
                                <select name="eqCompt" class="form-control">
                                    <option value="<?php echo $eqCompt;?>"> <?php echo $eqCompt;?> </option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                </select>
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Modifier</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo $dateModif;?>" readonly>
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
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="btnModifierAgent"
                            name="updateGrade" style="margin-left:15px;width:150px;"><i class="fa fa-money"></i> Modifier</button>
                        <a href="accueil.php?page=Voir_Grade" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</div>
          
            