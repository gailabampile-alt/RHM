<?php
    //session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');
?>
<h3><i class="fa fa-angle-right"></i> Octroi des Prêts</h3>

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
            <form class="form-horizontal style-form" method="POST" action="add_pret.php">
                <div class="row">
                
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">N° OP</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nRef" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                                <select data-placeholder="Selectionnez un Agent" class="form-control chzn-select" name="matric" required>
                                <option></option> 
                                    <?php
                                        $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent');
                                        $reqGetMatriculeAgent->execute();
                                        while($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()){
                                            $matric = $resGetMatriculeAgent['matricule']; 
                                            $nomComplet = $resGetMatriculeAgent['nom_ag'].' '.$resGetMatriculeAgent['postnom_ag'];?>
                                        <option value="<?php echo $matric;?>"> <?php echo $matric.' | '.$nomComplet;?> </option>
                                    <?php } ?>   
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Code Paie</label>
                            <div class="col-sm-8">
                                <select data-placeholder="Selectionnez le Code paie" class="form-control chzn-select" name="codePaie" required>
                                <option></option> 
                                    <?php
                                        $reqGetMatriculeAgent = $db->prepare('SELECT codePaie,libelle_codePaie FROM bdd_paie.t_codepaie
                                        ');
                                        $reqGetMatriculeAgent->execute();
                                        while($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()){
                                            $cod_paie = $resGetMatriculeAgent['codePaie']; 
                                            $lib_paie = $resGetMatriculeAgent['libelle_codePaie'];?>
                                        <option value="<?php echo $cod_paie;?>"> <?php echo $cod_paie.' | '.$lib_paie;?> </option>
                                    <?php } ?>   
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Période</label>
                            <div class="col-sm-7">
                                <!--input type="month" class="form-control"-->
                                <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="01/2014" class="input-append date dpMonths">
                                    <input type="text" readonly="" name="periode" size="16" class="form-control" required>
                                    <span class="input-group-btn add-on">
                                        <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Début</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateDebut" require>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Montant Prêter</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="Detailspret" name="montPreter" required>
                            </div>
                            <label class="col-sm-2 control-label">Taux en %</label>
                            <div class="col-sm-3">
                                
                                <input type="text" class="form-control" name="interet" id="Detailstaux" onchange="calculesolde(this.value)" required>
                            </div>
                        </div>
                        <div class="form-group" id="solde_aPayer">
                            <label class="col-sm-3 control-label">Solde</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  name="solde"  id="DetailSolde" readonly>
                            </div>
                            <label class="col-sm-1 control-label"> Durée</label>
                            <div class="col-sm-3">
                            
                                <input type="text" class="form-control" name="durer" id="DetailsDuree"  onchange="calculeretenir(this.value)" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">A Payer</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" name="aPayer" id="Detailsretenir" readonly>
                                 
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Monnaie</label>
                            <div class="col-sm-8">
                                <select data-placeholder="Selectionnez la devise" class="form-control chzn-select" name="monnaie" required>
                                <option></option> 
                                    <?php
                                        $reqGetMonnaie = $db->prepare('SELECT code_monnaie,	libelle_monnaie FROM bdd_paie.monnaie
                                        ');
                                        $reqGetMonnaie->execute();
                                        while($resGetMonnaie = $reqGetMonnaie->fetch()){
                                            $cod_mon = $resGetMonnaie['code_monnaie']; 
                                            $lib_mon = $resGetMonnaie['libelle_monnaie'];?>
                                        <option value="<?php echo $cod_mon;?>"> <?php echo $cod_mon.' | '.$lib_mon;?> </option>
                                    <?php } ?>   
                                </select>
                            </div>
                        </div>
                        
                        
                    </div>
                
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-round btn-primary col-sm-3" id="btnModifierAgent"
                            name="octroiPret" style="margin-left:15px;width:150px;"><i class="fa fa-money"></i> Octroyer</button>
                        <a href="accueil.php?page=Voir_Prets" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
        </div>
  
    </div>
</div>
<br><br><br><br><br>      
<script>
    /*
      function calculPret(str) {
          var xmlhttp = new XMLHttpRequest();
          var durer = document.getElementById("durer").value;
          var montPreter = document.getElementById("montantPreter").value;
          var interet = document.getElementById("interet").value;
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("solde_aPayer").innerHTML = this.responseText;
            }
          };
          xmlhttp.open("GET","showCalculPret.php?durer=" +durer+ "&montPreter=" +montPreter+ "&interet=" +interet, true);
          xmlhttp.send();
        }
        
*/
        function calculPret()
        {
        var durer = document.getElementById("durer").value;
        var montPreter = document.getElementById("montantPreter").value;
        var interet = document.getElementById("interet").value;
        $.ajax({
            type: 'GET',
            url: 'showCalculPret.php',
            data: {
            durer:durer,
            montPreter:montPreter,
            interet:interet
            },
            success: function (response) {
            $('#solde_aPayer').innerHTML(response);//html("Vos données seront sauvegardées");
            }
        });
            
        return false;
        }
    
    
   </script>