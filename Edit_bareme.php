<?php
    include_once('sys_connexion.php');
    $id_bar = '';
    $LibelleBar = '';
    $creerPar = '';
    $modifierPar = '';
    $dateCreation = '';
    $dateModification = '';
    $statut = '';
    if(isset($_GET['id'])){
        $id_barAmodif = $_GET['id'];
     
        $reqGetInfobar = $db->prepare('SELECT * FROM bdd_paie.t_bareme INNER join bdd_paie.t_utilisateurs on t_bareme.Creat_Par=t_utilisateurs.id_user INNER JOIN bdd_paie.t_agent on t_agent.matricule=t_utilisateurs.agent_ID INNER JOIN bdd_paie.t_statut ON t_bareme.statut_ID=t_statut.code_st WHERE t_bareme.id_bar = :id_bar');
        $reqGetInfobar->bindValue(':id_bar',$id_barAmodif);
        $reqGetInfobar->execute();
    
        while($resGetInfobar = $reqGetInfobar->fetch()){
            $id_bar = $resGetInfobar['id_bar'];
            $LibelleBar = $resGetInfobar['LibelleBar'];
            $creerPar = $resGetInfobar['creerPar'];
            $nomAg = $resGetInfobar['nom_ag'];
            $PostnomAg = $resGetInfobar['postnom_ag'];
            $PrenomAg = $resGetInfobar['prenom_ag'];
            $modifierPar = $resGetInfobar['modifierPar'];
            $dateCreation = $resGetInfobar['Date_Creat'];
            //$dateModification = $resGetInfobar[''];
            $statut = $resGetInfobar['libelle_st'];
            $id_statut =$resGetInfobar['code_st'];
            $nomComplet = $nomAg." ".$PostnomAg." ".$PrenomAg;
        }
            
    }else{
      
    }
?>

<br>
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


            <div class="row">
                <form class="form-horizontal style-form" method="POST" action="update_bareme.php" data-confirm-modify="true">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Id Barème</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="IdBar" value="<?php echo $id_bar ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Libelle Barème</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="libBar" value="<?php echo $LibelleBar ?>">
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Créer Par</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="creerBar" value="<?php echo $nomComplet?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateBar"  value="<?php echo $dateCreation?>" readonly>
                            </div>
                        </div>
                       
                        
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">

                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Modifier Par </strong></label>
                            <div class="col-sm-8">

                                <input type="text" class="form-control" name="ModifBar"value="<?php echo $_SESSION['nomComplet']?>"readonly >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Modifier le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="DateModifBar" value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div>
                             
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Activé</strong></label>
                        <div class="col-sm-2 text-center">
                               <input type="checkbox" name="statutCode[]" value="act" <?php if ($id_statut=='act') echo "checked";?>  data-toggle="switch" />
                        </div>  
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-round btn-primary col-sm-3" id="btnModifierAgent"
                                name="creerBar" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i> Modifier</button>
                            <a href="accueil.php?page=voir_Bareme" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                        </div>
                    </div> 
                    
                </form>
                <?php include_once('confirm_modify_modal.php'); ?>
                
            </div>
        </div>
        <br><br><br><br><br><br><br>
    </div>
</div>
