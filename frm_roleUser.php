<?php
    //session_start();
    include_once('sys_connexion.php');
    $matricule = '';
    $nom = '';
?>
<h3><i class="fa fa-angle-right"></i> Création Des Roles</h3>
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
            <form class="form-horizontal style-form" method="POST" action="add_roleUser.php">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Code</label>
                            <div class="col-sm-8">
                                 <?php // Get Last ID from the table to generate new ID
                                    $reqActiverGrade = $db->prepare("SELECT MAX(id_role) AS dernier_id FROM bdd_paie.t_role_user");
                                    $reqActiverGrade->execute();
                                    $row = $reqActiverGrade->fetch(PDO::FETCH_ASSOC);
                                    $dernierId = $row['dernier_id'];
                                    if(strlen($dernierId) <= 2){
                                        $dernierId = '0'.($dernierId + 1);
                                    }else{
                                        $dernierId = $dernierId + 1;
                                    }
                                ?>
                                <input type="text" class="form-control" value="<?php echo $dernierId;?>" name="code" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Libellé Role</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="libRole" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Création</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateCreationUser" value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Dernière Modification</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateLastModifUser" value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div-->
                       
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">CréerPar</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $_SESSION['nomComplet']?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">ModifierPar</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $_SESSION['nomComplet']?>" readonly>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Statut</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="statut">
                                    <option>Choisir un statut</option>
                                    <option value="act"> Active </option>
                                    <option value="desac"> Désactive</option>
                                </select>
                            </div>
                        </div-->
                        
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Créer" name="add_roleUser" style="margin:15px;width:150px;">
                            <a href="accueil.php?page=Voir_roleUser" class="btn btn-round btn-warning col-sm-3" style="margin:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
            </form>   
            
        </div>
        <br><br><br><br><br>
    </div>
</div>
          
            