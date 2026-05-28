<?php
    //session_start();
	include_once('sys_connexion.php');
    include_once('sys_fonction.php');
    
    $nomComplet = '';
    $creerPar = $_SESSION['id_utilisateur'];
?>
<h3><i class="fa fa-angle-right"></i> Changement Mot De Passe</h3>
<!-- BASIC FORM ELELEMNTS -->

<br><br>
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
            <form class="form-horizontal style-form" method="POST" action="sys_passwordChange.php">
                <div class="row" style="margin-top: 25px;">
                    <div class="col-lg-4 col-md-4 col-xl-4" >
                        <img src="img/password_change.jpeg" width="300px" style="border-radius: 50%;">
                    </div>
                    
                    <div class="col-lg-8 col-md-8 col-xl-8">
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Ancien Mot de passe</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" name="lastPassword">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Nouveau Mot de passe</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" name="Password1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Confirmation Mot de passe</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" name="Password2">
                            </div>
                        </div>

                        <div class="form-group">
                        <button type="submit" class="btn btn-round btn-primary col-sm-6" id="addProvince"
                            name="changePass" style="margin-left: 50%;width:250px;"><i class="fa fa-edit"></i> Changer</button>
                        <!--a href="accueil.php?page=Voir_Province" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a-->
                    </div>
                        
                    </div>
                    
                </div>
            </form>
        </div>
        <br><br><br><br>
    </div>
</div>
          
            