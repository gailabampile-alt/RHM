<?php
    //session_start();
    include_once('sys_connexion.php');
    $code_dir = '';
    $libe_dir = '';
    $creerPar = '';
    $modifierPar = '';
    $statut = '';
    $nomModif = '';
    $nomComplet ='';

    if(isset($_GET['code_dir'])){
        $code_dir = $_GET['code_dir'];
        $req = $db->prepare('SELECT * FROM bdd_paie.t_direction WHERE code_dir = :code_dir');
        $req->bindValue(':code_dir',$code_dir);
        $req->execute();
        while ($res = $req->fetch()) {
            $code_dir = $res['code_dir'];
            $libe_dir = $res['libelle_dir'];
            $creerPar = $res['creePar'];
            $modifierPar = $res['modifierPar'];
            //$dateCreation = $res['dateCreation'];
            //$dateModif = $res['dateModif'];
            $statut = $res['statut_ID'];
        }
    }
?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var forms = document.querySelectorAll('form');
    forms.forEach(function(f){
        f.addEventListener('submit', function(e){
            if(!confirm('Voulez-vous modifier ?')){ e.preventDefault(); return false; }
        });
    });
});
</script>
<h3><i class="fa fa-angle-right"></i> Modifier Direction</h3>
<!-- BASIC FORM ELELEMNTS -->

<br><br>
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
            <form class="form-horizontal style-form" method="POST" action="update_direction.php">
                <div class="row">
                
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Code Direction</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="code_dir" value="<?php echo $code_dir;?>">
                                <input type="hidden" class="form-control" name="code_direction" value="<?php echo $code_dir;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Libellé</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="lib_dir" value="<?php echo $libe_dir;?>">
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
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addDirection"
                            name="updateDirection" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i> Modifier</button>
                        <a href="accueil.php?page=Voir_Direction" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
            
        </div>
        <br><br><br><br>
    </div>
</div>
          
            