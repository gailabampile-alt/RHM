<?php
    //session_start();
    include_once('sys_connexion.php');
    $matricule = '';
    $nom = '';
?>
<h3><i class="fa fa-angle-right"></i> Création Des Utilisateurs</h3>
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
            <form class="form-horizontal style-form" method="POST" action="add_utilisateur.php">
                <div class="row">
            
                
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="matriAg" required>
                                    <option>Choisir un matricule</option>
                                    <?php
                                        $reqGetMatriculeAg = $db->prepare('SELECT matricule,nom_ag,postnom_ag FROM bdd_paie.t_agent WHERE activiter_ID = 01 ');
                                        $reqGetMatriculeAg->execute();
                                        while($resGetMatriculeAg = $reqGetMatriculeAg->fetch()){
                                            $matricule = $resGetMatriculeAg['matricule'];
                                            $nom = $resGetMatriculeAg['nom_ag'].' '.$resGetMatriculeAg['postnom_ag'] ?>
                                        <option value="<?php echo $matricule?>"> <?php echo $matricule.' | '.$nom;?> </option>
                                    <?php } ?>
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Compte</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="nomUtilisateur" placeholder="Adresse mail professionnel" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Création</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateCreationUser" value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dernière Modification</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateLastModifUser" value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div>
                       
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Statut</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="statut">
                                    <option>Choisir un statut</option>
                                    <option value="act"> Active </option>
                                    <option value="desac"> Désactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Rôle de l'Utilisateur</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="roleAg">
                                    <option>Choisir un Rôle</option>
                                    <?php
                                        $reqGetMatriculeAg = $db->prepare('SELECT * FROM bdd_paie.t_role_user');
                                        $reqGetMatriculeAg->execute();
                                        while($resGetMatriculeAg = $reqGetMatriculeAg->fetch()){
                                            $id_role = $resGetMatriculeAg['id_role']; 
                                            $libelle_role = $resGetMatriculeAg['libelle_role']; ?>
                                    <option value="<?php echo $id_role?>"> <?php echo $libelle_role;?> </option>
                                    <?php } ?>
                                </select>
                                
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Créer" name="creerUser" style="margin:15px;width:150px;">
                            <a href="accueil.php?page=Voir_Utilisateur" class="btn btn-round btn-warning col-sm-3" style="margin:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
            </form>   
            
        </div>
        <br><br><br><br><br>
    </div>
</div>
          
            