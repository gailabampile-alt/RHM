<?php
    include_once('sys_connexion.php');
?>
<h3><i class="fa fa-angle-right"></i> IMPRESSION BULLETINS</h3>

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

            <!-- FORMULAIRE UNIQUE -->
            <form class="form-horizontal style-form" method="GET" action="add_print_by.php" target="_blank">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-xl-8">
                        
                        <!-- Matricule -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    data-placeholder="Selectionnez un Agent" name="matric">
                                    <option></option>
                                    <?php
                                        $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent WHERE activiter_ID = :activiter_ID');
                                        $reqGetMatriculeAgent->bindValue(':activiter_ID',"01");
                                        $reqGetMatriculeAgent->execute();
                                        while($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()){
                                            $matric = $resGetMatriculeAgent['matricule']; 
                                            $nomComplet = $resGetMatriculeAgent['nom_ag'].' '.$resGetMatriculeAgent['postnom_ag'];?>
                                            <option value="<?php echo $matric;?>"> 
                                                <?php echo $matric.' | '.$nomComplet;?> 
                                            </option>
                                    <?php } ?>   
                                </select>         
                            </div>
                        </div>

                        <!-- Période -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Période</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    data-placeholder="Selectionnez une période" name="periode" >
                                    <option></option>
                                    <?php
                                        $reqGetPeriode = $db->prepare("SELECT DISTINCT periode FROM bdd_paie.t_paie");
                                        $reqGetPeriode->execute();
                                        while($resGetPeriode = $reqGetPeriode->fetch()){
                                            $periode = $resGetPeriode['periode']; ?>
                                            <option value="<?php echo $periode;?>"> 
                                                <?php echo $periode;?> 
                                            </option>
                                    <?php } ?>   
                                    
                                </select>         
                            </div>
                        </div>

                        <!-- Type Paie -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type Paie</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    data-placeholder="Selectionnez un type paie" name="type_paie" >
                                    <option></option>
                                    <?php
                                        $reqGetType = $db->prepare("SELECT DISTINCT type_paie FROM bdd_paie.t_paie");
                                        $reqGetType->execute();
                                        while($resGetType = $reqGetType->fetch()){
                                            $type_paie = $resGetType['type_paie']; ?>
                                            <option value="<?php echo $type_paie;?>"> 
                                                <?php if ($type_paie=='N') {
                                                    echo 'Normal';
                                                }elseif ($type_paie=='R') {
                                                    echo 'Rentrée scolaire';
                                                }  elseif ($type_paie=='V') {
                                                    echo 'Rente Viagere';
                                                } else  {
                                                    echo 'Grattification';
                                                }
                                                 ?> 
                                            </option>
                                    <?php } ?>   
                                    
                                   
                                </select>         
                            </div>
                        </div>

                        <!-- Code Siège -->
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Siège</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez un siège" name="code_siege" >
                                    <option></option>
                                        <?php
                                            $reqGetPeriode = $db->prepare("SELECT * FROM bdd_paie.t_siege");
                                            
                                            $reqGetPeriode->execute();
                                                while($resGetPeriode = $reqGetPeriode->fetch()){
                                                    $codesiege = $resGetPeriode['code_sieg']; 
                                                    $libsiege = $resGetPeriode['libelle_sieg']; ?>
                                                <option value="<?php echo $codesiege;?>"> <?php echo $codesiege;?> | <?php echo $libsiege;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Code Siège</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="code_siege">
                            </div>
                        </div-->
                    </div>

                    <!-- Print by -->
                    <div class="col-lg-4 col-md-4 col-xl-4">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Impression</label>
                            <div class="col-sm-7">
                                <select class="form-control" name ="Print_by" required>
                                    <option value="">-- Choisir --</option>
                                    <option value="I">Individuel</option>
                                    <option value="S">Par Siège</option>
                                    <option value="T">Tous les Sièges</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Format</label>
                            <div class="col-sm-7">
                                <select class="form-control" name="format" required>
                                    <option value="">-- Choisir --</option>
                                    <option value="html">HTML</option>
                                    <option value="pdf">PDF</option>
                                </select>
                            </div>
                        </div>

                        <!-- Bouton Afficher -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-round btn-success col-sm-6">
                                📄 Afficher Bulletin
                            </button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
        <br><br><br><br><br><br><br>
    </div>
</div>


<script>
const form = document.querySelector('form');
const matricule = document.querySelector('[name="matric"]');
const codeSiege = document.querySelector('[name="code_siege"]');
const periode = document.querySelector('[name="periode"]');
const typePaie = document.querySelector('[name="type_paie"]');
const printBy = document.querySelector('[name="Print_by"]');
const formatSelect = document.querySelector('[name="format"]');

form.onsubmit = function(e) {
    if (!periode.value || !typePaie.value || !printBy.value || !formatSelect.value) {
        alert("⚠️ Veuillez remplir Période, Type Paie, Impression et Format !");
        e.preventDefault();
        return;
    }

    if (printBy.value === "I" && !matricule.value) {
        alert("⚠️ Vous devez sélectionner un Agent (Matricule) !");
        e.preventDefault();
        return;
    }

    if (printBy.value === "S" && !codeSiege.value) {
        alert("⚠️ Vous devez saisir un Code Siège !");
        e.preventDefault();
        return;
    }
};
</script>