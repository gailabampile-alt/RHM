<?php
    require_once('sys_connexion.php');
    require_once('sys_fonction.php');

    
$lib_fonct    = '';   // valeur par défaut
$creerPar     = '';
$modifierPar  = '';
$nomComplet   = '';   // si tu l'utilises
$nomCompletCreer = '';
$nomCompletModif = '';


    if(isset($_GET['info']) && isset($_GET['valeur']) && $_GET['valeur']=="siege"){
        $req = $db->prepare("SELECT detail_agent_siege.creerPar,detail_agent_siege.modifierPar,t_siege.libelle_sieg
        FROM bdd_paie.detail_agent_siege INNER JOIN bdd_paie.t_siege ON detail_agent_siege.siege_ID = t_siege.code_sieg 
            WHERE detail_agent_siege.statut_ID = 'act' AND detail_agent_siege.agent_ID = :matricule ");
        $req->bindValue(':matricule',$_GET['info']);
        $req->execute();
        while ($res = $req->fetch()) {
            $lib_fonct = $res['libelle_sieg'];
            $creerPar = $res['creerPar'];
            $modifierPar = $res['modifierPar'];
        }
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label">Ancien Siège</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="lib_fonct" value="<?php echo $lib_fonct;?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">CréerPar</label>
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
    <?php 
    }elseif(isset($_GET['info']) && isset($_GET['valeur']) && $_GET['valeur']=="direction"){
        $req = $db->prepare("SELECT detail_agent_direction.affecterPar,detail_agent_direction.modifierPar,t_direction.libelle_dir
        FROM bdd_paie.detail_agent_direction INNER JOIN bdd_paie.t_direction ON detail_agent_direction.direction_ID = t_direction.code_dir  
            WHERE detail_agent_direction.statut_ID = 'act' AND detail_agent_direction.agent_ID = :matricule ");
        $req->bindValue(':matricule',$_GET['info']);
        $req->execute();
        while ($res = $req->fetch()) {
            $lib_fonct = $res['libelle_dir'];
            $creerPar = $res['affecterPar'];
            $modifierPar = $res['modifierPar'];
        }
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label">Ancienne Direction</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="lib_fonct" value="<?php echo $lib_fonct;?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">CréerPar</label>
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
    <?php 
    }elseif(isset($_GET['info']) && isset($_GET['valeur']) && $_GET['valeur']=="societe"){
        $req = $db->prepare("SELECT detail_agent_societe.creerPar,detail_agent_societe.modifierPar,t_societe.libelle_soc
        FROM bdd_paie.detail_agent_societe INNER JOIN bdd_paie.t_societe ON detail_agent_societe.societe_ID = t_societe.code_soc 
            WHERE detail_agent_societe.statut_ID = 'act' AND detail_agent_societe.agent_ID = :matricule ");
        $req->bindValue(':matricule',$_GET['info']);
        $req->execute();
        while ($res = $req->fetch()) {
            $lib_fonct = $res['libelle_soc'];
            $creerPar = $res['creerPar'];
            $modifierPar = $res['modifierPar'];
        }
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label">Ancienne Société</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="lib_fonct" value="<?php echo $lib_fonct;?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">CréerPar</label>
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
    <?php 
    }elseif(isset($_GET['info']) && isset($_GET['valeur']) && $_GET['valeur']=="grade"){
        $req = $db->prepare("SELECT detail_agent_grade.creerPar,detail_agent_grade.modifierPar,t_grade.libelle_grade
        FROM bdd_paie.detail_agent_grade INNER JOIN bdd_paie.t_grade ON detail_agent_grade.grade_ID = t_grade.code_grade
            WHERE detail_agent_grade.statut_ID = 'act' AND detail_agent_grade.agent_ID = :matricule ");
        $req->bindValue(':matricule',$_GET['info']);
        $req->execute();
        while ($res = $req->fetch()) {
            $lib_fonct = $res['libelle_grade'];
            $creerPar = $res['creerPar'];
            $modifierPar = $res['modifierPar'];
        }
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label">Ancien Grade</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="lib_fonct" value="<?php echo $lib_fonct;?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">CréerPar</label>
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
    <?php 
    
    }elseif(isset($_GET['info']) && isset($_GET['valeur']) && $_GET['valeur']=="fonction"){
        $req = $db->prepare("SELECT detail_agent_fonction.creerPar,detail_agent_fonction.modifierPar,t_fonction.libelleFonct
        FROM bdd_paie.detail_agent_fonction INNER JOIN bdd_paie.t_fonction ON detail_agent_fonction.fonction_ID = t_fonction.codeFonct 
            WHERE detail_agent_fonction.statut_ID = 'act' AND detail_agent_fonction.agent_ID = :matricule ");
        $req->bindValue(':matricule',$_GET['info']);
        $req->execute();
        while ($res = $req->fetch()) {
            $lib_fonct = $res['libelleFonct'];
            $creerPar = $res['creerPar'];
            $modifierPar = $res['modifierPar'];
        }
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label">Ancienne Fonction</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="lib_fonct" value="<?php echo $lib_fonct;?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">CréerPar</label>
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
    <?php 
    }elseif(isset($_GET['info']) && isset($_GET['valeur']) && $_GET['valeur']=="activite"){
        $req = $db->prepare("SELECT detail_agent_activ.creerPar,detail_agent_activ.modifierPar,t_activite.libelle_activ
        FROM bdd_paie.detail_agent_activ INNER JOIN bdd_paie.t_activite ON detail_agent_activ.code_activ_ID = t_activite.code_activ 
            WHERE detail_agent_activ.statut_ID = 'act' AND detail_agent_activ.agent_ID = :matricule ");
        $req->bindValue(':matricule',$_GET['info']);
        $req->execute();
        while ($res = $req->fetch()) {
            $lib_fonct = $res['libelle_activ'];
            $creerPar = $res['creerPar'];
            $modifierPar = $res['modifierPar'];
        }
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label">Ancienne Activité</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="lib_fonct" value="<?php echo $lib_fonct;?>" readonly>
               
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">CréerPar</label>
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
    <?php 
    }elseif(isset($_GET['info']) && isset($_GET['valeur']) && $_GET['valeur']=="syndicat"){
        $req = $db->prepare("SELECT detail_agent_syndicat.creerPar,detail_agent_syndicat.modifierPar,t_syndicat.libelle_syndi
        FROM bdd_paie.detail_agent_syndicat INNER JOIN bdd_paie.t_syndicat ON detail_agent_syndicat.syndicat_ID = t_syndicat.code_syndi 
            WHERE detail_agent_syndicat.statut_ID = 'act' AND detail_agent_syndicat.agent_ID = :matricule ");
        $req->bindValue(':matricule',$_GET['info']);
        $req->execute();
        while ($res = $req->fetch()) {
            $lib_fonct = $res['libelle_syndi'];
            $creerPar = $res['creerPar'];
            $modifierPar = $res['modifierPar'];
        }
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label">Ancien Syndicat</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="lib_fonct" value="<?php echo $lib_fonct;?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">CréerPar</label>
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
    <?php 
    }