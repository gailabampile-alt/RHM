<?php
    //session_start();
    include_once('sys_connexion.php');
    
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

<h3><i class="fa fa-angle-right"></i>Pointage / Heure Suplementaire</h3>
<!-- BASIC FORM ELELEMNTS -->
      
<div class="row mt mb" style="margin: 15px;">
          
    <div class="col-lg-12 mt">
        <div class="row content-panel">
            <div class="panel-heading">
                <ul class="nav nav-tabs nav-justified">
                    <li >
                        <a data-toggle="tab" href="#pointage">Pointage</a>
                    </li>
                    <li class='active'>
                        <a data-toggle="tab" href="#heure">Heure Suplementaire</a>
                    </li>
                    
                </ul>
            </div>
              <!-- /panel-heading -->
            <div class="panel-body">
                <div class="tab-content">
                  <!-- /tab-pane -->
                    <div id="pointage" class="tab-pane ">
                    <?php if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="alert">×</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
      </div>
          <?php } ?>
          <br><br>
                    <div class="row">
                        <div class="col-lg-12 ">
                            
                        <form class="form-horizontal style-form" action="Update_pointage.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        
                    <div class="form-group">
                            <label class="control-label col-md-3"><strong>Période</strong></label>
                        <div class="col-md-7">
                            <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="01/2024" class="input-append date dpMonths">
                            
                            <input type="text" readonly="" name="periode" value=""  size="16" class="form-control">
                                <span class="input-group-btn add-on">
                                <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>

                    </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="datep" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Matricule</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez un Agent"  name="matriAg" id="Product" class="form-control chzn-select" tabindex="2">
                           
                            
                            <option ></option>
                                    
                                    
                             
                                
                                </select>
                            </div>
                    </div>
                        

                        <div class="form-group">
                            <label class="col-sm-3 control-label">nbrejrs</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="nbrejrs" value="" required>
                            </div>
                        </div>
                       

                        
                    </div>

                    <div class="col-lg-6 col-md-6 col-xl-6">

                    
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer Par</strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="creerpar" value="" readonly>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Creer le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateAvc"  value="" readonly>
                            </div>
                     </div>
                     <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Modifier Par </strong></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="ModifBar"value=""readonly >
                            </div>
                    </div>
                    
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier le</label>
                            <div class="col-sm-8">
                            <input type="date" class="form-control" name="DateModifcodep" value="<?php echo date('Y-m-d')?>" readonly>
                                
                            </div>
                        </div>
                        
                        
                        
                        
                        
                    </div>

                
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Modifier" name="Modif" style="margin-left:15px;width:150px;">
                            <a href="accueil.php?page=voir_pointage" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    <!--    <input type="submit"  formaction="add_pointage.php" class="btn btn-round btn-primary col-sm-3" value="P/Mois" name="Pointage" style="margin-left:15px;width:150px;">-->
                        </div>
                    </div>
                </div>
        </form> 
        <?php include_once('confirm_modify_modal.php'); ?>
                
            </div>
                      
                    </div>
                    <!-- /row -->
                                                            <br><br><br>
                </div>
                  <!-- /tab-pane -->
                  <?php
                 $id_pointage ='';
                 $periode ='';
                 $datep ='';
                 $matricule ='';
                 $ph = '';
                $nbreh = '';
    if(isset($_GET['id'])){

        $id_pointage = $_GET['id'];
     
        $reqGetInfobar = $db->prepare('SELECT t_heures.periode,t_heures.datep,t_heures.matric,t_agent.nom_ag,t_agent.postnom_ag, t_heures.nbreh,t_heures.typeHeure,t_heures.creerpar,t_heures.datecreat,t_heures.modifierpar,t_heures.datemodif FROM bdd_paie.t_heures INNER JOIN bdd_paie.t_agent on t_agent.matricule=t_heures.matric WHERE id_pointage=:id_pointage');
        $reqGetInfobar->bindValue(':id_pointage',$id_pointage);
        $reqGetInfobar->execute();
    
        while($resGetInfobar = $reqGetInfobar->fetch()){
            
            $periode =$resGetInfobar['periode'];
            $datep = $resGetInfobar['datep'];
            $matricule = $resGetInfobar['matric'];
            
            $nbreh =  $resGetInfobar['nbreh'];
            $nomAg = $resGetInfobar['nom_ag'];
            $PostnomAg = $resGetInfobar['postnom_ag'];
            $modifierPar = $resGetInfobar['modifierpar'];
            $dateCreation = $resGetInfobar['datecreat'];
            $heure = $resGetInfobar['typeHeure'];
            $creerpar = $resGetInfobar['creerpar'];
            $nomComplet = $nomAg." ".$PostnomAg ;
            $datemodif=$resGetInfobar['datemodif'];
           /// $datedebut = $resGetInfobar['Date_debut'];
           // $datefin =$resGetInfobar['Date_fin'];
           /// $id_statut= $resGetInfobar['statut'];
        }
            
    }else{
      
    }

    ?>

                <div id="heure" class="tab-pane active">
                
                    <div class="row">
                        <div class="col-lg-12 ">

                   <form class="form-horizontal style-form" action="Update_heures.php" method="POST" enctype="multipart/form-data"> 
                <div class="row">
                
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        
                    <div class="form-group">
                            <label class="control-label col-md-3"><strong>Période</strong></label>
                        <div class="col-md-7">
                            <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="01/2024" class="input-append date dpMonths">
                            <input type="hidden" class="form-control" name="id_pointage" value=<?php echo  $id_pointage ;?>>  
                            <input   type="text" readonly="" name="periode" value=<?php echo  $periode ;?> size="16" class="form-control">
                                <span class="input-group-btn add-on">
                                <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>

                    </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo $datep;?>" name="dateop" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Matricule</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Selectionnez un Agent"  name="matriAg" id="Product" class="form-control" tabindex="2">
                            <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.t_agent WHERE t_agent.matricule=:matric');
                                        $reqGetcodepaie->bindValue(':matric',$matric);
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $matri = $resGetcodepaie['matricule']; 
                                            $nomAg = $resGetcodepaie['nom_ag'];
                                            $postnom = $resGetcodepaie['postnom_ag'];
                                            
                                            ?>
                                            
                                    <option value="<?php echo $matri ?>"> <?php echo $matri;?>|<?php echo $nomAg;?> <?php echo $postnom;?></option>
                                    
                                <?php } ?>      
                            
                            <option value="<?php echo $matricule;?>"><?php echo $matricule;?> | <?php echo $nomComplet;?></option>
                                    <?php
                                        $reqGetcodepaie = $db->prepare('SELECT * FROM bdd_paie.t_agent');
                                        $reqGetcodepaie->execute();
                                        while($resGetcodepaie =  $reqGetcodepaie->fetch()){
                                            $matri = $resGetcodepaie['matricule']; 
                                            $nomAg = $resGetcodepaie['nom_ag'];
                                            $postnom = $resGetcodepaie['postnom_ag'];
                                            ?>
                                            
                                    <option value="<?php echo $matri ?>"> <?php echo $matri;?>|<?php echo $nomAg;?> <?php echo $postnom;?></option>
                                    
                                <?php } ?>
                                
                                </select>
                            </div>
                       </div>
                       <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Nombre D'heure<strong></label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" value="<?php echo $nbreh;?>" name="nbreh">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><strong>Heure</strong></label>
                            <div class="col-sm-8">
                            <select data-placeholder="Choisir le % " name="heure" id="Product" value="<?php echo $heure;?>" class="form-control " tabindex="2">
                            <?php
                      if ($heure == "N") {
                          $heure = "Normal";
                      } elseif ($heure == "Nt") {
                          $heure = "Nuit";
                      } else {
                          $heure = "Ferier";
                      }
                    ?>
                            <option><?php echo $heure;?></option>
                            <option value="N">Normal</option>
                                    <option value="Nt">Nuit</option>
                                    <option value="F">Ferier</option>
                            
                            </select>
                            </div>
                        </div>
                        

                        
                    </div>

                <div class="col-lg-6 col-md-6 col-xl-6">
                <div class="form-group">
                            <label class="col-sm-4 control-label"><strong>Creer Par</strong></label>
                            <div class="col-sm-8">
                            <?php 
                                if($creerpar == "sysAdmin"){
                                ?>
                                <input type="text" value="<?php echo $creerpar;?>" class="form-control" readonly>
                                <?php 
                                }else{
                                $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                                WHERE id_user = :creerPar');
                                $reqGetInfoUser->bindValue(':creerPar',$creerpar);
                                $reqGetInfoUser->execute();
                                while ($resGetInfoUser = $reqGetInfoUser->fetch()) {
                                    $nom_postnom = $resGetInfoUser['nom_ag'].' '.$resGetInfoUser['postnom_ag'];
                                    $prenom = ucfirst(strtolower($resGetInfoUser['prenom_ag']));
                                    $nomComplet = $nom_postnom.' '.$prenom;
                                ?>

                        <script>
                        document.addEventListener('DOMContentLoaded', function(){
                            var form = document.querySelector('form.form-horizontal'); if(!form) return;
                            form.addEventListener('submit', function(e){ e.preventDefault(); $('#confirmModifyModal').modal('show'); });
                            document.addEventListener('click', function(ev){ if(ev.target && ev.target.id === 'confirmModifyBtn'){ $('#confirmModifyModal').modal('hide'); form.submit(); } });
                        });
                        </script>

                        <h3><i class="fa fa-angle-right"></i>Pointage / Heure Suplementaire</h3>
                            <?php } ?>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><strong>Creer le</strong></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateCreat"  value="<?php echo $dateCreation ?>" readonly>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><strong>Modifier Par </strong></label>
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
                                 <input type="text" class="form-control" name="DateModif" value="<?php echo $nomComplet;?>" readonly>
                              
                            <?php } ?>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><strong>Modifier le</strong></label>
                            <div class="col-sm-8">
                            
                                 <input type="date" class="form-control" name="DateModif" value="<?php echo $datemodif;?>" readonly>
                              
                          
                               
                            </div>
                        </div>
                    
                
                            
                        </div>
                    </div>
                        
                        
                        
                    </div>
                   
                    

                
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Modifier" name="Modif" style="margin-left:15px;width:150px;">
                            <a href="accueil.php?page=voir_heures" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
            </form>
            <br><br>
                      </div>
                      <!-- /col-lg-8 -->
                    </div>
                    <!-- /row -->
                </div>
                  <!-- /tab-pane -->
               
                <!-- /tab-content -->
            </div>
              <!-- /panel-body -->
        </div>
            <!-- /col-lg-12 -->
           
    </div>
          <!-- /row -->
       
</div>
   <!-- /container -->
     