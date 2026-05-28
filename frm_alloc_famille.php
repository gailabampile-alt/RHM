<?php
    //session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    $libpaie = '';
?>
<h3><i class="fa fa-angle-right"></i> Allocation Familial</h3>
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
            <form class="form-horizontal style-form" method="POST" action="add_alloc_famille.php">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Code Paie</label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez le Code paie"  name="cPaie" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option></option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT codePaie,libelle_codePaie FROM bdd_paie.t_codepaie');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $codepaie = $resGetcodepaie['codePaie'];
                                            $libpaie = $resGetcodepaie['libelle_codePaie']; ?>
                                    <option value="<?php echo $codepaie.'|'.$libpaie?>"> <?php echo $codepaie." | ".$libpaie;?> </option>
                                    
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type Allocation</label>
                            <div class="col-sm-8">
                                <select data-placeholder="Selectionnez le Type d'Allocation"  name="id_alloc" class="form-control chzn-select" tabindex="2">
                                    <option></option>
                                    <option value="E"> E | Enfant</option>
                                    <option value="M"> M | Marié</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Montant</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="montant_alloc">
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Le</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dateJr" value="<?php echo date('d-m-Y');?>" readonly> 
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
                            <label class="col-sm-3 control-label">Creer Par</label>
                            <div class="col-sm-8">
                                <?php 
                                    $creerPar = $_SESSION['id_utilisateur'];
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
                                <?php  ?>
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
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="update_alloc_familial"
                            name="add_alloc_familial" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i> Créer</button>
                        <a href="accueil.php?page=Voir_alloc_famille" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</div>
          
            