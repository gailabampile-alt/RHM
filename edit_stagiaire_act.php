<?php
    //session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    $id_stg = '';
    $nom = '';
    $postnom = '';
    $prenom = '';
    $sexe = '';
    $nivEtude = '';
    $siege = '';
    $dir = '';
    $dateFin = '';
    $dateFin = '';
    $histo = '';
    $creerPar = '';
    $modifierPar = '';
    $statut = '';
    $phone = '';
    $adresse = '';
    $pOrigin = '';
    $pNaiss_stg = '';
    
    $nomPhoto = '';
    $photoBinaire = '';
    $nomDoc = '';
    $documentBinaire = '';

    if(isset($_GET['id_stg'])){
        if(isset($_GET['st']) && $_GET['st'] === 'act'){
            $_SESSION['message'] = "Le stagiare a deja un stage en cours";
            $_SESSION['typeMsg'] = "warning";
            echo "<script>window.location.href='accueil.php?page=Voir_Stagiaire';</script>";
            exit();
        }
        $id_stg = $_GET['id_stg'];
        $req = $db->prepare('SELECT * FROM bdd_paie.t_stagiare WHERE id_stg = :id_stg');
        $req->bindValue(':id_stg',$id_stg);
        $req->execute();
        while ($res = $req->fetch()) {
            $id_stg = $res['id_stg'];
            $nom = $res['nom_stg'];
            $postnom = $res['postnom_stg'];
            $prenom = $res['prenom_stg'];
            $sexe = $res['sexe_stg'];
            $etatCiv = $res['etatCiv_stg'];
            $nivEtude = $res['nivEtude_stg'];
            $siege = $res['siege_stg'];
            $dir = $res['dir_stg'];
            $dateFin = $res['dateFin_stg'];
            $dateDebut_stg = $res['dateDebut_stage'];
            $dateNaiss = $res['dateNaiss'];
            $histo = $res['histo_stg'];
            $creerPar = $res['creerPar'];
            $modifierPar = $res['modifierPar'];
            $statut = $res['statut_ID'];
            $phone = $res['phone_stg'];
            $adresse = $res['adresse_stg'];
            $pOrigin = $res['pOrigi_stg'];
            $pNaiss_stg = $res['pNaiss_stg']; 
            $nomPhoto = $res['photo_stg'];
            $photoBinaire = $res['photo_byte_stg'];
            $nomDoc = $res['document'];
            $documentBinaire = $res['document_byte'];
        }
    }
?>
<h3><i class="fa fa-angle-right"></i> Stagiaires</h3>
<!-- BASIC FORM ELELEMNTS -->
<div class="row mt">
    <div class="col-lg-12">
        
        <div class="form-panel">
        <?php if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="alert">Ã—</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
            </div>
          <?php } ?>
            <form class="form-horizontal style-form" action="update_stagiaire.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                
                    <div class="col-lg-6 col-md-6 col-xl-6">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nom</label>
                            <div class="col-sm-8">
                                <input type="text" value="<?php echo $nom;?>" class="form-control" name="nom_stg" readonly>
                                <input type="hidden" value="<?php echo $id_stg;?>" class="form-control" name="id_stg">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Postnom</label>
                            <div class="col-sm-8">
                                <input type="text" value="<?php echo $postnom;?>" class="form-control" name="postnom_stg" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">PrÃ©nom</label>
                            <div class="col-sm-8">
                                <input type="text" value="<?php echo $prenom;?>" class="form-control" name="prenom_stg" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">CrÃ©er Par</label>
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

                    </div>

                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date DÃ©but</label>
                            <div class="col-md-8">
                                <input type="date" value="<?php echo $dateDebut_stg;?>" class="form-control" name="dateDebut_stg" required> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Fin</label>
                            <div class="col-md-8">
                                <input type="date" value="<?php echo $dateFin;?>" class="form-control" name="dateFin_stg">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Statut</label>
                            <div class="col-sm-2 text-center">
                                <select class="form-control" name="statut" style="width: auto;">
                                    <option value="<?php echo ($statut == "act") ?"act":"desac";?>"> <?php echo ($statut=="act")?"Activer":"DÃ©sactiver";?></option>
                                    <option value="<?php echo ($statut != "act") ?"act":"desac";?>"> <?php echo ($statut=="act")?"DÃ©sactiver":"Activer";?></option>
                                </select>
                            </div>
                        </div>
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
                       
                        
                    </div>
                
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Modifier" name="ModifStg_act" style="margin-left:15px;width:150px;">
                            <a href="accueil.php?page=Voir_Stagiaire" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
        
    </div>
</div>
          
            
