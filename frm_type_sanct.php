<?php
    //session_start();
    include_once('sys_connexion.php');
?>
<h3><i class="fa fa-angle-right"></i> TYPE SANCTION</h3>
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
            <form class="form-horizontal style-form" method="POST" action="add_type_sanct.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">LIBELLE SANCTION</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="lib_doc">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                                <?php
                                    $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                                    $reqGetNomUtilisateur->bindvalue(':id_user',$_SESSION['id_utilisateur']);
                                    $reqGetNomUtilisateur->execute();
                                    while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                                        $nomComplet = $resGetNomUtilisateur['nom_ag'].' '.$resGetNomUtilisateur['postnom_ag'].' '.$resGetNomUtilisateur['prenom_ag'];
                                    }
                                ?>
                                <input type="text" class="form-control" name="creerPar" value="<?php echo $nomComplet; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Le</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" name="" readonly>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <?php
                                    $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                                    $reqGetNomUtilisateur->bindvalue(':id_user',$_SESSION['id_utilisateur']);
                                    $reqGetNomUtilisateur->execute();
                                    while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                                        $nomComplet = $resGetNomUtilisateur['nom_ag'].' '.$resGetNomUtilisateur['postnom_ag'].' '.$resGetNomUtilisateur['prenom_ag'];
                                    }
                                ?>
                                <input type="text" class="form-control" name="modifierPar" value="<?php echo $nomComplet; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Le</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" readonly>
                            </div>
                        </div>
                       
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-round btn-primary col-sm-3"  name="add_type_sanct" style="margin-left:15px;width:150px;"><i class="fa fa-plus-circle"></i> Ajouter</button>
                            <a href="accueil.php?page=voir_Type_sanct" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br>
    </div>
</div>
          
            