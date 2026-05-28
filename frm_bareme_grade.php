<?php
    //session_start();
    include_once('sys_connexion.php');
   
?>

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
                <form class="form-horizontal style-form" method="POST" action="add_bareme_grade.php">
            
                    <div class="col-lg-6 col-md-6 col-xl-6">
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Barème</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez le Bareme"  name="codebar" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option></option>
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
                                    <option></option>
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
                                <input type="text" class="form-control" name="MontBar">
                                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Devise</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez le Devise"  name="codemonnaie" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option></option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.Monnaie');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $codegrade = $resGetcodepaie['code_monnaie'];
                                             ?>
                                    <option><?php echo $codegrade ;?> </option>
                                    
                                <?php } ?>
                                </select>
                            </div>
                       </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Date debut</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="datedeb"  value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Date fin</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="datefin"  value="<?php echo date('Y-m-d')?>" readonly>
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
                                <input type="date" class="form-control" name="dateBar"  value="<?php echo date('Y-m-d')?>" readonly>
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
                               <input type="checkbox" name="statutCode[]" value="act" checked="" data-toggle="switch" />
                        </div>  
                        </div>
                        
                    </div>
                    <div class="row" style="margin-left: 3px;">
                        <div class="col-lg-10 col-sm-10">
                            <div class="form-group">
                                <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Enregistrer" name="creerBarGr" style="margin-left:15px;width:150px;">
                                <a href="accueil.php?page=voir_Bareme" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Liste des Barèmes</a>
                                <a href="accueil.php?page=voir_Bareme_Grade" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Barèmes et grade</a>
                            </div>
                        </div>
                    </div>
                        
                        
                     
                </form>
                
            </div>
        </div>
        <br><br><br><br>
    </div>
</div>