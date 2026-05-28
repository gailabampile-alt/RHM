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
     
        $reqGetInfobar = $db->prepare('SELECT * FROM bdd_paie.detail_grade_bareme INNER join bdd_paie.t_utilisateurs on detail_grade_bareme.creerPar=t_utilisateurs.id_user INNER JOIN bdd_paie.t_agent on t_agent.matricule=t_utilisateurs.agent_ID INNER JOIN bdd_paie.t_bareme ON t_bareme.id_bar=detail_grade_bareme.id_bar INNER JOIN bdd_paie.t_grade ON t_grade.code_grade= detail_grade_bareme.code_grade WHERE detail_grade_bareme.id_grade_bar=:id_grade_bar');
        $reqGetInfobar->bindValue(':id_grade_bar',$id_codepAmodif);
        $reqGetInfobar->execute();
    
        while($resGetInfobar = $reqGetInfobar->fetch()){
            $id_bar = $resGetInfobar['id_bar'];
            $libBar =$resGetInfobar['LibelleBar'];
            $code_grade = $resGetInfobar['code_grade'];
            $libGr = $resGetInfobar['libelle_grade'];
            $Montant_bar = $resGetInfobar['Montant_bar'];
            $devise =  $resGetInfobar['code_devise'];
            $creerPar = $resGetInfobar['creerPar'];
            $nomAg = $resGetInfobar['nom_ag'];
            $PostnomAg = $resGetInfobar['postnom_ag'];
            $PrenomAg = $resGetInfobar['prenom_ag'];
            $modifierPar = $resGetInfobar['modifierPar'];
            $dateCreation = $resGetInfobar['date_creat'];
            //$dateModification = $resGetInfobar[''];
            $nomComplet = $nomAg." ".$PostnomAg." ".$PrenomAg;
            //$idcodeimp=$resGetInfobar['id_grade_bar'];
            $datedebut = $resGetInfobar['Date_debut'];
            $datefin =$resGetInfobar['Date_fin'];
            $id_statut= $resGetInfobar['statut'];
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

<h3><i class="fa fa-angle-right"></i>Nouveau Barème</h3>
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


            <div class="row">
                <form class="form-horizontal style-form" method="POST" action="Update_bareme_grade.php">
            
                    <div class="col-lg-6 col-md-6 col-xl-6">
                    <div class="form-group">
                    <input type="hidden" class="form-control" name="id_bar_grade" value=<?php echo  $id_codepAmodif ;?>>
                            <label class="col-sm-3 control-label"><strong>Barème</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez le Bareme"  name="codebar" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option value="<?php echo $id_bar;?>"><?php echo $id_bar;?> | <?php echo $libBar;?></option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.t_bareme');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $id_bar=$resGetcodepaie['id_bar'];
                                            $libBar =$resGetcodepaie['LibelleBar']; ?>
                                    <option value ="<?php echo $id_bar;?>"> <?php echo $libBar;?> </option>
                                    
                                <?php } ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Grade</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez le grade"  name="codegrade" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option value="<?php echo $code_grade;?> "><?php echo $code_grade;?> | <?php echo $libGr;?></option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.t_grade');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $codegrade = $resGetcodepaie['code_grade'];
                                             ?>
                                    <option><?php echo $codegrade ;?> </option>
                                    
                                <?php } ?>
                                </select>
                            </div>
                    </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Montant</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="MontBar" value=<?php echo $Montant_bar ;?>>
                                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Devise</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez le Devise"  name="codemonnaie" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option><?php echo $devise  ;?></option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.Monnaie');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $codedevise = $resGetcodepaie['code_monnaie'];
                                             ?>
                                    <option><?php echo $codedevise ;?> </option>
                                    
                                <?php } ?>
                                </select>
                            </div>
                    </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Date debut</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="datedeb"  value="<?php echo $datedebut ;?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Date fin</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="datefin"  value="<?php echo $datefin;?>" readonly>
                            </div>
                        </div>
                       
                        
                        
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">

                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer Par</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="creerBar" value="<?php echo $_SESSION['nomComplet']?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateBar"  value="<?php echo $dateCreation?>" readonly>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Modifier Par </strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="ModifBar"value="<?php echo $_SESSION['nomComplet']?>"readonly >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Modifier le</0strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="DateModifBar" value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div>
                        
            
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Activé</strong></label>
                        <div class="col-sm-2 text-center">
                               <input type="checkbox" name="statutCode[]" value="act" <?php if ($id_statut=='act') echo "checked";?> data-toggle="switch" />
                        </div>  
                        </div>
                        <div class="col-lg-12">

                            <input type="submit" class="btn btn-round btn-primary" value="Modifier" name="creerBarGr">
                            <a href="accueil.php?page=voir_Bareme" class="btn btn-round btn-primary">Liste des Barèmes</a>
                            <a href="accueil.php?page=voir_Bareme_Grade" class="btn btn-round btn-primary">Liste des Barèmes et grade</a>
                        </div>
                        </div>
                   
                        
                        
                     
                </form>
                
                
            </div>
        </div>
        <br><br><br><br>
    </div>
</div>