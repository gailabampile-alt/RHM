<?php
include_once('sys_connexion.php');
    
    $id_bar = '';
    $code_grade = '';
    $Montant_bar ='';
    $creerPar = '';
    $modifierPar = '';
    $dateCreation = '';
    $dateModification = '';
    if(isset($_GET['id'])){
        $id_codepAmodif = $_GET['id'];
     
        $reqGetInfobar = $db->prepare('SELECT t_avance.periodeAv, t_avance.code_paie_ID, t_codepaie.libelle_codePaie, t_avance.Agent_ID , t_agent.nom_ag, 
        t_agent.postnom_ag,t_avance.montant,t_avance.code_monnaie,t_avance.valeur, t_avance.creePar,t_avance.modifierPar,t_avance.date_avc,t_avance.dateModif, 
        t_avance.date_avc FROM bdd_paie.t_avance INNER JOIN bdd_paie.t_agent on t_agent.matricule=t_avance.Agent_ID 
        INNER JOIN bdd_paie.t_codepaie on t_codepaie.codePaie=t_avance.code_paie_ID WHERE bdd_paie.t_avance.id_avc=:id_avc');
        $reqGetInfobar->bindValue(':id_avc',$id_codepAmodif);
        $reqGetInfobar->execute();
    
        while($resGetInfobar = $reqGetInfobar->fetch()){
            $codepaie = $resGetInfobar['code_paie_ID'];
            $libBar =$resGetInfobar['Agent_ID'];
            $mont = $resGetInfobar['montant'];
            $monnaie = $resGetInfobar['code_monnaie'];
            $Montant_bar = $resGetInfobar['code_paie_ID'];
            $periode =  $resGetInfobar['periodeAv'];
            $creerPar = $resGetInfobar['creePar'];
            $nomAg = $resGetInfobar['nom_ag'];
            $PostnomAg = $resGetInfobar['postnom_ag'];
            $modifierPar = $resGetInfobar['modifierPar'];
            $dateCreation = $resGetInfobar['date_avc'];
            $datemofif = $resGetInfobar['dateModif'];
            $valeur = $resGetInfobar['valeur'];
            $nomComplet = $nomAg." ".$PostnomAg;
            //$idcodeimp=$resGetInfobar['id_grade_bar'];
            $libcodepaie = $resGetInfobar['libelle_codePaie'];
            $matri =$resGetInfobar['Agent_ID'];
            //$id_statut= $resGetInfobar['statut'];
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

<h3><i class="fa fa-angle-right"></i>Avance / Interim</h3>
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
          <br><br>
            <form class="form-horizontal style-form" method="post" action="Update_Avance.php">
                <div class="row ">
                
                  <div class="col-lg-6 col-md-6 col-xl-6">
                  <div class="form-group">
                  <input type="hidden" class="form-control" name="id_avc" value=<?php echo  $id_codepAmodif ;?>>
                  <label class="control-label col-md-3"><strong>Période</strong></label>
                  <div class="col-md-7">
                    <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="<?php echo date('m/y')?>" class="input-append date dpMonths">
                      <input type="text" readonly="" name="periode" value="<?php echo $periode ?>" size="16" class="form-control">
                      <span class="input-group-btn add-on">
                        <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                   
                  </div>
                </div>
                  
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Code Paie</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez le Code paie"  name="codepaie" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option value='<?php echo $codepaie ?>'><?php echo $libcodepaie ?> | <?php echo $codepaie ?></option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.t_codepaie');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $codepai = $resGetcodepaie['codePaie']; 
                                            $libpaie =  $resGetcodepaie['libelle_codePaie'];
                                            ?>
                                    <option value="<?php echo $codepai?>"> <?php echo $codepai;?> | <?php echo $libpaie;?>  </option>
                                    
                                <?php } ?>
                                </select>
                            </div>
                    </div>
                        
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Matricule<s/trong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez un Agent"  name="matriAg" id="Product" class="form-control chzn-select" tabindex="2">
                            <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.t_agent WHERE t_agent.matricule=:matric');
                                        $reqGetcodepaie->bindValue(':matric',$matri);
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $matri = $resGetcodepaie['matricule']; 
                                            $nomAg = $resGetcodepaie['nom_ag'];
                                            $postnom = $resGetcodepaie['postnom_ag'];
                                            
                                            ?>
                                            
                                    <option value="<?php echo $matri ?>"> <?php echo $matri;?>|<?php echo $nomAg;?> <?php echo $postnom;?></option>
                                    
                                <?php } ?>   
                            
                            
                            <option value="<?php echo $matri ?>"><?php echo $matri ?> | <?php echo $nomComplet ?> </option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.t_agent');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $matri = $resGetcodepaie['matricule']; 
                                            $nomAg = $resGetcodepaie['nom_ag'];
                                            $postnom = $resGetcodepaie['postnom_ag'];
                                            ?>
                                            
                                    <option value="<?php echo $matri ?>"> <?php echo $matri;?>|<?php echo $nomAg;?> <?php echo $postnom;?></option>
                                    
                                <?php } ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Devise</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez le Devise"  name="codemonnaie" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option value="<?php echo $monnaie ?>"><?php echo $monnaie ?></option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.Monnaie');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $codegrade = $resGetcodepaie['code_monnaie'];
                                             ?>
                                    <option value='<?php echo $codegrade ;?>'><?php echo $codegrade ;?> </option>
                                    
                                <?php } ?>
                                </select>
                            </div>
                       </div>
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Montant</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="MontAv" value="<?php echo $mont ?>">
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-xl-8">
                        <button type="submit" class="btn btn-round btn-primary" name="creerAvance"><i class="fa fa-edit"></i> Modifier</button>
                        <a href="accueil.php?page=voir_Avance" class="btn btn-round btn-warning" style="margin-left:15px;width:180px;"> <i class="fa fa-list"></i> Avances & Interims</a>
                    </div>
               
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Valeur</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez A ou I"  name="valeur" id="Product" class="form-control chzn-select" tabindex="2">
                            <?php 
                                if($valeur == "I"){
                                ?>
                                    <option value="<?php echo $valeur ?>">I-Interim</option>
                                    <?php 
                                }else{ ?>
                                    <option value="<?php echo $valeur ?>">A-avance</option> 
                                    <?php  }?>
                                    <option value="A">A-avance</option>
                                    <option value="I">I-Interim</option>
                            </select>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer Par</strong></label>
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
                                
                                <input type="text" class="form-control" name="creerBar" value="<?php echo $nomComplet?>" readonly>
                            <?php } ?>
                               
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateAvc"  value="<?php echo $dateCreation?>" readonly>
                            </div>
                        </div>  
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Modifier Par </strong></label>
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
                                
                                <input type="text" class="form-control" name="ModifBar"value="<?php echo $nomComplet;?>"readonly >
                            <?php } ?>
                               
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Modifier le</0strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="DateModifcodep" value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
            <?php include_once('confirm_modify_modal.php'); ?>
        </div>
        <br><br><br><br><br>
    </div>
</div>