<?php
    include_once('sys_connexion.php');

?>

<h3><i class="fa fa-angle-right"></i> Liste Des Barèmes par grade</h3>

        
        <div class="row mb">
          <!-- page start-->
          <div class="content-panel" style="margin: 15px;">
          <?php if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="alert">×</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
            </div>
        <?php } ?>

          <div class="col-lg-6">
            <a href="accueil.php?page=Bareme_Grade" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;width:170px;"><i class="fa fa-plus-circle" style="margin-right: 7px;"></i>Ajouter</a>
            <a href="print_bareme_grade.php" target="_blank" class="btn btn-round btn-primary col-sm-2" style="margin-bottom:25px;margin-left:15px;width:90px;"><i class="fa fa-print" style="margin-right: 7px;"></i> Liste</a>

          </div>
          <br>
           <br>
           <br>
            <div class="adv-table" style="margin: 5px;">
              <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                   <!--  <th>Grade</th>-->
                    <th>Grade</th>
                    <th class="hidden-phone">Libelle Barème</th>
                    <th class="hidden-phone">Montant</th>
                    <th class="hidden-phone">Devise</th>
                    <th class="hidden-phone">Date Baréme</th>
                    <th>Statut</th>
                    <th class="hidden-phone">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <!--tr class="gradeX">
                    <td>Trident</td>
                    <td>Internet Explorer 4.0</td>
                    <td class="hidden-phone">Win 95+</td>
                    <td class="center hidden-phone">4</td>
                    <td class="center hidden-phone">X</td>
                  </tr-->
                  <tr class="gradeC_">
                    <?php
                        $bareme = $db->prepare('SELECT * FROM bdd_paie.t_bareme INNER JOIN bdd_paie.detail_grade_bareme on t_bareme.id_bar=detail_grade_bareme.id_bar INNER JOIN bdd_paie.t_grade ON t_grade.code_grade=detail_grade_bareme.code_grade');
                        $bareme ->execute();
                        while($resbareme=$bareme->fetch()){

                            $id_grade_bar =$resbareme['id_grade_bar'];
                            $grade = $resbareme['code_grade'];
                            $LibelleBar  = $resbareme['LibelleBar'];
                            $Mont = $resbareme['Montant_bar'];
                            $code_devise=$resbareme['code_devise'];
                            $Date_bar = $resbareme['Date_debut'];
                            $statut = $resbareme['statut'];
                            $datebr= $Date_bar;
                        

                    ?>
                    <td> <?php echo  $grade;?> </td>
                    <td> <?php echo  $LibelleBar;?></td>
                    <td class="center hidden-phone"> <?php echo  $Mont;?> </td>
                    <td class="center hidden-phone"> <?php echo  $code_devise;?> </td>
                    <td class="center hidden-phone"> <?php echo $datebr;?> </td>
                    <td class="center">
                    <?php 
                        if($statut == "act"){
                          echo '<i class="fa fa-check-circle fa-lg" style="margin-right: 5px; color:green;width: 25px"></i>';
                        }else{
                          echo '<i class="fa fa-ban fa-lg" style="margin-right: 15px ;color:red;"></i>';
                        }
                      
                      ?>
                    </td>
                   
               
                    <td class="hidden-phone">
                        <!-- Single button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                             <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Edit_bareme_grade&id=<?php echo $id_grade_bar;?>">Modifier</a></li>
                                <li><a href="<?php echo $id_grade_bar;?>">Activer</a></li>
                                <li><a href="<?php echo $id_grade_bar;?>">Désactiver</a></li>
                                <!--li class="divider"></li>
                                <li><a href="#">Separated link</a></li-->
                            </ul>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="accueil.php?page=Edit_bareme_grade&id=<?php echo $id_grade_bar;?>" style="color:darkblue"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Modifier</a></li>
                                <li class="divider"></li>
                                <li><a href="Update_bareme_grade.php?code_bareme_act=<?php echo $id_grade_bar;?>" style="color:green" > <i class="fa fa-check-circle" style="margin-right: 2px;"></i> Activer</a></li>
                                <li><a href="Update_bareme_grade.php?code_bareme_desac=<?php echo $id_grade_bar;?>" style="color:red"> <i class="fa fa-ban" style="margin-right: 2px;"></i> Désactiver</a></li>
                                
                            </ul>
                        </div>
                        <!-- Single button -->
                    </td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- page end-->
        </div>
        <!-- /row -->