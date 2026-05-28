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

          <form class="form-horizontal style-form" method="POST" action="add_bareme.php">
                <div class="row">
                
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Id Barème</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="IdBar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Libelle Barème</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="libBar">
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
                                <input type="date" class="form-control" name="dateBar"  value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div>
                       
                        
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">

                        
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

                     
                </div>   
                <div class="row">
                    <div class="col-lg-10 col-sm-10">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Enregistrer" name="creerBar" style="margin-left:15px;width:150px;">
                            <a href="accueil.php?page=voir_Bareme" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Barèmes</a>
                            <a href="accueil.php?page=voir_Bareme_Grade" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Barèmes et grade</a>
                        </div>
                    </div>
                </div>      
            </form>
                
            
        </div>
        <br><br><br><br><br><br><br><br><br>
    </div>
</div>