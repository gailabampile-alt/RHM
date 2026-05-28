?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
});
</script>
<h3><i class="fa fa-angle-right"></i> Modifier Type Sanction</h3>
        $id_typesanct = $_GET['id'];
        $req = $db->prepare('SELECT * FROM bdd_paie.t_type_sanct WHERE id_typesanct = :id_typesanct');
        $req->bindValue(':id_typesanct',$id_typesanct);
        $req->execute();
        while ($res = $req->fetch()) {
            $id_typesanct = $res['id_typesanct'];
            $libelle_typesanct = $res['libelle_typesanct'];
            $creerPar = $res['creerPar'];
            $modifierPar = $res['modifierPar'];
            $dateCreation = $res['datecreer'];
            $dateModif = $res['dateModif'];
            $statut = $res['statut'];
        }
    }
?>
<h3><i class="fa fa-angle-right"></i> TYPE SANCTION</h3>
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
            <form class="form-horizontal style-form" method="POST" action="update_type_sanct.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">LIBELLE SANCTION</label>
                            <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="id_typedoc" value="<?php echo $id_typesanct;?>">
                            <input type="text" class="form-control" name="lib_doc" value="<?php echo $libelle_typesanct; ?>">
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
                                    $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                                    $reqGetNomUtilisateur->bindvalue(':id_user',$modifierPar);
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
                                <input type="date" class="form-control" value="<?php echo $dateModif ;?>" readonly>
                            </div>
                        </div>
                       
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-round btn-primary col-sm-3"  name="update_type_sanct" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i>Modifier</button>
                            <a href="accueil.php?page=voir_Type_sanct" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
            <?php include_once('confirm_modify_modal.php'); ?>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br>
    </div>
</div>
          
            