<?php
    //session_start();
    include_once('sys_connexion.php');
    $code_prov = '';
    $libe_prov = '';
    $creerPar = '';
    $modifierPar = '';
    $statut = '';
    $nomModif = '';
    $nomComplet ='';

    if(isset($_GET['code_prov'])){
        $code_prov = $_GET['code_prov'];
        $req = $db->prepare('SELECT * FROM bdd_paie.t_province WHERE code_prov = :code_prov');
        $req->bindValue(':code_prov',$code_prov);
        $req->execute();
        while ($res = $req->fetch()) {
            $code_prov = $res['code_prov'];
            $libe_prov = $res['libelle_prov'];
            $creerPar = $res['creerPar'];
            $modifierPar = $res['modifierPar'];
            //$dateCreation = $res['dateCreation'];
            //$dateModif = $res['dateModif'];
            $statut = $res['statut_ID'];
        }
    }
?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
});
</script>
<h3><i class="fa fa-angle-right"></i> Modifier Province</h3>
<!-- BASIC FORM ELELEMNTS -->

<br><br>
<div class="row mt">
    <div class="col-lg-12">
        
        <div class="form-panel">
            <form class="form-horizontal style-form" method="POST" action="update_province.php">
                <div class="row">
                
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Code Province</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $code_prov; ?>" name="codeProv" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Libellé</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="libProv" value="<?php echo $libe_prov; ?>">
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">
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
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Statut</label>
                            <div class="col-sm-2 text-center">
                                <input type="checkbox" name="statutCode" 
                                 <?php //echo ($statut == "act") ?"checked":"unchecked";?> data-toggle="switch"/>
                            </div>
                        </div-->
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addProvince"
                            name="updateProvince" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i> Modifier</button>
                        <a href="accueil.php?page=Voir_Province" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
            
        </div>
        <br><br><br><br>
    </div>
</div>
          
            