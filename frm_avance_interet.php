<?php
    //session_start();
    include_once('sys_connexion.php');

?>
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
            <form class="form-horizontal style-form" method="post" action="add_Avance.php">
                <div class="row ">
                
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                        <label class="control-label col-md-3">Période</label>
                        <div class="col-md-7">
                            <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="<?php echo date('m/y')?>" class="input-append date dpMonths">
                                <input type="text" readonly="" name="periode" value="<?php echo date('m/y')?>" size="16" class="form-control">
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
                                    <option></option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.t_codepaie');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $codepaie = $resGetcodepaie['codePaie']; 
                                            $libpaie =  $resGetcodepaie['libelle_codePaie'];
                                            ?>
                                    <option value="<?php echo $codepaie?>"> <?php echo $codepaie;?> | <?php echo $libpaie;?>  </option>
                                    
                                <?php } ?>
                                </select>
                            </div>
                    </div>
                        
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Matricule<s/trong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez un Agent"  name="matriAg" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option></option>
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
                                    <option></option>
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
                                <input type="text" class="form-control" name="MontAv">
                            </div>
                        </div>
                        
               
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Valeur</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez A ou I"  name="valeur" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option></option>
                                    <option value="A">A-avance</option>
                                    <option value="I">I-Interim</option>
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer Par</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="creerBar" value="<?php echo $_SESSION['nomComplet']?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateAvc"  value="<?php echo date('Y-m-d')?>" readonly>
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
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Enregister" name="creerAvance" style="margin-left:15px;width:150px;">
                            <a href="accueil.php?page=voir_Avance" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
                
                
            </form>
        </div>
        <br><br><br><br><br>
    </div>
</div>