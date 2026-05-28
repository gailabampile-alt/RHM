<?php
    //session_start();
    include_once('sys_connexion.php');
    

?>

<h3><i class="fa fa-angle-right"></i> RELEVE COTISATION SYNDICALE</h3>
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
            <form class="form-horizontal style-form" method="POST" action="print_declarat_syndic.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-xl-8">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Siège</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="siege" required>
                                    <option value=""> Choisir du Siège </option>
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
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Période</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez une période" name="periode" required>
                                    <option></option>
                                        <?php
                                            $reqGetPeriode = $db->prepare("SELECT DISTINCT periode FROM bdd_paie.t_paie");
                                            //$reqGetMatriculeAgent->bindValue(':sexe_ag',"M");sexe_ag = :sexe_ag AND 
                                            //$reqGetPeriode->bindValue(':codeEiPaie',"999");
                                            $reqGetPeriode->execute();
                                                while($resGetPeriode = $reqGetPeriode->fetch()){
                                                    $periode = $resGetPeriode['periode']; ?>
                                                <option value="<?php echo $periode;?>"> <?php echo $periode;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <div class="form-group">
                            
                            <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addAgent" name="printBy" formtarget="_blank" style="margin-left:15px;width:150px;">
                                <i class="fa fa-print"></i> Imprimer/Siège
                            </button>

                        </div>
                    </div>
                   
                            <
                <a href="print_declarat_syndic_all.php?periode=<?=$periode?>" target="_blank" class="btn btn-round btn-warning col-sm-3"  style="margin-left:15px;width:150px;">
                    <i class="fa fa-print"></i> Imprimer/Tous
                </a>


                    
                </div>

            </form>
        </div>
        
    </div>
</div>





<h3><i class="fa fa-angle-right"></i> RELEVE RETENUE CNSS</h3>
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
            <form class="form-horizontal style-form" method="POST" action="print_declarat_cnss.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-xl-8">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Siège</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="siege" required>
                                    <option value=""> Choisir du Siège </option>
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
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Période</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez une période" name="periode" required>
                                    <option></option>
                                        <?php
                                            $reqGetPeriode = $db->prepare("SELECT DISTINCT periode FROM bdd_paie.t_paie");
                                            //$reqGetMatriculeAgent->bindValue(':sexe_ag',"M");sexe_ag = :sexe_ag AND 
                                            //$reqGetPeriode->bindValue(':codeEiPaie',"999");
                                            $reqGetPeriode->execute();
                                                while($resGetPeriode = $reqGetPeriode->fetch()){
                                                    $periode = $resGetPeriode['periode']; ?>
                                                <option value="<?php echo $periode;?>"> <?php echo $periode;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <div class="form-group">
                             <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addAgent" name="printBy" formtarget="_blank" style="margin-left:15px;width:150px;">
                                <i class="fa fa-print"></i> Imprimer/Siège
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <a href="print_declarat_cnss_all.php?periode=<?=$periode?>" target="_blank" class="btn btn-round btn-warning col-sm-3"  style="margin-left:15px;width:150px;">
                    <i class="fa fa-print"></i> Imprimer/Tous
                </a>
                    </div>
                    
                </div>

            </form>
        </div>
        
    </div>
</div>



<h3><i class="fa fa-angle-right"></i> RELEVE RETENUE IPR</h3>
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
            <form class="form-horizontal style-form" method="POST" action="print_declarat_ipr.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-xl-8">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Siège</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="siege" required>
                                    <option value=""> Choisir du Siège </option>
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
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Période</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez une période" name="periode" required>
                                    <option></option>
                                        <?php
                                            $reqGetPeriode = $db->prepare("SELECT DISTINCT periode FROM bdd_paie.t_paie");
                                            //$reqGetMatriculeAgent->bindValue(':sexe_ag',"M");sexe_ag = :sexe_ag AND 
                                            //$reqGetPeriode->bindValue(':codeEiPaie',"999");
                                            $reqGetPeriode->execute();
                                                while($resGetPeriode = $reqGetPeriode->fetch()){
                                                    $periode = $resGetPeriode['periode']; ?>
                                                <option value="<?php echo $periode;?>"> <?php echo $periode;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>
 
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addAgent" name="printBy" formtarget="_blank" style="margin-left:15px;width:150px;">
                                <i class="fa fa-print"></i> Imprimer/Siège
                            </button>
                        </div>
                    </div>
                    <a href="print_declarat_ipr_all.php?periode=<?=$periode?>" target="_blank" class="btn btn-round btn-warning col-sm-3"  style="margin-left:15px;width:150px;">
                    <i class="fa fa-print"></i> Imprimer/Tous
                </a>
                    
                </div>

            </form>
        </div>
        <br>
    </div>
</div>

          
            