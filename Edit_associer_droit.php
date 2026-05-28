
?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
});
</script>
<h3><i class="fa fa-angle-right"></i> Associer droit/Profil</h3>
    $reqRole = $db->prepare('SELECT id_role FROM bdd_paie.t_role_user WHERE libelle_role = ?');
    $reqRole->execute([$roleSelectionne]);
    $roleData = $reqRole->fetch();
    $id_role_selectionne = $roleData['id_role'];

// Récuperé 
$reqRole1 = $db->prepare('SELECT creerPar, modifierPar, date_Creat, date_Modif FROM bdd_paie.droits_acces WHERE id_role= ?');
$reqRole1->execute([$id_role_selectionne]);
$roleData1 = $reqRole1->fetch();
$creerPar = $roleData1['creerPar'];
$modifierPar = $roleData1['modifierPar'];
$dateCreation = $roleData1['date_Creat'];
$dateModification = $roleData1['date_Modif'];

// Récupérer les pages associées à ce rôle
    $req = $db->prepare('
        SELECT page_id 
        FROM bdd_paie.droits_acces 
        WHERE id_role = ?
    ');
    $req->execute([$id_role_selectionne]);
    $pagesAssociees = $req->fetchAll(PDO::FETCH_COLUMN);
}

?>



<h3><i class="fa fa-angle-right"></i> Associer droit/Profil</h3>
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
          <br><br>
            <form class="form-horizontal style-form" method="post" action="update_associer_droit.php">
                <div class="row ">
                
                  <div class="col-lg-6 col-md-6 col-xl-6">
                    
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Role</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez le Code paie"  name="id_role" id="Product" readonly class="form-control chzn-select" tabindex="2">
                                    <option value="<?php echo $id_role_selectionne ?>"> <?php echo $roleSelectionne ?></option>
                                    
                                </select>
                            </div>
                    </div>
                        
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Page<s/trong></label>
                            <div class="col-sm-8">
                            
                    <select name="page[]" class="form-control chzn-select" multiple="multiple" tabindex="20">
                                <?php
                                $reqAllPages = $db->prepare('SELECT id_page, libelle FROM bdd_paie.t_pages');
                                $reqAllPages->execute();
                                while ($page = $reqAllPages->fetch()) {
                                 $selected = (isset($pagesAssociees) && in_array($page['id_page'], $pagesAssociees)) ? 'selected' : '';
                                 echo '<option value="' . $page['id_page'] . '" ' . $selected . '>' . htmlspecialchars($page['libelle']) . '</option>';
                                    }
                                ?>
                    </select>

                            </div>
                    </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">
                   <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Créer Par</strong></label>
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
                                
                                <input type="text" class="form-control" name="creer" value="<?php echo $nomComplet?>"  readonly>
                            <?php } ?>
                                
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="datecreer"  value="<?php echo $dateCreation?>" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                            <?php 
                                if($modifierPar == "sysAdmin" OR $modifierPar == NULL){
                                ?>
                                <input type="text" value="<?php echo $modifierPar;?>" class="form-control" readonly>
                                <?php 
                                }else{
                                $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                                WHERE id_user = :modifierPar');
                                $reqGetInfoUser->bindValue(':modifierPar',$modifierPar);
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
                            <label class="col-sm-3 control-label"><strong>Modifier le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="DateModif" value="<?php echo $dateModification?>" readonly>
                            </div>
                        </div>
                        
                        
                    </div>

                <div class="row mt">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-round btn-primary col-sm-3" value="" name="enreg" style="margin-left:25px;width:130px;"> <i class="fa fa-edit"></i> Modification</button>
                            <a href="accueil.php?page=voir_profil_droit" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
                
            </form>
            <?php include_once('confirm_modify_modal.php'); ?>
        </div>
    
    </div>
</div>
          
            