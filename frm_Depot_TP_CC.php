<?php
    include ('db_connexion.php');
?>
        <link rel="stylesheet" href="css/styles.css">
        <div class="container-fluid px-4 mt-3">
            <div class="card mb-4 d-flex">
                <!--Message D alert-->

				<?php if (isset($_SESSION['message'])) {?>
					<div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
						<button type="button" class="close" data-dismiss="alert">×</button>  
							 <span><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></span> 
					</div>
				<?php } ?>
				<!--Message D alert-->
                 
                <div class="card-header h5"> <i class="fas fa-table me-1"></i> Dépot Travaux</div>
                <div class="card-body">
                    <div>
                        <form action="depot_tp_cc_Add.php" method="post" enctype="multipart/form-data">
                            <div class="row mb-2">
                                <div class="col-md-4 d-inlign">
                                    <label for="nom">Nom </label>
                                    <input type="text" name="nom" class="form-control" id="nom" value="<?php echo $_SESSION['nom'];?>" readonly>
                                </div>
                                <div class="col-md-4 d-inlign">
                                    <label for="postnom">PostNom </label>
                                    <input type="text" name = "postnom" class="form-control" id="postnom" value="<?php echo $_SESSION['postnom'];?>" readonly>
                                </div>
                                <div class="col-md-4 d-inlign">
                                    <label for="prenom">PréNom </label>
                                    <input type="text" name = "prenom" class="form-control" id="prenom" value="<?php echo $_SESSION['prenom'];?>" readonly>
                                </div>
                            </div>
                            <!--Ligne 2-->
                            <div class="row mb-2">
                                <!--div class="col-md-4 d-inlign">
                                    <label for="sexe">Sexe </label>
                                    <select class="form-select" id="sexe" required>
                                        <option>Homme</option>
                                        <option>Femme</option>
                                    </select>
                                </div-->
                                <div class="col-md-8 d-inlign">
                                    <label for="phone">Libellé Du travail </label>
                                    <input type="text" class="form-control" id="phone" name="libTrav">
                                </div>

                                <div class="col-md-4 d-inlign">
                                    <label for="codeDuTravail">Code du Travail </label>
                                    <input type="text" class="form-control" id="codeDuTravail" name="codeTravailTele">
                                </div>
                                
                            </div>
                            <!--Ligne 3-->
                            <div class="row">
                                <div class="col-md-4 ">
                                    <label for="cours">Cours </label>
                                    <?php
                                        $reqCour = $db->prepare("SELECT * FROM c2076648c_db_cours.tab_cours");
                                        $reqCour->execute();
                                        ?>
                                    <select class="form-select" id="cours" name="idCour" required>
                                        <?php 
                                            while($resCour = $reqCour->fetch()){ ?>
                                            <option value="<?php echo $resCour['code_cour'];?>">  <?php echo $resCour['code_cour'];?> </option>
                                            <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 d-inlign">
                                    <label for="chargeFichier">Chargement Fichier </label>
                                    <input type="file" class="form-control" id="chargeFichier" name="chargFichier" required>
                                </div>
                                <div class="col-md-4 d-inlign">
                                    <label for="typeTravaux">Type Travaux </label>
                                    <?php
                                        $reqType = $db->prepare("SELECT * FROM c2076648c_db_cours.tab_typetravail");
                                        $reqType->execute();
                                        ?>
                                    <select class="form-select" id="typeTravaux" name="typeTravail" required>
                                        <?php 
                                            while($resType = $reqType->fetch()){ ?>
                                            <option value="<?php echo $resType['code_typeT'];?>">  <?php echo $resType['libelle_typeT'];?> </option>
                                            <?php } ?>    
                                    </select>
                                    
                                </div>
                            </div>
                            <!--Ligne 3-->
                            <div class="row">
                                <div class="col-md-6 ">
                                    <br>
                                    <input type="submit" name="depot" class="form-control btn btn-outline-primary" value="Déposer">
                                </div>
                                <div class="col-md-6 ">
                                    <br>
                                    <input type="reset" class="form-control btn btn-outline-warning" value="Annuler">
                                </div>
                                
                            </div>
    
                        </form>
                    </div>
                </div>
            </div>
            <!--Deuxieme Card-->
            <div class="card mb-4">
                <div class="card-header h5">
                    <i class="fas fa-table me-1 policeTitre"> </i> Grille de Dépot
                </div>
                <div class="card-body table-responsive">
                    <table class="table hover multiple-select-row data-table-export nowrap">
                    <?php
                        $reqAffTrav = $db->prepare("SELECT * FROM c2076648c_db_cours.v_affichertravail_etu_cour ORDER BY id_trav");
                        $reqAffTrav->execute();
                        ?>
                        <thead>
                            <tr>
                                <th>Num</th>
                                <th class="table-plus datatable-nosort">Nom</th>
                                <th>PostNom</th>
                                <th>PréNom</th>
                                <th>Travail</th>
                                <th>Promotion</th>
                                <th>Cour</th>
                                <th>Fichier</th>
                                <th>Date Dépot</th>
                                <th>Vacation</th>
                            </tr>

                            

                        </thead>
                        <tbody>
                            <tr>
                            <?php 
                                while($resAffTrav = $reqAffTrav->fetch()){ ?>
                                <td class="table-plus"> <?php echo $resAffTrav['id_trav']; ?> </td>
                                <td> <?php echo $resAffTrav['nom_etu']; ?> </td>
                                <td> <?php echo $resAffTrav['postnom_etu']; ?> </td>
                                <td> <?php echo $resAffTrav['prenom_etu']; ?> </td>
                                <td> <?php echo $resAffTrav['typeTravID']; ?> </td>
                                <td> <?php echo $resAffTrav['promotionID']; ?> </td>
                                <td> <?php echo $resAffTrav['code_cour']; ?> </td>
                                <td> <?php echo $resAffTrav['travName'] ;?> </td>
                                <td> <?php echo $resAffTrav['dateDepot']; ?> </td>
                                <td> <?php echo $resAffTrav['vacation']; ?> </td>
                            </tr>

                            <?php } ?>

                        </tbody>
                    </table>
                </div>
                    
            </div>
    
        </div>
    
       
