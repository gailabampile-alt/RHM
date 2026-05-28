<?php
    include_once('sys_connexion.php');
    $id_carbu = '';
    $prix_litre = '';
    $id_taux = '';
    $val_taux = '';
    $dateCreation = '';
    $creerPar = '';
    $modifierPar = '';
    $statut = '';
    $nomComplet ='';
    if(isset($_GET['code_carbu'])){
        $id_carbu_last = $_GET['code_carbu'];
        $reqCarburant = $db->prepare('SELECT * FROM bdd_paie.t_carburant 
            INNER JOIN bdd_paie.t_taux ON bdd_paie.t_carburant.taux_ID = bdd_paie.t_taux.id_taux
            WHERE id_carb = :id_carb');
        $reqCarburant->bindValue(':id_carb',$id_carbu_last);
        $reqCarburant->execute();
        while($resCarburant=$reqCarburant->fetch()){
            $id_carb = $resCarburant['id_carb'];
            $prix_litre = $resCarburant['prix_litre'];
            $id_taux = $resCarburant['id_taux'];
            $montant_taux = $resCarburant['montantTaux'];
            $date_taux = $resCarburant['dateTaux'];
            $creerPar = $resCarburant['creerPar'];
            $modifierPar = $resCarburant['modifierPar'];
            $statut = $resCarburant['statut_ID'];
        }
    }
?>
<h3><i class="fa fa-angle-right"></i> Saisie Carburant</h3>
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
            <form class="form-horizontal style-form" method="POST" action="update_carburant.php">
                <div class="row centered">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-8">
                                <input type="date" value="<?php echo $id_carbu_last;?>" class="form-control" name="date_carbu">
                                <input type="hidden" value="<?php echo $id_carbu_last; ?>" class="form-control" name="id_carbu_last">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Prix du Litre</label>
                            <div class="col-sm-8">
                                <input type="text" value="<?php echo $prix_litre;?>" class="form-control" name="prix_litr">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Taux du jour</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="val_taux_jr" value="<?php echo $montant_taux; ?>" readonly>
                                <input type="hidden" name="id_taux_jr" value="<?php echo $id_taux; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xl-6">
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
                            <label class="col-sm-3 control-label">Date Création</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo date('d-m-Y');?>" readonly>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Equipe Compt</label>
                            <div class="col-sm-8">
                                <select name="eqCompt" class="form-control">
                                    <option value="0">Choix Equipe</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                </select>
                            </div>
                        </div-->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <?php 
                                    if($modifierPar == "sysAdmin"){
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
                    
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div-->
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addCarburant"
                            name="updateCarburant" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i> Modifier</button>
                        <a href="accueil.php?page=Voir_Carburant" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
            <?php include_once('confirm_modify_modal.php'); ?>
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</div>
          
            