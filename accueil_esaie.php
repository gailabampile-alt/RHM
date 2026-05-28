<?php
	session_start();
    include_once('db_connexion.php');

    if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 1800)) {
        $reqHistorique =  $db->prepare('UPDATE c2076648c_db_cours.tab_historiqueconnexion 
        SET DateDecon = :DateDecon, HeureDecon = :HeureDecon WHERE idHC = :idHC');
        $date = date('y-m-d');
        $reqHistorique->bindvalue(':DateDecon',$date);
        $heure = date('H:i:s');
        $reqHistorique->bindvalue(':HeureDecon',$heure);
        $reqHistorique->bindvalue(':idHC',$_SESSION['idDate_Heure_Act']);
        $reqHistorique->execute();

        session_unset(); 
        session_destroy(); 
        header('location:index.html'); 
        exit();
    }else{
        $_SESSION['start'] = time();
    }

    
    if(!isset($_SESSION['id'])){
        header('location:frm_login.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Course Manager</title>
        <link href="assets1/img/icons8_Medium_32.png" rel="icon" type="image">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet"/>
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!--DataTable-->
        <link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	    <link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">


        <!-- GLOBAL STYLES 
    
    
        <link href="public_html/assets3_select/css/jquery-ui.css" rel="stylesheet" />
        <link rel="stylesheet" href="public_html/assets3_select/plugins/uniform/themes/default/css/uniform.default.css" />
        link rel="stylesheet" href="assets3_1select/plugins/inputlimiter/jquery.inputlimiter.1.0.css" /-->
        <!--link rel="stylesheet" href="public_html/assets3_select/plugins/chosen/chosen.min.css" /-->
        <!--link rel="stylesheet" href="assets3_select/plugins/colorpicker/css/colorpicker.css" /-->
        <!--link rel="stylesheet" href="assets3_select/plugins/tagsinput/jquery.tagsinput.css" />
        <link rel="stylesheet" href="assets3_select/plugins/daterangepicker/daterangepicker-bs3.css" />
        <link rel="stylesheet" href="assets3_select/plugins/datepicker/css/datepicker.css" />
        <link rel="stylesheet" href="assets3_select/plugins/timepicker/css/bootstrap-timepicker.min.css" /-->
        <!--link rel="stylesheet" href="public_html/assets3_select/plugins/switch/static/stylesheets/bootstrap-switch.css" /-->

        <!-- PAGE LEVEL STYLES ONGLET
    <link href="public_html/assets3_select/plugins/jquery-steps-master/demo/css/normalize.css" rel="stylesheet" />
    <link href="public_html/assets3_select/plugins/jquery-steps-master/demo/css/wizardMain.css" rel="stylesheet" />
    <link href="public_html/assets3_select/plugins/jquery-steps-master/demo/css/jquery.steps.css" rel="stylesheet" />    
     END PAGE LEVEL  STYLES ONGLET-->
    </head>
    <body class="sb-nav-fixed" style="font-family:'Corbel','arial';">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <!--a class="navbar-brand ps-3" href="">Course Manager</a-->
            <!--a class="btn order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"href="#"><h4>Course Manager</h4></a-->
            <!-- Sidebar Toggle-->
            <button class="btn btn-info text-light btn-sm order-1 order-lg-0 me-4 me-lg-0 m-2" id="sidebarToggle" href="#"><span class="h5">Course Manager </span class="h5"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <div class="text-warning Bold d-none d-md-inline" style="font-size: 23px; margin-left: 28%;">
            <?php
                
                if(date("h")<18){?>
                    Bonjour  <span class="text-primary " style="font-size: 20px;"> <?php echo ($_SESSION['nom'].' '.$_SESSION['postnom'].' '.strtolower($_SESSION['prenom']));?> </span> </div>
                    <?php } else{ ?>
                    Bonsoir <span class="text-primary" style="font-size: 20px;"> <?php echo ($_SESSION['nom'].' '.$_SESSION['postnom'].' '.ucwords(strtolower($_SESSION['prenom'])));?> </span> </div>

                    <?php }
            
            ?>
            
            <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <!--div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div-->
                
            </div>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Paramètre</a></li>
                        <li><a class="dropdown-item" href="accueil.php?page=Profil">Profil</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="sys_logOut.php">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Accueil</div>
                            <a class="nav-link" href="accueil.php?page=Graphic">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Tableau de Bord
                            </a>
                            <div class="sb-sidenav-menu-heading">Fichier</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Opérations
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="accueil.php?page=Depot_TP_CC">Dépot des Travaux</a>
                                    <a class="nav-link" href="accueil.php?page=Depot_TP_Gr">Dépot Travaux par Groupe</a>
                                    <a class="nav-link" href="accueil.php?page=AjoutEtudiant">Ajouts Etudiants</a>
                                    <a class="nav-link" href="accueil.php?page=AjoutCour">Ajouts Cours</a>
                                    <a class="nav-link" href="accueil.php?page=QuestionReponse">Question / Réponse</a>
                                    <a class="nav-link" href="accueil.php?page=MsgPriver">Msg Privé</a>
                                </nav>
                            </div>
                            <!--2-->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseConsultation" aria-expanded="false" aria-controls="collapseConsultation">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Consultation
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseConsultation" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="accueil.php?page=TelechargerTravaux">Télécharger Un Travail</a>
                                    <a class="nav-link" href="accueil.php?page=voirTravaux">Voir travaux</a>
                                    <a class="nav-link" href="impression_Attestation.php" target="_blank">Attestation</a>
                                    <a class="nav-link" href="frm_siteConstruction.html">Déliberation Sécondaire</a>
                                </nav>
                            </div>
                            <!--3-->
                            <a class="nav-link collapsed" href="frm_siteConstruction.html" data-bs-toggle="collapse" data-bs-target="#collapseTraitement" aria-expanded="false" aria-controls="collapseConsultation">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Traitement
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseTraitement" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="accueil.php?page=Cotation">Cotation</a>
                                    <a class="nav-link" href="frm_siteConstruction.html">Calcul de point</a>
                                    <a class="nav-link" href="accueil.php?page=CorrectionTravaux">Correction Travaux</a>
                                </nav>
                            </div>
                            <!--a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Consultationaaaa
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                    
                                </nav>
                            </div-->
                            <div class="sb-sidenav-menu-heading">Configuration</div>
                            <!--4-->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseConsultation">
                                <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                                Administration
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseAdmin" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="#">Droit_D'acces</a>
                                    <a class="nav-link" href="#">Autres</a>
                                </nav>
                            </div>
                            <!--5-->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePara" aria-expanded="false" aria-controls="collapseConsultation">
                                <div class="sb-nav-link-icon"><i class="fas fas fa-cog"></i></div>
                                Paramètre
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePara" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="#">Profil</a>
                                    <a class="nav-link" href="accueil.php?page=ChangementPassword">Changement Password</a>
                                </nav>
                            </div>
                            
                        </div>
                    </div>
                    <!--div class="sb-sidenav-footer">
                        <div class="small">Connecter en tant que :</div>
                        Profil Connecter
                    </div-->
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <!--Mon Code-->
                <?php
        switch (@$_GET['page']) {
            
            case 'Graphic':include('Graphic.php');break;
            case 'Depot_TP_CC':include('frm_Depot_TP_CC.php');break;
            case 'Depot_TP_Gr':include('frm_depot_tp_gr.php');break;
            case 'AjoutEtudiant':include('frm_etudiant.php');break;
            case 'AjoutCour':include('frm_cours.php');break;
            case 'QuestionReponse':include('frm_message_QR.php');break;
            case 'MsgPriver':include('frm_msg_prive.php');break;
            case 'EditionEtudiant':include('frm_etudiant_edit.php');break;
            case 'EditEtudiant':include('frm_etudiant_edit.php');break;
            case 'TelechargerTravaux':include('frm_telechargerTravaux.php');break;
            case 'Cotation':include('frm_cotation.php');break;
            case 'ListeTravauxGr':include('frm_listeTravauxGr.php');break;
            case 'ChangementPassword':include('frm_changePassword.php');break;
            case 'Ajout_Travaux':include('frm_ajoutTravaux.php');break;
            case 'ListeCour':include('frm_cours_Liste.php');break;
            case 'voirTravaux':include('frm_voirTravaux.php');break;
            case 'CoursEdit':include('frm_cours_Edit.php');break;
            case 'Profil':include('frm_profil.php');break;
            case 'CorrectionTravaux':include('frm_correctionTravaux.php');break;
            //case 'change_Mot_passe':include('change_Mot_passe.php');break;
            //case 'Agent':include('Agent.php');break;
            //case 'Historie_Op':include('Historique_Op.php');break;
            //case 'ListeDeRapport':include('ListeDeRapport.php');break;
            //case 'Virement':include('Virement.php');break;
            default:include('Graphic.php');break;
               
        }
       
        ?>
        <!--Mon Code Fin-->
                <footer class="py-4 bg-light mt-auto bg-dark">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            
                            <div class="text-primary" style="margin-left: auto;margin-right: auto;">Copyright &copy; Ir Gamaliel M. 2022 - 2023</div>
                            <!--div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div-->
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <!--script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script-->
        <!-- js -->
        <script src="vendors/scripts/core.js"></script>
        <script src="vendors/scripts/script.min.js"></script>
        <script src="vendors/scripts/process.js"></script>
        <script src="vendors/scripts/layout-settings.js"></script>
        <script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
        <script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
        <script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
        <!-- buttons for Export datatable -->
        <script src="src/plugins/datatables/js/dataTables.buttons.min.js"></script>
        <script src="src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
        <script src="src/plugins/datatables/js/buttons.print.min.js"></script>
        <script src="src/plugins/datatables/js/buttons.html5.min.js"></script>
        <script src="src/plugins/datatables/js/buttons.flash.min.js"></script>
        <script src="src/plugins/datatables/js/pdfmake.min.js"></script>
        <script src="src/plugins/datatables/js/vfs_fonts.js"></script>
        <!-- Datatable Setting js -->
        <script src="vendors/scripts/datatable-setting.js"></script>
        
        <!-- GLOBAL SCRIPTS ONGLET
        <script src="assets3_select/plugins/jquery-2.0.3.min.js"></script>
        <script src="assets3_select/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets3_select/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
         END GLOBAL SCRIPTS -->
        <!-- PAGE LEVEL SCRIPTS
        <script src="assets3_select/plugins/jquery-steps-master/lib/jquery.cookie-1.3.1.js"></script>
        <script src="assets3_select/plugins/jquery-steps-master/build/jquery.steps.js"></script>   
        <script src="assets3_select/js/WizardInit.js"></script>
         END PAGE LEVEL SCRIPTS ONGLET -->

        <!-- Entrée de selection--><!-- Entrée de selection--><!-- Entrée de selection-->

        
        <script>
            $(function () { formInit(); });
        </script>
        <!-- Entrée de selection--><!-- Entrée de selection--><!-- Entrée de selection-->

         
    </body>
</html>
