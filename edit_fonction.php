<?php
    include_once('sys_connexion.php');

    $codeFonction = '';
    $codeFonct = '';
    $libelleFonct = '';
    $creerPar = '';
    $modifierPar = '';
    $dateCreation = '';
    $dateModif = '';
    $statut = '';
    $nomModif = '';
    $nomComplet = '';

    if(isset($_GET['code_fonct'])){
        $codeFonction = $_GET['code_fonct'];
        $reqFonction = $db->prepare('SELECT * FROM bdd_paie.t_fonction WHERE codeFonct = :codeFonct');
        $reqFonction->bindValue(':codeFonct',$codeFonction);
        $reqFonction->execute();
        if ($resFonction = $reqFonction->fetch()) {
            $codeFonct = $resFonction['codeFonct'];
            $libelleFonct = $resFonction['libelleFonct'];
            $creerPar = $resFonction['creerPar'];
            $modifierPar = $resFonction['modifierPar'];
            $dateCreation = $resFonction['dateCreation'];
            $dateModif = $resFonction['dateModif'];
            $statut = $resFonction['statut_ID'];
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
<h3><i class="fa fa-angle-right"></i> Modification Fonction</h3>
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
            <form class="form-horizontal style-form" method="POST" action="update_fonction.php">
                <div class="row centered">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Code Fonction</label>
                            <div class="col-sm-8">
                                <input type="hidden" value="<?php echo $codeFonction; ?>" name="codeFonction">
                                <input type="text" class="form-control" value="<?php echo $codeFonct; ?>" name="cod_fonct">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Libellé Fonction</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $libelleFonct; ?>" name="lib_fonct">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
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
                            <label class="col-sm-3 control-label">DateCréation</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $dateCreation;?>" readonly>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xl-6">
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

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Modifier</label>
                            <div class="col-sm-8">
                                <input type="date-time" class="form-control" value="<?php echo $dateModif;?>" readonly>
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
                        </div-->
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Statut</label>
                            <div class="col-sm-2 text-center">
                                <input type="checkbox" name="statutCode" 
                                 <?php echo ($statut == "act") ?"checked":"unchecked";?> data-toggle="switch"/>
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
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="updateAgent"
                            name="updateAgent" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i> Modifier</button>
                        <a href="accueil.php?page=Voir_Fonction" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
            
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</div>
          
            
