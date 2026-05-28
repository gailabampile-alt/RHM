<?php
    require_once('sys_connexion.php');
    require_once('sys_fonction.php');

    $lib_conge = "";
    $dateDu = "";
    $dateAu ="";
    $nbrejr ="";


    if(isset($_GET['q'])){
        $req = $db->prepare("SELECT * FROM bdd_paie.t_demandeconge  
        inner join bdd_paie.t_typconge ON t_demandeconge.id_typeconge=t_typconge.id_type_conge WHERE matricule=:matric AND etat=:etat ");
        $req->bindValue(':matric',$_GET['q']);
        $req->bindValue(':etat',"desac");
        $req->execute();
        while ($res = $req->fetch()) {
            $lib_conge = $res['libelle_conge'];
            $dateDu = $res['date_debut'];
            $dateAu = $res['date_fin'];
            $nbrejr = $res['nbrejr_accord'];
            $matric = $res['matricule'];
            $iddemande= $res['id_demande'];
            $lib_conge= $res['libelle_conge'];
        }
?>
      
                        <div class="form-group" >
                            <label class="col-sm-3 control-label">Type de Congé</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="nbrejr"  value="<?php echo $lib_conge;?>"readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3"> Du</label>
                            <div class="col-md-8">
                                <div class="input-group input-large" data-date="01/01/2024" data-date-format="mm/dd/yyyy">
                                    <input type="text" class="form-control dpd1" name="dateDu"   value="<?php echo $dateDu;?>"readonly>
                                    <span class="input-group-addon">Au</span>
                                    <input type="text" class="form-control dpd2" name="dateAu"   value="<?php echo $dateAu;?>"readonly>
                                </div>
                                <!--span class="help-block">Selectionner la durée</span-->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre de Jour</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nbrejr"  value="<?php echo $nbrejr;?>" readonly>
                            </div>
                        </div>
                    
                        <?php   }  ?>
                       