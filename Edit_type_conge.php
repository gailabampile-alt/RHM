<?php
    //session_start();
    include_once('sys_connexion.php');
            $id_type_conge = '';
            $libelle_conge = '' ;
            $creerPar = '';
            $modifierPar = '';
            $dateCreation ='';
            $dateModif = '';
            $statut = '';

    if(isset($_GET['id'])){
        $id_type_conge = $_GET['id'];
        $req = $db->prepare('SELECT * FROM bdd_paie.t_typconge WHERE id_type_conge= :id_type_conge');
        $req->bindValue(':id_type_conge',$id_type_conge);
        $req->execute();
        while ($res = $req->fetch()) {
            $id_type_conge= $res['id_type_conge'];
            $libelle_conge = $res['libelle_conge'];
            $creerPar = $res['creerPar'];
            $modifierPar = $res['modifierPar'];
            $dateCreation = $res['datecreer'];
            $dateModif = $res['dateModif'];
            $statut = $res['statut'];
        }
    }
?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
});
</script>
<h3><i class="fa fa-angle-right"></i> TYPE CONGE</h3>
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
            <form class="form-horizontal style-form" method="POST" action="update_type_conge.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">LIBELLE CONGE</label>
                            <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="id_type_conge" value="<?php echo $id_type_conge;?>">
                            <input type="text" class="form-control" name="lib_conge" value="<?php echo $libelle_conge; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                            <?php 
                                if($creerPar == "sysAdmin"){
                                ?>
                                <input type="text" value="<?php echo $creerPar;?>" class="form-control" readonly>
                                <?php 
                                }else{
                                $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                                WHERE id_user = :creerPar');
                                $reqGetInfoUser->bindValue(':creerPar',$creerPar);
                                $reqGetInfoUser->execute();
                                while ($resGetInfoUser = $reqGetInfoUser->fetch()) {
                                    $nom_postnom = $resGetInfoUser['nom_ag'].' '.$resGetInfoUser['postnom_ag'];
                                    $prenom = ucfirst(strtolower($resGetInfoUser['prenom_ag']));
                                    $nomComplet = $nom_postnom.' '.$prenom;
                                }?>
                                <input type="text" value="<?php echo $nomComplet;?>" class="form-control" readonly>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Le</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo $dateCreation;?>"  readonly>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                            <?php
                          
                            if($modifierPar== null){
                            ?>
                            <input type="text" value="<?php echo  $modifierPar;?>" class="form-control" readonly>
                            <?php 
                            }else{
                                    $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                                    $reqGetNomUtilisateur->bindvalue(':id_user',$modifierPar);
                                    $reqGetNomUtilisateur->execute();
                                    while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                                        $nomComplet = $resGetNomUtilisateur['nom_ag'].' '.$resGetNomUtilisateur['postnom_ag'].' '.$resGetNomUtilisateur['prenom_ag'];
                                    }
                                ?>
                               
                            <input type="text" class="form-control" name="modifierPar" value="<?php echo $nomComplet; ?>" readonly>
                            <?php } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Le</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo $dateModif ;?>" readonly>
                            </div>
                        </div>
                       
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-round btn-primary col-sm-3"  name="update_type_conge" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i>Modifier</button>
                        <a href="accueil.php?page=voir_type_conge" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
            <?php include_once('confirm_modify_modal.php'); ?>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br>
    </div>
</div>
          
            