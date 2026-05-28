<?php
    //session_start();
    include_once('sys_connexion.php');

?>
<h3><i class="fa fa-angle-right"></i> Affectations des Imputations Comptables</h3>
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
          <br><br>
            <form class="form-horizontal style-form" method="post" action="add_CodePaie_imput.php">
                <div class="row ">
                
                  <div class="col-lg-6 col-md-6 col-xl-6">
                    
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Code Paie</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez le Code paie"  name="codepaie" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option></option>
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
                                    <option></option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT code_eqPaie FROM bdd_paie.t_eqpaie');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $codepaie = $resGetcodepaie['code_eqPaie']; ?>
                                    <option value="<?php echo $codepaie ?>"> <?php echo $codepaie;?> </option>
                                    
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Imputation Comptable<strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="imput">
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
                                <input type="date" class="form-control" name="datecodep"  value="<?php echo date('Y-m-d')?>" readonly>
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
                                <input type="date" class="form-control" name="DateModifcodep" value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Enregister" name="enreg" style="margin-left:15px;width:150px;">
                            <a href="accueil.php?page=voir_Code_paie_imputation" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
        <br><br><br><br><br>
    </div>
</div>
          
            