<?php
    //session_start();
    include_once('sys_connexion.php');

    $id_role = "";
    $libRole = "";
    $creerPar = "";
    $modifierPar = "";
    $statut = "";

    if (isset($_GET['codRole']) && !empty($_GET['codRole'])) {
        $reqRole = $db->prepare('SELECT * FROM bdd_paie.t_role_user WHERE id_role = :id_role');
        $reqRole->bindValue(':id_role', $_GET['codRole']);
        $reqRole->execute();
        if($resRole = $reqRole->fetch()){
            $id_role = $resRole['id_role'];
            $libRole = $resRole['libelle_role'];
            $creerPar = $resRole['creePar'];
            $modifierPar = $resRole['modifierPar'];
            $statut = $resRole['statut_ID'];
        }
    }
?>
<h3><i class="fa fa-angle-right"></i> Modifications Des Roles</h3>
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
            <form class="form-horizontal style-form" method="POST" action="update_roleUser.php">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Code</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $id_role;?>" name="code" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Libellé Role</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="libRole" value="<?php echo $libRole;?>" required>
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
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <?php
                                if ($creerPar == "sysAdmin") {
                                ?>
                                    <input type="text" value="<?php echo $creerPar; ?>" class="form-control" readonly>
                                <?php
                                } else {
                                    $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                                WHERE id_user = :modifierPar');
                                    $reqGetInfoUser->bindValue(':modifierPar', $creerPar);
                                    $reqGetInfoUser->execute();
                                    while ($resGetInfoUser = $reqGetInfoUser->fetch()) {
                                        $nom_postnom = $resGetInfoUser['nom_ag'] . ' ' . $resGetInfoUser['postnom_ag'];
                                        $prenom = ucfirst(strtolower($resGetInfoUser['prenom_ag']));
                                        $nomComplet = $nom_postnom . ' ' . $prenom;
                                    } ?>
                                    <input type="text" value="<?php echo $nomComplet; ?>" class="form-control" readonly>
                                <?php } ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <?php
                                if ($modifierPar == "sysAdmin") {
                                ?>
                                    <input type="text" value="<?php echo $modifierPar; ?>" class="form-control" readonly>
                                <?php
                                } else {
                                    $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                                WHERE id_user = :modifierPar');
                                    $reqGetInfoUser->bindValue(':modifierPar', $modifierPar);
                                    $reqGetInfoUser->execute();
                                    while ($resGetInfoUser = $reqGetInfoUser->fetch()) {
                                        $nom_postnom = $resGetInfoUser['nom_ag'] . ' ' . $resGetInfoUser['postnom_ag'];
                                        $prenom = ucfirst(strtolower($resGetInfoUser['prenom_ag']));
                                        $nomComplet = $nom_postnom . ' ' . $prenom;
                                    } ?>
                                    <input type="text" value="<?php echo $nomComplet; ?>" class="form-control" readonly>
                                <?php } ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Statut</label>
                            <div class="col-sm-8">
                                <input type="hidden" name="statut" value="desac">
                                <div class="col-sm-2 text-center">
                                    <label class="switch">
                                        <input type="checkbox" name="statut" value="act"
                                            <?php echo ($statut == "act") ? "checked" : ""; ?> data-toggle="switch" />
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-round btn-primary col-sm-3" value="Editer" name="update_roleUser" style="margin:15px;width:150px;"> <i class="fa fa-edit"></i> Editer</button>
                            <a href="accueil.php?page=Voir_roleUser" class="btn btn-round btn-warning col-sm-3" style="margin:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
            </form>   
            <?php include_once('confirm_modify_modal.php'); ?>
            
        </div>
        <br><br><br><br><br>
    </div>
</div>
                                    ?>
                                    <script>
                                    document.addEventListener('DOMContentLoaded', function(){
                                        var forms = document.querySelectorAll('form');
                                        forms.forEach(function(f){
                                            f.addEventListener('submit', function(e){
                                                if(!confirm('Voulez-vous modifier ?')){ e.preventDefault(); return false; }
                                            });
                                        });
                                    });
                                    </script>
          
            
