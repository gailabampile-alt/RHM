<?php
    //session_start();
    include_once('sys_connexion.php');
?>
<h3><i class="fa fa-angle-right"></i> IMPRESSION PRETS </h3>
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
            <form class="form-horizontal style-form" method="POST" action="traitement_print_pret.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-xl-8">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Devise</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" data-placeholder="Selectionnez une devise" name="devise" required>
                                    <option value=""> Choix Devise </option>
                                    <option value="CDF"> CDF </option>
                                    <option value="USD"> USD </option>
                                    <option value="CDF&USD"> CDF & USD </option>

                                </select>         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Siège</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="siege">
                                    <option value=""> Choix du Siège </option>
                                    <?php
                                        $reqGetSiege = $db->prepare('SELECT code_sieg,libelle_sieg FROM bdd_paie.t_siege');
                                        $reqGetSiege->execute();
                                        while($resGetSiege = $reqGetSiege->fetch()){
                                            $cod_sieg = $resGetSiege['code_sieg'];
                                            $lib_sieg = $resGetSiege['libelle_sieg']; ?>
                                        <option value="<?php echo(trim($cod_sieg))?>"> <?php echo $cod_sieg.' | '.$lib_sieg;?> </option>
                                    <?php } ?>
                                </select>         
                            </div>
                            
                            <!--div class="col-md-7 col-xs-11">
                                <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="01/2014" class="input-append date dpMonths">
                                    <input type="text" readonly="" value="01/2014" size="26" class="form-control" name="periode">
                                    <span class="input-group-btn add-on">
                                        <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                            </div-->
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Période</label>
                            <div class="col-md-8 col-xs-11">
                                <select class="form-control chzn-select" name="periode">
                                    <option value=""> Choix du Siège </option>
                                    <?php
                                        $reqGetSiege = $db->prepare('SELECT DISTINCT periodePret FROM bdd_paie.t_pret');
                                        $reqGetSiege->execute();
                                        while($resGetSiege = $reqGetSiege->fetch()){
                                            $cod_sieg = $resGetSiege['periodePret']; ?>
                                        <option value="<?php echo(trim($cod_sieg))?>"> <?php echo $cod_sieg;?> </option>
                                    <?php } ?>
                                </select> 
                                <!--div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="01/2014" class="input-append date dpMonths">
                                <input type="text" size="16" class="form-control" name="periode" >
                                <span class="input-group-btn add-on">
                                    <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div-->
                               
                            </div>
                        </div>
                        

                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Code Siège</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="code_siege">
                            </div>
                        </div-->

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
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-round btn-primary col-sm-3" id="printBy"
                                name="printBy" style="margin-left:15px;width:150px;">
                                <i class="fa fa-print"></i> Print by</button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <div class="form-group">
                            <a href="accueil.php?page=Voir_Prets"  class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                    
                </div>

            </form>
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</div>
          
            
