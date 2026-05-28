<?php
    //session_start();
    include_once('sys_connexion.php');
?>
<h3><i class="fa fa-angle-right"></i> Prime Diplôme</h3>
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
            <form class="form-horizontal style-form" method="POST" action="add_prime_diplome.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Niveau Etude</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" data-placeholder="Selectionnez un niveau d'étude"name="nivEtude" required>
                                    <option></option>
                                        <?php
                                            $reqGetNivEtude = $db->prepare('SELECT id_niv_etud,libelle_niv_etud FROM bdd_paie.t_niv_etud');
                                            $reqGetNivEtude->execute();
                                                while($resGetNivEtude = $reqGetNivEtude->fetch()){
                                                    $id = $resGetNivEtude['id_niv_etud']; 
                                                    $lib = $resGetNivEtude['libelle_niv_etud'];?>
                                                <option value="<?php echo $id;?>"> <?php echo $id.' | '.$lib;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dévise</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" data-placeholder="Selectionnez une dévise"name="devise" required>
                                    <option></option>
                                        <?php
                                            $reqGetDevise = $db->prepare('SELECT code_monnaie,libelle_monnaie FROM bdd_paie.monnaie');
                                            $reqGetDevise->execute();
                                                while($resGetDevise = $reqGetDevise->fetch()){
                                                    $code = $resGetDevise['code_monnaie']; 
                                                    $lib = $resGetDevise['libelle_monnaie'];?>
                                                <option value="<?php echo $code;?>"> <?php echo $code.' | '.$lib;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Montant</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="montant">
                            </div>
                        </div>

                        

                    
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                                <?php /*
                                    $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                                    $reqGetNomUtilisateur->bindvalue(':id_user',$_SESSION['id_utilisateur']);
                                    $reqGetNomUtilisateur->execute();
                                    while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                                        $nomComplet = $resGetNomUtilisateur['nom_ag'].' '.$resGetNomUtilisateur['postnom_ag'].' '.$resGetNomUtilisateur['prenom_ag'];
                                    }
                                ?>
                                <input type="text" class="form-control" name="creerPar" value="<?php echo $nomComplet; */?>" readonly>
                            </div>
                        </div-->
                        
                        
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xl-6">
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
                                <input type="text" class="form-control" name="creerPar" value="<?php echo $nomComplet; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Le</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" readonly>
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
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
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
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addAgent"
                            name="addPrime_ag" style="margin-left:15px;width:150px;"><i class="fa fa-plus-circle"></i> Ajouter</button>
                            <a href="accueil.php?page=Voir_PrimeDiplome" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</div>
          
            