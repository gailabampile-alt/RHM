
<h3><i class="fa fa-angle-right"></i> Codes Paie</h3>
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
            <form class="form-horizontal style-form" method="POST" action="add_CodePaie.php">
                <div class="row">
                
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Code</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="codepaie">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Libellé</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="lib_codepaie">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sens</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sens">
                                    <option>Choisir le sens de la paie</option>
                                    <option value="1">Sens 1</option>
                                    <option value="2">Sens 2</option>
                                    <option value="3">Sens 3</option>
                                    <option value="4">Sens 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Imposable</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="imposable">
                                    <option>Choisir une valeur</option>
                                    <option value="I">I - Imposable</option>
                                    <option value="N">N - Non imposable</option>
                                </select>
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Activé</strong></label>
                            <div class="col-sm-2 text-center">
                               <input type="checkbox" name="statutCode[]" value="act" checked="" data-toggle="switch" />
                            </div>  
                        </div>
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Enregister" name="creercodepaie" style="margin-left:15px;width:150px;">
                            <a href="accueil.php?page=voir_Code_paie" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>

                
            </form>
        </div>
        <br><br><br><br>
    </div>
</div>
          
            