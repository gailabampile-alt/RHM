<?php //session_start();
include_once('sys_connexion.php');
include_once('sys_fonction.php');
?>
<h3><i class="fa fa-angle-right"></i> Gestion De Carrière</h3>
<div class="row mt mb" style="margin: 15px;">
    <!-- /col-lg-12 -->
    <div class="col-lg-12 mt">
        <div class="row content-panel">
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?php echo ($_SESSION['typeMsg']); ?>">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <span><?php echo $_SESSION['message'];
                            unset($_SESSION['message']);
                            unset($_SESSION['typeMsg']); ?></span>
                </div>
            <?php } ?>
            <div class="panel-heading">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a data-toggle="tab" href="#siege">Siege</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#direction" class="contact-map">Direction</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#societe">Société</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#grade">Grade</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#fonction">fonction</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#activite">activité</a>
                    </li>
                    <!--li>
                        <a data-toggle="tab" href="#syndicat">syndicat</a>
                    </li-->
                </ul>
            </div>
            
 

            <!-- /panel-heading -->
            <div class="panel-body">
                <div class="tab-content">

                    <div id="siege" class="tab-pane active">
                        <div class="row" style="margin: 10px;">
                            <form class="form-horizontal style-form" method="POST" action="update_carriere.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Matricule</label>
                                            <div class="col-sm-8">
                                                <select class="form-control chzn-select"
                                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez un Agent" name="matric" required>
                                                    <option></option>
                                                    <?php $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent WHERE t_agent.activiter_ID="01"');
                                                    $reqGetMatriculeAgent->execute();
                                                    while ($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()) {
                                                        $matric = $resGetMatriculeAgent['matricule'];
                                                        $nomComplet = $resGetMatriculeAgent['nom_ag'] . ' ' . $resGetMatriculeAgent['postnom_ag']; ?>
                                                        <option value="<?php echo $matric; ?>"> <?php echo $matric . ' | ' . $nomComplet; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div id="infoSiege">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ancien Siège</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="lib_fonct">
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
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Date Début</label>
                                            <div class="col-sm-8">
                                                <input type="date" name="dateDebut" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nouveau Siège</label>
                                            <div class="col-sm-8">
                                                <select class="form-control chzn-select" name="nouv_siege" required>
                                                    <option value=""> Choisir du Siège </option>
                                                    <?php $reqGetSiege = $db->prepare('SELECT code_sieg,libelle_sieg FROM bdd_paie.t_siege');
                                                    $reqGetSiege->execute();
                                                    while ($resGetSiege = $reqGetSiege->fetch()) {
                                                        $cod_sieg = $resGetSiege['code_sieg'];
                                                        $lib_sieg = $resGetSiege['libelle_sieg']; ?>
                                                        <option value="<?php echo (trim($cod_sieg)) ?>"> <?php echo $cod_sieg . ' | ' . $lib_sieg; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Document</label>
                                            <div class="controls col-md-8">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <span class="btn btn-theme03 btn-file">
                                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Choix du fichier</span>
                                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                                        <input type="file" class="default" name="Fdoc">
                                                    </span>
                                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Statut</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" name="statutCode" checked="checked" data-toggle="switch" />
                                            </div>
                                        </div>
                                        <!--div class="form-group">
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
                                            <button type="submit" class="btn btn-round btn-primary col-sm-3"
                                                name="addNewSiege" style="margin-left:15px;width:150px;"><i class="fa fa-arrow-circle-o-right"></i> Mouvement</button>
                                            <a href="accueil.php?page=Siege_Agent" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-print"></i> Impression</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- /SIEGE -->
                    </div>
                    <!-- /tab-pane -->

                    <div id="direction" class="tab-pane active">
                        <div class="row" style="margin: 10px;">
                            <form class="form-horizontal style-form" method="POST" action="update_carriere.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Matricule</label>
                                            <div class="col-sm-8">
                                                <select onchange="showInfoDirection(this.value)" class="form-control chzn-select" data-placeholder="Selectionnez un Agent" name="matric" required>
                                                    <option></option>
                                                    <?php $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent WHERE t_agent.activiter_ID="01"');
                                                    $reqGetMatriculeAgent->execute();
                                                    while ($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()) {
                                                        $matric = $resGetMatriculeAgent['matricule'];
                                                        $nomComplet = $resGetMatriculeAgent['nom_ag'] . ' ' . $resGetMatriculeAgent['postnom_ag']; ?>
                                                        <option value="<?php echo $matric; ?>"> <?php echo $matric . ' | ' . $nomComplet; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div id="infoDirection">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ancienne Direction</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control">
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
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Date Début</label>
                                            <div class="col-sm-8">
                                                <input type="date" name="dateDebut" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nouvelle Direction</label>
                                            <div class="col-sm-8">
                                                <select class="form-control chzn-select" name="nouv_direction" required>
                                                    <option> Choisir Direction </option>
                                                    <?php $reqGetDirection = $db->prepare('SELECT code_dir,libelle_dir FROM bdd_paie.t_direction WHERE statut_ID="act"');
                                                    $reqGetDirection->execute();
                                                    while ($resGetDirection = $reqGetDirection->fetch()) {
                                                        $cod_dir = $resGetDirection['code_dir'];
                                                        $lib_dir = $resGetDirection['libelle_dir']; ?>
                                                        <option value="<?php echo $cod_dir; ?>"> <?php echo $lib_dir; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Document</label>
                                            <div class="controls col-md-8">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <span class="btn btn-theme03 btn-file">
                                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Choix du fichier</span>
                                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                                        <input type="file" class="default" name="Fdoc">
                                                    </span>
                                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Statut</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" name="statutCode" data-toggle="switch" checked="checked" />
                                            </div>
                                        </div>
                                        <!--div class="form-group">
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
                                            <button type="submit" class="btn btn-round btn-primary col-sm-3"
                                                name="addNewDirection" style="margin-left:15px;width:150px;"><i class="fa fa-arrow-circle-o-right"></i> Mouvement</button>
                                            <a href="accueil.php?page=Direction_Agent" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-print"></i> Impression</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- /DIRECTION -->
                    </div>

                    <div id="societe" class="tab-pane active">
                        <div class="row" style="margin: 10px;">
                            <form class="form-horizontal style-form" method="POST" action="update_carriere.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Matricule</label>
                                            <div class="col-sm-8">
                                                <select onchange="showInfoSociete(this.value)" class="form-control chzn-select" data-placeholder="Selectionnez un Agent" name="matric" required>
                                                    <option></option>
                                                    <?php $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent WHERE t_agent.activiter_ID="01"');
                                                    $reqGetMatriculeAgent->execute();
                                                    while ($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()) {
                                                        $matric = $resGetMatriculeAgent['matricule'];
                                                        $nomComplet = $resGetMatriculeAgent['nom_ag'] . ' ' . $resGetMatriculeAgent['postnom_ag']; ?>
                                                        <option value="<?php echo $matric; ?>"> <?php echo $matric . ' | ' . $nomComplet; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div id="infoSociete">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ancienne Société</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="lib_fonct">
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
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Date Début</label>
                                            <div class="col-sm-8">
                                                <input type="date" name="dateDebut" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nouvelle Société</label>
                                            <div class="col-sm-8">
                                                <select required class="form-control chzn-select" name="nouv_societe">
                                                    <option value=""> Choisir La Société </option>
                                                    <?php $reqGetSociete = $db->prepare('SELECT code_soc,libelle_soc FROM bdd_paie.t_societe WHERE statut_ID="act"');
                                                    $reqGetSociete->execute();
                                                    while ($resGetSociete = $reqGetSociete->fetch()) {
                                                        $cod_soc = $resGetSociete['code_soc'];
                                                        $lib_soc = $resGetSociete['libelle_soc']; ?>
                                                        <option value="<?php echo $cod_soc; ?>"> <?php echo $cod_soc . ' | ' . $lib_soc; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Document</label>
                                            <div class="controls col-md-8">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <span class="btn btn-theme03 btn-file">
                                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Choix du fichier</span>
                                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                                        <input type="file" class="default" name="Fdoc">
                                                    </span>
                                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Statut</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" name="statutCode" data-toggle="switch" checked="checked" />
                                            </div>
                                        </div>
                                        <!--div class="form-group">
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
                                            <button type="submit" class="btn btn-round btn-primary col-sm-3" id=""
                                                name="addNewSociete" style="margin-left:15px;width:150px;"><i class="fa fa-arrow-circle-o-right"></i> Mouvement</button>
                                            <a href="accueil.php?page=Societe_Agent" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- /SOCIETE -->
                    </div>


                    <div id="grade" class="tab-pane active">
                        <div class="row" style="margin: 10px;">
                            <form class="form-horizontal style-form" method="POST" action="update_carriere.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Matricule</label>
                                            <div class="col-sm-8">
                                                <select onchange="showInfoGrade(this.value)" class="form-control chzn-select" data-placeholder="Selectionnez un Agent" name="matric" required>
                                                    <option></option>
                                                    <?php $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent WHERE t_agent.activiter_ID="01"');
                                                    $reqGetMatriculeAgent->execute();
                                                    while ($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()) {
                                                        $matric = $resGetMatriculeAgent['matricule'];
                                                        $nomComplet = $resGetMatriculeAgent['nom_ag'] . ' ' . $resGetMatriculeAgent['postnom_ag']; ?>
                                                        <option value="<?php echo $matric; ?>"> <?php echo $matric . ' | ' . $nomComplet; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div id="infoGrade">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ancien Grade</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="lib_fonct">
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
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Date Début</label>
                                            <div class="col-sm-8">
                                                <input type="date" name="dateDebut" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nouveau Grade</label>
                                            <div class="col-sm-8">
                                                <select class="form-control chzn-select" name="nouv_grade" required>
                                                    <option value=""> Choisir un Grade </option>
                                                    <?php $reqGetGrade = $db->prepare('SELECT code_grade,libelle_grade FROM bdd_paie.t_grade');
                                                    $reqGetGrade->execute();
                                                    while ($resGetGrade = $reqGetGrade->fetch()) {
                                                        $cod_gr = $resGetGrade['code_grade'];
                                                        $lib_gr = $resGetGrade['libelle_grade']; ?>
                                                        <option value="<?php echo $cod_gr ?>"> <?php echo $cod_gr . ' | ' . $lib_gr; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Document</label>
                                            <div class="controls col-md-8">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <span class="btn btn-theme03 btn-file">
                                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Choix du fichier</span>
                                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                                        <input type="file" class="default" name="Fdoc">
                                                    </span>
                                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Statut</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" name="statutCode" data-toggle="switch" checked="checked" />
                                            </div>
                                        </div>
                                        <!--div class="form-group">
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
                                            <button type="submit" class="btn btn-round btn-primary col-sm-3" id=""
                                                name="addNewGrade" style="margin-left:15px;width:150px;"><i class="fa fa-arrow-circle-o-right"></i> Mouvement</button>
                                            <a href="accueil.php?page=Grade_Agent" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- /GRADE -->
                    </div>

                    <div id="fonction" class="tab-pane active">
                        <div class="row" style="margin: 10px;">
                            <form class="form-horizontal style-form" method="POST" action="update_carriere.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Matricule</label>
                                            <div class="col-sm-8">
                                                <select onchange="showInfoFonction(this.value)" class="form-control chzn-select" data-placeholder="Selectionnez un Agent" name="matric" required>
                                                    <option></option>
                                                    <?php $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent WHERE t_agent.activiter_ID="01"');
                                                    $reqGetMatriculeAgent->execute();
                                                    while ($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()) {
                                                        $matric = $resGetMatriculeAgent['matricule'];
                                                        $nomComplet = $resGetMatriculeAgent['nom_ag'] . ' ' . $resGetMatriculeAgent['postnom_ag']; ?>
                                                        <option value="<?php echo $matric; ?>"> <?php echo $matric . ' | ' . $nomComplet; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div id="infoFonction">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ancienne Fonction</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="lib_fonct">
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
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Date Début</label>
                                            <div class="col-sm-8">
                                                <input type="date" name="dateDebut" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nouvelle Fonction</label>
                                            <div class="col-sm-8">
                                                <select class="form-control chzn-select" name="nouv_fonction" required>
                                                    <option value=""> Choisir une Fonction </option>
                                                    <?php $reqGetFonction = $db->prepare('SELECT codeFonct,libelleFonct FROM bdd_paie.t_fonction');
                                                    $reqGetFonction->execute();
                                                    while ($resGetFonction = $reqGetFonction->fetch()) {
                                                        $cod_fonct = $resGetFonction['codeFonct'];
                                                        $lib_fonct = $resGetFonction['libelleFonct']; ?>
                                                        <option value="<?php echo (trim($cod_fonct)) ?>"> <?php echo $cod_fonct . ' | ' . $lib_fonct; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Document</label>
                                            <div class="controls col-md-8">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <span class="btn btn-theme03 btn-file">
                                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Choix du fichier</span>
                                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                                        <input type="file" class="default" name="Fdoc">
                                                    </span>
                                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Statut</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" name="statutCode" data-toggle="switch" checked="checked" />
                                            </div>
                                        </div>
                                        <!--div class="form-group">
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
                                                name="addNewFonction" style="margin-left:15px;width:150px;"><i class="fa fa-arrow-circle-o-right"></i> Mouvement</button>
                                            <a href="accueil.php?page=Fonction_Agent" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- /FONCTION -->
                    </div>

                    <div id="activite" class="tab-pane active">
                        <div class="row" style="margin: 10px;">
                            <form class="form-horizontal style-form" method="POST" action="update_carriere.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Matricule</label>
                                            <div class="col-sm-8">
                                                <select onchange="showInfoActivite(this.value)" class="form-control chzn-select" data-placeholder="Selectionnez un Agent" name="matric" required>
                                                    <option></option>
                                                    <?php $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent ');
                                                    $reqGetMatriculeAgent->execute();
                                                    while ($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()) {
                                                        $matric = $resGetMatriculeAgent['matricule'];
                                                        $nomComplet = $resGetMatriculeAgent['nom_ag'] . ' ' . $resGetMatriculeAgent['postnom_ag']; ?>
                                                        <option value="<?php echo $matric; ?>"> <?php echo $matric . ' | ' . $nomComplet; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div id="infoActivite">

                                            <div class="form-group" id="infoFonction">
                                                <label class="col-sm-3 control-label">Ancienne Activité</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="lib_fonct">
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
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Date Début</label>
                                            <div class="col-sm-8">
                                                <input type="date" name="dateDebut" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nouvelle Activité</label>
                                            <div class="col-sm-8">
                                                <select class="form-control chzn-select" name="nouv_activite" required>
                                                    <option value=""> Choisir l'Activiter </option>
                                                    <?php $reqGetActiviter = $db->prepare('SELECT code_activ,libelle_activ FROM bdd_paie.t_activite');
                                                    $reqGetActiviter->execute();
                                                    while ($resGetActiviter = $reqGetActiviter->fetch()) {
                                                        $cod_activ = $resGetActiviter['code_activ'];
                                                        $lib_activ = $resGetActiviter['libelle_activ']; ?>
                                                        <option value="<?php echo $cod_activ; ?>"> <?php echo validation_donnees($lib_activ); ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Document</label>
                                            <div class="controls col-md-8">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <span class="btn btn-theme03 btn-file">
                                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Choix du fichier</span>
                                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                                        <input type="file" class="default" name="Fdoc">
                                                    </span>
                                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Statut</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" name="statutCode" data-toggle="switch" checked="checked" />
                                            </div>
                                        </div>
                                        <!--div class="form-group">
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
                                            <button type="submit" class="btn btn-round btn-primary col-sm-3" id=""
                                                name="addNewActivite" style="margin-left:15px;width:150px;"><i class="fa fa-arrow-circle-o-right"></i> Mouvement</button>
                                            <a href="accueil.php?page=Activite_Agent" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- /SYNDICAT -->
                    </div>


                    <div id="syndicat" class="tab-pane active">
                        <div class="row" style="margin: 10px;">
                            <form class="form-horizontal style-form" method="POST" action="update_carriere.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Matricule</label>
                                            <div class="col-sm-8">
                                                <select onchange="showInfoSyndicat(this.value)" class="form-control chzn-select" data-placeholder="Selectionnez un Agent" name="matric" required>
                                                    <option></option>
                                                    <?php $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent WHERE t_agent.activiter_ID="01"');
                                                    $reqGetMatriculeAgent->execute();
                                                    while ($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()) {
                                                        $matric = $resGetMatriculeAgent['matricule'];
                                                        $nomComplet = $resGetMatriculeAgent['nom_ag'] . ' ' . $resGetMatriculeAgent['postnom_ag']; ?>
                                                        <option value="<?php echo $matric; ?>"> <?php echo $matric . ' | ' . $nomComplet; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div id="infoSyndicat">

                                            <div class="form-group" id="infoFonction">
                                                <label class="col-sm-3 control-label">Ancien Syndicat</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="lib_fonct">
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
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-lg-6 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Date Début</label>
                                            <div class="col-sm-8">
                                                <input type="date" name="dateDebut" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nouveau Syndicat</label>
                                            <div class="col-sm-8">
                                                <select class="form-control chzn-select" name="nouv_syndicat" required>
                                                    <option value=""> Choisir du Syndicat </option>
                                                    <?php $reqGetSyndicat = $db->prepare('SELECT code_syndi,libelle_syndi FROM bdd_paie.t_syndicat');
                                                    $reqGetSyndicat->execute();
                                                    while ($resGetSyndicat = $reqGetSyndicat->fetch()) {
                                                        $cod_syndi = $resGetSyndicat['code_syndi'];
                                                        $lib_syndi = $resGetSyndicat['libelle_syndi'];  ?>
                                                        <option value="<?php echo $cod_syndi; ?>"> <?php echo $lib_syndi; ?> </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Document</label>
                                            <div class="controls col-md-8">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <span class="btn btn-theme03 btn-file">
                                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Choix du fichier</span>
                                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                                        <input type="file" class="default" name="Fdoc">
                                                    </span>
                                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Statut</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" name="statutCode" data-toggle="switch" checked="checked" />
                                            </div>
                                        </div>
                                        <!--div class="form-group">
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
                                            <button type="submit" class="btn btn-round btn-primary col-sm-3" id=""
                                                name="addNewSyndicat" style="margin-left:15px;width:150px;"><i class="fa fa-arrow-circle-o-right"></i> Mouvement</button>
                                            <a href="accueil.php?page=Syndicat_Agent" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- /SYNDICAT -->
                    </div>


                    <!-- /tab-pane -->
                </div>
                <!-- /tab-content -->
            </div>
            <!-- /panel-body -->
        </div>
        <!-- /col-lg-12 -->
    </div>
    <!-- /row -->

    <script>
        function showInfoFonction(str) {
            if (str == "") {
                document.getElementById("infoFonction").innerHTML = "";

                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("infoFonction").innerHTML = this.responseText;

                    }
                };
                //xmlhttp.open("GET","show_info_carriere.php?info="+str, true);
                xmlhttp.open("GET", "show_info_carriere.php?info=" + str + "&valeur=fonction", true);
                xmlhttp.send();
            }

        }

        function showInfoSiege(str) {
            if (str == "") {
                document.getElementById("infoSiege").innerHTML = "";

                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("infoSiege").innerHTML = this.responseText;

                    }
                };
                //xmlhttp.open("GET","show_info_carriere.php?info="+str, true);
                xmlhttp.open("GET", "show_info_carriere.php?info=" + str + "&valeur=siege", true);
                xmlhttp.send();
            }

        }

        function showInfoDirection(str) {
            if (str == "") {
                document.getElementById("infoDirection").innerHTML = "";

                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("infoDirection").innerHTML = this.responseText;

                    }
                };
                //xmlhttp.open("GET","show_info_carriere.php?info="+str, true);
                xmlhttp.open("GET", "show_info_carriere.php?info=" + str + "&valeur=direction", true);
                xmlhttp.send();
            }

        }

        function showInfoSociete(str) {
            if (str == "") {
                document.getElementById("infoSociete").innerHTML = "";

                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("infoSociete").innerHTML = this.responseText;

                    }
                };
                //xmlhttp.open("GET","show_info_carriere.php?info="+str, true);
                xmlhttp.open("GET", "show_info_carriere.php?info=" + str + "&valeur=societe", true);
                xmlhttp.send();
            }

        }

        function showInfoGrade(str) {
            if (str == "") {
                document.getElementById("infoGrade").innerHTML = "";

                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("infoGrade").innerHTML = this.responseText;

                    }
                };
                //xmlhttp.open("GET","show_info_carriere.php?info="+str, true);
                xmlhttp.open("GET", "show_info_carriere.php?info=" + str + "&valeur=grade", true);
                xmlhttp.send();
            }

        }

        function showInfoActivite(str) {
            if (str == "") {
                document.getElementById("infoActivite").innerHTML = "";

                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("infoActivite").innerHTML = this.responseText;

                    }
                };
                //xmlhttp.open("GET","show_info_carriere.php?info="+str, true);
                xmlhttp.open("GET", "show_info_carriere.php?info=" + str + "&valeur=activite", true);
                xmlhttp.send();
            }

        }

        function showInfoSyndicat(str) {
            if (str == "") {
                document.getElementById("infoSyndicat").innerHTML = "";

                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("infoSyndicat").innerHTML = this.responseText;

                    }
                };
                //xmlhttp.open("GET","show_info_carriere.php?info="+str, true);
                xmlhttp.open("GET", "show_info_carriere.php?info=" + str + "&valeur=syndicat", true);
                xmlhttp.send();
            }

        }

</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll('.nav-tabs a[data-toggle="tab"], .nav-tabs a[data-bs-toggle="tab"]');
  const panes = document.querySelectorAll('.tab-pane');

  panes.forEach(pane => pane.classList.remove('active', 'show'));
  if (panes.length > 0) {
    panes[0].classList.add('active', 'show');
  }

  tabs.forEach(tab => tab.classList.remove('active'));
  if (tabs.length > 0) {
    tabs[0].classList.add('active');
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', function (e) {
      e.preventDefault();
      tabs.forEach(t => t.classList.remove('active'));
      panes.forEach(p => p.classList.remove('active', 'show'));

      this.classList.add('active');
      const targetId = this.getAttribute('href');
      const targetPane = document.querySelector(targetId);
      if (targetPane) {
        targetPane.classList.add('active', 'show');
      }
    });
  });
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
  $(".chzn-select").chosen({width: "100%"});

  // Réactivation des fonctions onchange
  $(".chzn-select").on("change", function () {
    const selectedValue = $(this).val();
    const onchangeAttr = $(this).attr("onchange");
    if (onchangeAttr && selectedValue) {
      eval(onchangeAttr.replace("this.value", `'${selectedValue}'`));
    }
  });
});
</script>

