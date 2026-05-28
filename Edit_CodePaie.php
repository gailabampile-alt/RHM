<?php
    include_once('sys_connexion.php');
    $codepaie = '';
    $Libellepaie = '';
    $creerPar = '';
    $sens='';
    $imposable='';
    $modifierPar = '';
    $dateCreation = '';
    $dateModification = '';
    $statut = '';
    if(isset($_GET['id'])){
        $id_codepAmodif = $_GET['id'];
     
        $reqGetInfobar = $db->prepare('SELECT * FROM bdd_paie.t_codepaie INNER join bdd_paie.t_utilisateurs on t_codepaie.creerPar=t_utilisateurs.id_user INNER JOIN bdd_paie.t_agent on t_agent.matricule=t_utilisateurs.agent_ID INNER JOIN bdd_paie.t_statut ON t_codepaie.statut_ID=t_statut.code_st WHERE t_codepaie.codePaie = :codePaie');
        $reqGetInfobar->bindValue(':codePaie',$id_codepAmodif);
        $reqGetInfobar->execute();
    
        while($resGetInfobar = $reqGetInfobar->fetch()){
            $codepaie = $resGetInfobar['codePaie'];
            $Libellepaie = $resGetInfobar['libelle_codePaie'];
            $creerPar = $resGetInfobar['creerPar'];
            $sens = $resGetInfobar['sens_ID'];
            $nomAg = $resGetInfobar['nom_ag'];
            $PostnomAg = $resGetInfobar['postnom_ag'];
            $imposable = $resGetInfobar['imposable'];
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

<h3><i class="fa fa-angle-right"></i>Modifier un Element de Paie</h3>
<!-- BASIC FORM ELELEMNTS -->
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
                <form class="form-horizontal style-form" method="POST" action="update_codepaie.php">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Code</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="codepaie" value="<?php echo $codepaie?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Libelle Element de Paie</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="libcodePaie" value="<?php echo $Libellepaie ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sens</label>
                            <div class="col-sm-8">
                            <select data-placeholder="Choose a Product"  name="sens" id="Product" class="form-control chzn-select" tabindex="2">
                                    <option><?php echo $sens ?></option>
                                    <option value="1">Sens 1</option>
                                    <option value="2">Sens 2</option>
                                    <option value="3">Sens 3</option>
                                    <option value="4">Sens 4</option>
                                </select>
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <label class="control-label col-lg-3"><strong>Imposable</strong></label>
                            <div class="col-lg-8">
                            <select data-placeholder="Choose a Product"  name="imposable" id="Product" class="form-control chzn-select" tabindex="2">
                            <option value="I">I - Imposable</option>
                            <option id="N">N - Non imposable</option>
                            </select>

                        </div>
                        </div>
                       
                       
                        
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Créer Par</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="creercode" value="<?php echo $nomComplet?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateBar"  value="<?php echo $dateCreation?>" readonly>
                            </div>
                        </div>
                        
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
                            <label class="col-sm-3 control-label"><strong>Statut</strong></label>
                        <div class="col-sm-2 text-center">
                               <input type="checkbox" name="statutCode[]" value="act" <?php if ($id_statut=='act') echo "checked";?> data-toggle="switch" />
                        </div>  
                        </div>
                        
                       
                    </div>
                    <div class="row" style="margin-left: 5px;">
                        <div class="col-lg-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-round btn-primary col-sm-3"
                                name="ModifCodep" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i> Modifier</button>
                            <a href="accueil.php?page=voir_Code_paie" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
                    
                    
                </form> 
                
                
            </div>
        </div>
        <br><br><br><br><br><br><br>
    </div>
</div>