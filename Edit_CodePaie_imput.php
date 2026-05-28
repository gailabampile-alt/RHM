<?php
    include_once('sys_connexion.php');
    $codepaie = '';
    $codeEp = '';
    $creerPar = '';
    $modifierPar = '';
    $dateCreation = '';
    $dateModification = '';
    if(isset($_GET['id'])){
        $id_codepAmodif = $_GET['id'];
     
        $reqGetInfobar = $db->prepare('SELECT detail_codepaie_compt_eqcompt.code_paie_ID,t_eq_compt.code_EqCompt,t_eq_compt.libelle_eqCompt,detail_codepaie_compt_eqcompt.code_compt_ID,detail_codepaie_compt_eqcompt.creerPar,detail_codepaie_compt_eqcompt.modifierPar,detail_codepaie_compt_eqcompt.date_Creat,detail_codepaie_compt_eqcompt.date_Modif,detail_codepaie_compt_eqcompt.statut_ID FROM bdd_paie.detail_codepaie_compt_eqcompt 
INNER JOIN bdd_paie.t_codepaie ON t_codepaie.codePaie=detail_codepaie_compt_eqcompt.code_paie_ID 
INNER JOIN bdd_paie.t_eq_compt on t_eq_compt.code_EqCompt = detail_codepaie_compt_eqcompt.code_EqCompt 
WHERE bdd_paie.detail_codepaie_compt_eqcompt.Id_codepaie_imput =:Id_codepaie_imput');
        $reqGetInfobar->bindValue(':Id_codepaie_imput',$id_codepAmodif);
        $reqGetInfobar->execute();
    
        while($resGetInfobar = $reqGetInfobar->fetch()){
            $codepaie = $resGetInfobar['code_paie_ID'];
            $code_compt_ID = $resGetInfobar['code_compt_ID'];
            $code_EqCompt = $resGetInfobar['code_EqCompt'];
            $creerPar = $resGetInfobar['creerPar'];
           // $nomAg = $resGetInfobar['nom_ag'];
          //  $PostnomAg = $resGetInfobar['postnom_ag'];
           // $PrenomAg = $resGetInfobar['prenom_ag'];
            $modifierPar = $resGetInfobar['modifierPar'];
            $dateCreation = $resGetInfobar['date_Creat'];
            $dateModification = $resGetInfobar['date_Modif'];
           // $nomComplet = $nomAg." ".$PostnomAg." ".$PrenomAg;
           // $idcodeimp=$resGetInfobar['Id_codepaie_imput'];
        }
            
    }else{
      
    }
?>

<h3><i class="fa fa-angle-right"></i>Affectations Code Avec imputation</h3>
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

          <br> 
            <div class="row">
                <form class="form-horizontal style-form" method="POST" action="update_codepaie_imput.php">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                    <input type="hidden" class="form-control" name="idcodeImp" value="<?php echo $id_codepAmodif?>" readonly>
                   
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Code Paie</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez le Code paie"  name="codepaie" id="Product" class="form-control chzn-select" tabindex="2">
                         
                            <option value="<?php echo $codepaie?>"> <?php echo $codepaie;?> </option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT codePaie FROM bdd_paie.t_codepaie');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $codepaie = $resGetcodepaie['codePaie']; ?>
                                    <option value="<?php echo $codepaie?>"> <?php echo $codepaie;?> </option>
                                    
                                <?php } ?>
                                </select>
                            </div>
                    </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Equipe Comptable<s/trong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez l'Equipe Comptable"  name="EquipeCompt" id="Product" class="form-control chzn-select" tabindex="2">
                            <option value="<?php echo  $code_EqCompt ?>"> <?php echo  $code_EqCompt;?> </option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT code_eqPaie FROM bdd_paie.t_eqpaie');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $code_Eq = $resGetcodepaie['code_eqPaie']; ?>
                                    <option value="<?php echo $code_Eq ?>"> <?php echo $code_Eq;?> </option>
                                    
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Imputation Comptable<strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="imput" value="<?php echo $code_compt_ID?>">
                            </div>
                        </div>
                       
                       <div class="row">
                            <div class="col-lg-8">

                        <input type="submit" class="btn btn-round btn-primary" value="Modifier" name="ModifCodep" >
                        <a href="accueil.php?page=voir_Code_paie_imputation" class="btn btn-round btn-primary">Liste des Elements de Paie</a>
                        </div>
                       
                        </div> 
                        
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Créer Par</strong></label>
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
                                
                                <input type="text" class="form-control" name="creercode" value="<?php echo $nomComplet?>"  readonly>
                            <?php } ?>
                                
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="datecodep"  value="<?php echo $dateCreation?>" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                            <?php 
                                if($modifierPar == "sysAdmin" OR $modifierPar == NULL){
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
                            <label class="col-sm-3 control-label"><strong>Modifier le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="DateModifcodep" value="<?php echo $dateModification?>" readonly>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                </form>
                
                
            </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br>
    </div>
</div>