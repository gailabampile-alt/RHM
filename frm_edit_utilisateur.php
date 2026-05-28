<?php
    include_once('sys_connexion.php');
    $id_userAmodif = '';
    $matricule = '';
    $compte = '';
    $creerPar = '';
    $modifierPar = '';
    $dateCreation = '';
    $dateModification = '';
    $statut = '';
    $role = '';
    if(isset($_GET['id'])){
        $id_userAmodif = $_GET['id'];
        $reqGetInfoUser = $db->prepare('SELECT * FROM bdd_paie.t_utilisateurs WHERE id_user= :id_user');
        $reqGetInfoUser->bindValue(':id_user',$id_userAmodif);
        $reqGetInfoUser->execute();
        while($resGetInfoUser = $reqGetInfoUser->fetch()){
            $matricule = $resGetInfoUser['agent_ID'];
            $compte = $resGetInfoUser['username'];
            $creerPar = $resGetInfoUser['creerPar'];
            $modifierPar = $resGetInfoUser['modifierPar'];
            $dateCreation = $resGetInfoUser['dateCreation'];
            $dateModification = $resGetInfoUser['dateLast_Modifi'];
            $statut = $resGetInfoUser['statut_ID'];
            $role = $resGetInfoUser['role_user_ID'];
        }
            
    }else{

    }
?>
<h3><i class="fa fa-angle-right"></i> Création Des Utilisateurs</h3>
<!-- BASIC FORM ELELEMNTS -->
<br><br><br>
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
            
                <form class="form-horizontal style-form" method="POST" action="add_utilisateur.php">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="matriAg" required>
                                    <option value="<?php echo $matricule?>"> <?php echo $matricule;?> </option>
                                    <?php
                                        $reqGetMatriculeAg = $db->prepare('SELECT * FROM bdd_paie.t_agent');
                                        $reqGetMatriculeAg->execute();
                                        while($resGetMatriculeAg = $reqGetMatriculeAg->fetch()){
                                            $matric = $resGetMatriculeAg['matricule']; ?>
                                    <option value="<?php echo $matric;?>"> <?php echo $matric;?> </option>
                                    
                                </select>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Compte</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="nomUtilisateur" value="<?php echo $compte; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Création</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateCreationUser" value="<?php echo $dateCreation;?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dernière Modification</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateLastModifUser" value="<?php echo $dateModification;?>" readonly>
                            </div>
                        </div>
                        <input type="submit" class="btn-primary form-control" value="Crée" name="creerUser">
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">CréerPar</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $creerPar;?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">ModifierPar</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $modifierPar;?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Statut</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="statut">
                                    <option value="<?php echo $statut;?>"> <?php echo ($statut == "Act") ? "Active" : "Désactive";?> </option>
                                    <?php echo ($statut == "Act") 
                                        ? '<option value="Desac"> Désactive</option>' 
                                        : '<option value="Act"> Active </option>';?>
                                    
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Role de l'Utilisateur</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="roleAg">
                                    <option>Choisir un matricule</option>
                                    <?php
                                        $reqGetMatriculeAg = $db->prepare('SELECT * FROM bdd_paie.t_role_user');
                                        $reqGetMatriculeAg->execute();
                                        while($resGetMatriculeAg = $reqGetMatriculeAg->fetch()){
                                            $id_role = $resGetMatriculeAg['id_role']; 
                                            $libelle_role = $resGetMatriculeAg['libelle_role']; ?>
                                    <option value="<?php echo $id_role?>"> <?php echo $libelle_role;?> </option>
                                    
                                </select>
                                <?php } ?>
                            </div>
                        </div>
                        <a href="accueil.php?page=Voir_Utilisateur" class="btn-warning form-control centered">Modifier / Supprimer</a>
                    </div>
                    
                </form>
                
            </div>
        </div>
        <br><br><br><br><br>
    </div>
</div>
          
            