<?php
    //session_start();
    include_once('sys_connexion.php');

?>
<h3><i class="fa fa-angle-right"></i>Pointage / Heure Suplementaire</h3>
<!-- BASIC FORM ELELEMNTS -->
      
<div class="row mt mb" style="margin: 15px;">
          
    <div class="col-lg-12 mt">
        <div class="row content-panel">
            <div class="panel-heading">
                <ul class="nav nav-tabs nav-justified">
                    <li class='active'>
                        <a data-toggle="tab" href="#pointage">Pointage</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#heure">Heure Suplementaire</a>
                    </li>
                </ul>
            </div>
              <!-- /panel-heading -->
            <div class="panel-body">
                <div class="tab-content">
                  <!-- /tab-pane -->
                    <div id="pointage" class="tab-pane active">
                    <?php if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="alert">×</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
      </div>
          <?php } ?>
          <br><br>
                    <div class="row">
                        <div class="col-lg-12 ">
                            
                        <form class="form-horizontal style-form" action="add_pointage.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        
                    <div class="form-group">
                            <label class="control-label col-md-3"><strong>Période</strong></label>
                        <div class="col-md-7">
                            <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="<?php echo date('m/y')?>" class="input-append date dpMonths">
                                <input type="text" readonly="" name="periode" value="" size="16" class="form-control">
                                <span class="input-group-btn add-on">
                                <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>

                    </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="datep" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Matricule</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez un Agent"  name="matriAg" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option></option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.t_agent where t_agent.activiter_ID="01"');
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
                            <label class="col-sm-3 control-label">nbrejrs</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="nbrejrs" required>
                            </div>
                        </div>
                       

                        
                    </div>

                    <div class="col-lg-6 col-md-6 col-xl-6">

                    
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer Par</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="creerpar" value="<?php echo $_SESSION['nomComplet']?>" readonly>
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
                            <label class="col-sm-3 control-label">Modifier le</label>
                            <div class="col-sm-8">
                            <input type="date" class="form-control" name="DateModifcodep" value="<?php echo date('Y-m-d')?>" readonly>
                                
                            </div>
                        </div>
                        
                        
                        
                        
                        
                    </div>

                
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Créer" name="CreerPointage" style="margin-left:15px;width:150px;">
                            <a href="accueil.php?page=voir_pointage" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                            <input type="submit"  formaction="add_pointage.php" class="btn btn-round btn-primary col-sm-3" value="P/Mois" name="Pointage" style="margin-left:15px;width:150px;">
                        </div>
                    </div>
                </div>
          </form> 
                
                        </div>
                      
                    </div>
                    <!-- /row -->
                                                            <br><br><br>
                </div>
                  <!-- /tab-pane -->
                <div id="heure" class="tab-pane">
                
                    <div class="row">
                        <div class="col-lg-12 ">

                   <form class="form-horizontal style-form" action="add_heureS.php" method="POST" enctype="multipart/form-data"> 
                <div class="row">
                
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        
                    <div class="form-group">
                            <label class="control-label col-md-3"><strong>Période</strong></label>
                        <div class="col-md-7">
                            <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="<?php echo date('m/y')?>" class="input-append date dpMonths">
                                <input   type="text" readonly="" name="periode" value="" size="16" class="form-control">
                                <span class="input-group-btn add-on">
                                <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>

                    </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateop" required>
                            </div>
                        </div>
                       <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Matricule</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez un Agent"  name="matriAg" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option></option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.t_agent where t_agent.activiter_ID="01"');
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
                            <label class="col-sm-3 control-label"><strong>Nombre D'heure <strong></label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="nbreh">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Heure</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Choisir le % " name="heure" id="Product" class="form-control " tabindex="2">
                            <option></option>
                            <option value="Normal">Normal</option>
                                    <option value="Nuit">Nuit</option>
                                    <option value="Ferier">Ferier</option>
                            </select>
                            </div>
                        </div>
                        

                        
                    </div>

                <div class="col-lg-6 col-md-6 col-xl-6">
                <div class="form-group">
                            <label class="col-sm-4 control-label"><strong>Creer Par</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="creerpar" value="<?php echo $_SESSION['nomComplet']?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><strong>Creer le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateCreat"  value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><strong>Modifier Par </strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Modif_Par" value="<?php echo $_SESSION['nomComplet']?>"readonly >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><strong>Modifier le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="DateModif" value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div>
                    
                
                            
                        </div>
                    </div>
                        
                        
                        
                    </div>
                   
                    

                
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Créer" name="creerheure" style="margin-left:15px;width:150px;">
                            <a href="accueil.php?page=voir_heures" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
            </form>
            <br><br>
                      </div>
                      <!-- /col-lg-8 -->
                    </div>
                    <!-- /row -->
                </div>
                  <!-- /tab-pane -->
               
                <!-- /tab-content -->
            </div>
              <!-- /panel-body -->
        </div>
            <!-- /col-lg-12 -->
           
    </div>
          <!-- /row -->
       
</div>
   <!-- /container -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  $(".chzn-select").chosen({width: "100%"});
});
</script>