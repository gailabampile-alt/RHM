<?php
	  session_start();
    include_once('sys_connexion.php');
    //include_once('sys_fonction.php');
    function getInfo_conger($bdd,$statut,$etat){
      $reqInfoConger = $bdd->prepare("SELECT * FROM bdd_paie.t_demandeconge 
      WHERE statut = :statut AND etat = :etat");
      $reqInfoConger ->bindValue(':statut',$statut);
      $reqInfoConger ->bindValue(':etat',$etat);
      $reqInfoConger ->execute();
      $nombre = $reqInfoConger->rowCount();
      return $nombre;
      
  }
  ini_set('max_execution_time', 100); // en secondes

    /*if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 100)) {
      $_SESSION['page'] = @$_GET['page'];
      header('location:lock_screen');
      exit();
    }*/
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        $reqHistorique =  $db->prepare('UPDATE bdd_paie.t_historique_conn 
        SET date_decon = :date_decon, heure_decon = :heure_decon WHERE id_histori_con = :id_histori_con');
        $date = date('y-m-d');
        $reqHistorique->bindvalue(':date_decon',$date);
        $heure = date('H:i:s');
        $reqHistorique->bindvalue(':heure_decon',$heure);
        /*$reqHistorique->bindvalue(':idHC',$_SESSION['idDate_Heure_Act']);*/
        $reqHistorique->bindvalue(':id_histori_con',$_SESSION['id_histori_con']);
        $reqHistorique->execute();
    
        session_unset();
        session_destroy(); 
        header('location:index.php'); 
        exit();
    }else{
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    
    if(!isset($_SESSION['id_utilisateur'])){
        header('location:index.php');
        exit;
    }
?>
<!-- EMPECHE LE GRAPHIC D AFFICHER LIGNE 461-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="MAWESI MUSHWEY GAMALIEL & BAMPILE TSHIZANGA GAILA">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>RH - Management</title>

  <!-- Favicons >
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon"-->
  <link href="img/logo_hrm_icon.png" rel="icon">
  <link href="img/logo_hrm_background (1).jpg" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="lib/bootstrap-fileupload/bootstrap-fileupload.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-datepicker/css/datepicker.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-timepicker/compiled/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-datetimepicker/datertimepicker.css" />

  
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">

  <link href="lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
  <link href="lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
  <link rel="stylesheet" href="lib/advanced-datatable/css/DT_bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">

  <link rel="stylesheet" href="assets/plugins/chosen/chosen.min.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
  

<!-- Bootstrap core CSS -->

  <!--external css-->
  
  <style>
        /* styles.css */
        .boite {
            display: none; /* Cacher toutes les divs par défaut */
        }

        .boite.active {
            display: block; /* Afficher la div active */
        }
      /* SWITCH MODERNE  CKECKBOX A UTILISER*/ 
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        .switch input:checked + .slider {
            background-color: #28a745; /* vert */
        }

        .switch input:checked + .slider:before {
            transform: translateX(24px);
        }
    </style>





  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->
</head>

<body>
  <section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg">
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
      <!--logo start-->
      <a href="index.html" class="logo"><b>HR<span>-M<span style="text-transform: lowercase;">anagement</span></span></b></a>
      <!--logo end-->
      <!--div class="nav notify-row" id="top_menu">
        
      </div-->
      <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
          <!-- settings start -->
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <i class="fa fa-tasks"></i>
              <span class="badge bg-theme"> <?php echo getInfo_conger($db,'naprv','act')?> </span>
              </a>
            <ul class="dropdown-menu extended tasks-bar">
              <div class="notify-arrow notify-arrow-green"></div>
              <li>
                <p class="green">Tâche en cours</p>
              </li>
              <li> 
                <a href="accueil.php?page=voir_demande_conge">
                  <div class="task-info">
                    <div class="desc">Démande en attente</div>
                    <div class="percent">
                      <?php echo getInfo_conger($db,'naprv','act')?>
                    </div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo getInfo_conger($db,'naprv','act')?>%">
                      <span class="sr-only">40% Complete (success)</span>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="accueil.php?page=voir_conger_autorise">
                  <div class="task-info">
                    <div class="desc">Démande Autoriser</div>
                    <div class="percent">
                      <?php echo getInfo_conger($db,'auto','act')?>
                    </div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo getInfo_conger($db,'auto','act')?>%">
                      <span class="sr-only">60% Complete (warning)</span>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="accueil.php?page=voir_conger_refuse">
                  <div class="task-info">
                    <div class="desc">Démande Annuler</div>
                    <div class="percent"><?php echo getInfo_conger($db,'nauto','desac')?></div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo getInfo_conger($db,'nauto','desac')?>%">
                      <span class="sr-only">80% Complete</span>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="accueil.php?page=voir_conge">
                  <div class="task-info">
                    <div class="desc">Congé en cours</div>
                    <div class="percent"><?php echo getInfo_conger($db,'encours','act')?></div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo getInfo_conger($db,'encours','act')?>%">
                      <span class="sr-only">70% Complete (Important)</span>
                    </div>
                  </div>
                </a>
              </li>
              <li class="external">
                <a href="#">Congé</a>
              </li>
            </ul>
          </li>
          <!-- settings end -->
          <!-- inbox dropdown start-->
          <!--li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <i class="fa fa-envelope-o"></i>
              <span class="badge bg-theme">5</span>
              </a>
            <ul class="dropdown-menu extended inbox">
              <div class="notify-arrow notify-arrow-green"></div>
              <li>
                <p class="green">Vous avez 5 nouveaux messages</p>
              </li-->
              <!--li>
                <a href="index.html#">
                  <span class="photo"><img alt="avatar" src="img/ui-zac.jpg"></span>
                  <span class="subject">
                  <span class="from">Zac Snider</span>
                  <span class="time">Just now</span>
                  </span>
                  <span class="message">
                  Hi mate, how is everything?
                  </span>
                  </a>
              </li>
              <li>
                <a href="index.html#">
                  <span class="photo"><img alt="avatar" src="img/ui-divya.jpg"></span>
                  <span class="subject">
                  <span class="from">Divya Manian</span>
                  <span class="time">40 mins.</span>
                  </span>
                  <span class="message">
                  Hi, I need your help with this.
                  </span>
                  </a>
              </li>
              <li>
                <a href="index.html#">
                  <span class="photo"><img alt="avatar" src="img/ui-danro.jpg"></span>
                  <span class="subject">
                  <span class="from">Dan Rogers</span>
                  <span class="time">2 hrs.</span>
                  </span>
                  <span class="message">
                  Love your new Dashboard.
                  </span>
                  </a>
              </li>
              <li>
                <a href="index.html#">
                  <span class="photo"><img alt="avatar" src="img/ui-sherman.jpg"></span>
                  <span class="subject">
                  <span class="from">Dj Sherman</span>
                  <span class="time">4 hrs.</span>
                  </span>
                  <span class="message">
                  Please, answer asap.
                  </span>
                  </a>
              </li-->
              <!--li>
                <a href="index.html#">Voir tous les messages</a>
              </li>
            </ul>
          </li-->
          <!-- inbox dropdown end -->
          <!-- notification dropdown start-->
          <!--li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
              <i class="fa fa-bell-o"></i>
              <span class="badge bg-warning">7</span>
              </a>
            <ul class="dropdown-menu extended notification">
              <div class="notify-arrow notify-arrow-yellow"></div>
              <li>
                <p class="yellow">You have 7 new notifications</p>
              </li>
              <li>
                <a href="index.html#">
                  <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                  Server Overloaded.
                  <span class="small italic">4 mins.</span>
                  </a>
              </li>
              <li>
                <a href="index.html#">
                  <span class="label label-warning"><i class="fa fa-bell"></i></span>
                  Memory #2 Not Responding.
                  <span class="small italic">30 mins.</span>
                  </a>
              </li>
              <li>
                <a href="index.html#">
                  <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                  Disk Space Reached 85%.
                  <span class="small italic">2 hrs.</span>
                  </a>
              </li>
              <li>
                <a href="index.html#">
                  <span class="label label-success"><i class="fa fa-plus"></i></span>
                  New User Registered.
                  <span class="small italic">3 hrs.</span>
                  </a>
              </li>
              <li>
                <a href="index.html#">See all notifications</a>
              </li>
            </ul>
          </li-->
          <!-- notification dropdown end -->
        </ul>
        <!--  notification end -->
      </div>



      <div class="top-menu">
        <ul class="nav pull-right top-menu">
          <li><a class="logout" href="sys_logOut.php">Quiiter</a></li>
        </ul>
      </div>
    </header>
    <!--header end-->
    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion" style="overflow-y: auto;">
          <p class="centered"><a href="#"><img src="img/Logo CADECO1.jpg" class="img-circle" width="80"></a></p>
          <h5 class="centered"> <?php echo $_SESSION['nomComplet'] ?> </h5>
          <li class="mt">
            <a class="active" href="accueil.php?page=Profile">
              <i class="fa fa-dashboard"></i>
              <span>Accueil</span>
              </a>
              
          </li>

          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-bar-chart-o"></i>
              <span>Graphique</span>
              </a>
            <ul class="sub">
              <li><a href="accueil.php?page=Graphic_ActiviteAgent">Statut</a></li>
              <li><a href="accueil.php?page=Graphic_PlanningRetraite">Admition à la Retraite</a></li>
              <li><a href="accueil.php?page=Graphic_masseSal">Masse Salariale</a></li>
              <!--li><a href="accueil.php?page=">Calcul-Rentrée Scolaire</a></li>
              <li><a href="accueil.php?page=">Advanced Table</a></li-->
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-floppy-o"></i>
              <span>Enregistrement</span>
              </a>
            <ul class="sub">
            <li class="sub-menu"><a href="#"><i class="fa fa-users"></i>Agent</a>
                <ul class="sub">
                  <li><a href="accueil.php?page=Voir_Agent">Signalitique</a></li>
                  <li><a href="accueil.php?page=Voir_Documents">Documents</a></li>
                  <li><a href="accueil.php?page=Enfant">Enfants</a></li>
                  <li><a href="accueil.php?page=Voir_conjoint">Conjoint(e)</a></li>
                  <li><a href="accueil.php?page=Voir_Vehicule">Véhicule</a></li>
                  <li><a href="accueil.php?page=Carriere">Gestion de Carrière</a></li>
                  <li class="sub-menu">
                    <a href="javascript:;">
                      <!--i class="fa fa-th"></i-->
                      <span>Gestion de Congé</span>
                      </a>
                    <ul class="sub">
                    <li><a href="accueil.php?page=Demande_Conger">Demande</a></li>
                      <li><a href="accueil.php?page=voir_demande_conge">Traitement Demande</a></li>
                      <li><a href="accueil.php?page=Calendrier_Conges">Calendrier</a></li>
                      <li><a href="accueil.php?page=Calendrier_Engagement">Planning engagement</a></li>
                      <li><a href="accueil.php?page=voir_conger_autorise">Congé</a></li>
                      <li><a href="accueil.php?page=voir_conge">Congés Traités</a></li>
                      <li><a href="accueil.php?page=voir_conger_refuse">Congés refusés</a></li>
                    </ul>
                  </li>
                  <li><a href="accueil.php?page=voir_sanction">Action Disciplinaire</a></li>
                </ul>
              </li>
              <li class="sub-menu">
                <a href="javascript:;">
                  <i class="fa fa-users"></i>
                  <span>Stagiaire</span>
                  </a>
                <ul class="sub">
                  <li><a href="accueil.php?page=Voir_Stagiaire">Nouveau</a></li>
                  <!--li><a href="accueil.php?page=Voir_Fonction">Fonction</a></li>
                  <li><a href="accueil.php?page=Voir_Province">Province</a></li>
                  <li><a href="accueil.php?page=Voir_Direction">Direction</a></li>
                  <li><a href="xPrint-Fin copy.php">Direction</a></li-->

                  
                </ul>
              </li>
              <li><a href="accueil.php?page=avance_Interet"><i class="fa fa-money"></i>Avance /Interet</a></li>
              <!--li><a href="accueil.php?page=Voir_Carburant"><i class="fa fa-truck"></i>Carburant</a></li>
              <li><a href="accueil.php?page=Cotations"><i class="fa fa-laptop"></i>Cotations</a></li-->
              <li><a href="accueil.php?page=Pointage"><i class="fa fa-check-square-o"></i>Pointage</a></li>
              <li><a href="accueil.php?page=Voir_Prets"><i class="fa fa-money"></i>Prêt</a></li>
              
            </ul>
          </li>
          
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-th"></i>
              <span>Traitement</span>
              </a>
            <ul class="sub">
              <li><a href="accueil.php?page=Calcul-Paie">Calcul-Paie</a></li>
              <!--li><a href="accueil.php?page=">Calcul-Gratification</a></li>
              <li><a href="accueil.php?page=">Calcul-Rentrée Scolaire</a></li>
              <li><a href="accueil.php?page=">Advanced Table</a></li-->
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-book"></i>
              <span>Editions Chaine Paie</span>
              </a>
            <ul class="sub">
              <li><a href="accueil.php?page=Bulletins">Bulletins</a></li>
              <!--li><a href="accueil.php?page=Codes">Codes</a></li-->
              <!--li><a href="accueil.php?page=Print_CarriereBy">Carrières</a></li-->
              <li><a href="accueil.php?page=Declarations">RELEVES DES RETENUES</a></li>
              <!--li><a href="accueil.php?page=Listes">Listes</a></li-->
              <li><a href="accueil.php?page=FP-OP-PC-MS-BC">ORDRE DE PAIEMENT</a></li>
              <!--li><a href="faq.html">FAQ</a></li>
              <li><a href="404.html">404 Error</a></li>
              <li><a href="500.html">500 Error</a></li-->
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-cog"></i>
              <span>Configuration</span>
              </a>
            <ul class="sub">
              <li><a href="accueil.php?page=Voir_Grade">Grade</a></li>
              <li><a href="accueil.php?page=Voir_Fonction">Fonction</a></li>
              <li><a href="accueil.php?page=Voir_Province">Province</a></li>
              <li><a href="accueil.php?page=Voir_Direction">Direction</a></li>
              <li><a href="accueil.php?page=voir_Code_paie">Code Paie</a></li>
              <li><a href="accueil.php?page=voir_Code_paie_imputation">Code Paie Imputation</a></li>
              <li><a href="accueil.php?page=voir_Bareme">Bareme</a></li>
              
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-cogs"></i>
              <span>Parametre</span>
              </a>
            <ul class="sub">
              <li><a href="accueil.php?page=Utilisateurs">Utilisateurs</a></li>
              <li class="sub-menu"><a href="#">Autres Parametre</a>
                <ul class="sub">
                  <li><a href="accueil.php?page=Voir_alloc_famille">Allocation Familial</a></li>
                  <li><a href="accueil.php?page=Taux">Taux</a></li>
                  <li><a href="accueil.php?page=PrimeDiplome">Prime Diplôme</a></li>
                  <li><a href="accueil.php?page=Type_document">Type Document</a></li>
                  <li><a href="accueil.php?page=Type_conge">Type Conge</a></li>
                  <li><a href="accueil.php?page=voir_Type_sanct">Type Sanction</a></li>
                  <!--li><a href="accueil.php?page=voir_Type_sanct">Chargement Dynamique</a></li-->
                  <li><a href="accueil.php?page=Frm_roleUser">Rôle Utilisateur</a></li>
                  <li><a href="accueil.php?page=associer_droit">Affectation Rôle</a></li>
                 
                </ul>
              </li>
              <li><a href="accueil.php?page=Profil">Profil</a></li>
              <li><a href="accueil.php?page=ChangementPIN">Changement Mot de Passe</a></li>
              <!--li><a href="todo_list.html">Todo List</a></li>
              <li><a href="dropzone.html">Dropzone File Upload</a></li>
              <li><a href="inline_editor.html">Inline Editor</a></li>
              <li><a href="file_upload.html">Multiple File Upload</a></li-->
            </ul>
          </li>
          <!--li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-book"></i>
              <span>Extra Pages</span>
              </a>
            <ul class="sub">
              <li><a href="blank.html">Blank Page</a></li>
              <li><a href="login.html">Login</a></li>
              <li><a href="lock_screen.html">Lock Screen</a></li>
              <li><a href="profile.html">Profile</a></li>
              <li><a href="invoice.html">Invoice</a></li>
              <li><a href="pricing_table.html">Pricing Table</a></li>
              <li><a href="faq.html">FAQ</a></li>
              <li><a href="404.html">404 Error</a></li>
              <li><a href="500.html">500 Error</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-tasks"></i>
              <span>Forms</span>
              </a>
            <ul class="sub">
              <li><a href="form_component.html">Form Components</a></li>
              <li><a href="advanced_form_components.html">Advanced Components</a></li>
              <li><a href="form_validation.html">Form Validation</a></li>
              <li><a href="contactform.html">Contact Form</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-th"></i>
              <span>Data Tables</span>
              </a>
            <ul class="sub">
              <li><a href="basic_table.html">Basic Table</a></li>
              <li><a href="responsive_table.html">Responsive Table</a></li>
              <li><a href="advanced_table.html">Advanced Table</a></li>
            </ul>
          </li>
          <li>
            <a href="inbox.html">
              <i class="fa fa-envelope"></i>
              <span>Mail </span>
              <span class="label label-theme pull-right mail-info">2</span>
              </a>
          </li>
          <li class="sub-menu">
            <a href="javascript:;">
              <i class=" fa fa-bar-chart-o"></i>
              <span>Charts</span>
              </a>
            <ul class="sub">
              <li><a href="morris.html">Morris</a></li>
              <li><a href="chartjs.html">Chartjs</a></li>
              <li><a href="flot_chart.html">Flot Charts</a></li>
              <li><a href="xchart.html">xChart</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-comments-o"></i>
              <span>Chat Room</span>
              </a>
            <ul class="sub">
              <li><a href="lobby.html">Lobby</a></li>
              <li><a href="chat_room.html"> Chat Room</a></li>
            </ul>
          </li>
          <li>
            <a href="google_maps.html">
              <i class="fa fa-map-marker"></i>
              <span>Google Maps </span>
              </a>
          </li-->
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <!--Mon Code-->
        
        <?php
        switch (@$_GET['page']) {
            
            //case 'Graphic':include('Graphic.php');break;
            case 'avance_Interet':include('frm_avance_interet.php');break;
            case 'Bareme':include('frm_bareme.php');break;
            case 'Calcul-Paie':include('frm_calcul_paie.php');break;
            case 'Carburant':include('frm_carburant.php');break;
            case 'Code_Paie_Imputation':include('frm_code_paie_imputation.php');break;
            case 'Code_Paie':include('frm_code_paie.php');break;
            case 'Cotations':include('frm_cotations.php');break;
            case 'Pointage':include('frm_pointage.php');break;
            case 'Pret':include('frm_pret.php');break;
            case 'Pret_Print':include('frm_print_pret.php');break;
            case 'Signalitique':include('frm_signalitique.php');break;
            case 'Documents':include('frm_document_ag.php');break;
            case 'Voir_Documents':include('voir_document_ag.php');break;
            case 'voir_type_conge':include('voir_type_conge.php');break;
            case 'Type_conge':include('frm_type_conge.php');break;
            case 'Edit_type_conge':include('Edit_type_conge.php');break;
            case 'Edit_Documents':include('edit_document_ag.php');break;
            case 'Bulletins':include('frm_print_bulletins.php');break;
            case 'Codes':include('frm_print_codes.php');break;
            //case 'Codes':include('frm_print_codes.php');break;
            case 'Declarations':include('frm_print_declarations.php');break;
            case 'Listes':include('frm_print_listes.php');break;
            case 'Relevers':include('frm_print_relever.php');break;
            case 'Synthese':include('frm_print_synthese.php');break;
            case 'FP-OP-PC-MS-BC':include('frm_print_FP_OP.php');break;
            case 'Tab_Code_Paie':include('frm_tab_code_paie.php');break;
            case 'Utilisateurs':include('frm_Utilisateur.php');break;
            case 'Voir_Utilisateur':include('voir_utilisateur.php');break;
            case 'Edit_Utilisateur':include('edit_utilisateur.php');break;
            case 'voir_Bareme':include('voir_Bareme.php');break;
            case 'Edit_Bareme':include('Edit_Bareme.php');break;
            case 'Edit_CodePaie':include('Edit_CodePaie.php');break;
            case 'Edit_CodePaie_imput':include('Edit_CodePaie_imput.php');break;
            case 'voir_Code_paie':include('voir_Code_paie.php');break;
            case 'voir_Code_paie_imputation':include('voir_Code_paie_imput.php');break;
            case 'voir_Bareme_Grade':include('voir_Bareme_Grade.php');break;
            case 'Bareme_Grade':include('frm_bareme_grade.php');break;
            case 'Edit_bareme_grade':include('Edit_bareme_grade.php');break;
            case 'voir_Avance':include('voir_Avance.php');break;
            case 'Edit_avance_interet':include('Edit_avance_interet.php');break;
            case 'voir_pointage':include('voir_pointage.php');break;
            case 'voir_heures':include('voir_heures.php');break;
            case 'Edit_pointage':include('Edit_pointage.php');break;
            case 'Edit_heures':include('Edit_heures.php');break;
            case 'Edit_Stagiaire_act':include('edit_stagiaire_act.php');break;
            case 'Voir_Agent':include('voir_agent.php');break;
            case 'Edit_Agent':include('edit_agent.php');break;
            case 'Voir_Prets':include('voir_pret.php');break;
            case 'Edit_Prets':include('edit_pret.php');break;
            case 'Voir_Province':include('voir_province.php');break;
            case 'Province':include('frm_province.php');break;
            case 'Edit_Province':include('edit_province.php');break;
            case 'Voir_Grade':include('voir_grade.php');break;
            case 'Grade':include('frm_grade.php');break;
            case 'Edit_Grade':include('edit_grade.php');break;
            case 'Voir_conjoint':include('voir_conjoint.php');break;
            case 'Voir_Fonction':include('voir_fonction.php');break;
            case 'Edit_Fonction':include('edit_fonction.php');break;
            case 'Fonction':include('frm_fonction.php');break;
            case 'Edit_conjoint':include('Edit_conjoint.php');break;
            case 'Voir_Direction':include('voir_direction.php');break;
            case 'Edit_Direction':include('edit_direction.php');break;
            case 'Direction':include('frm_direction.php');break;
            case 'Carriere':include('frm_carriere.php');break;
            case 'Print_CarriereBy':include('frm_print_carriereBy.php');break;
            case 'Autorisation_Conger':include('frm_conger_autorisation.php');break;
            case 'Demande_Conger':include('frm_conger_demande.php');break;
            case 'Voir_conger':include('voir_demande_conger.php');break;
            case 'Disciplinaire':include('frm_discipline.php');break;
            case 'Conjoint':include('frm_conjoint.php');break;
            case 'Profil':include('frm_profil.php');break;
            //case 'Profil':include('graphic.php');break;
            case 'Voir_Carburant':include('voir_carburant.php');break;
            case 'Edit_Carburant':include('edit_carburant.php');break;
            case 'Enfant':include('frm_enfant.php');break;
            case 'Voir_Enfant':include('voir_enfant.php');break;
            case 'Voir_Enfant_for_modif':include('voir_Enfant_for_modif.php');break;
            case 'Edit_Enfant':include('edit_enfant.php');break;
            case 'Vehicule':include('frm_vehicule.php');break;
            case 'Voir_Vehicule':include('voir_vehicule.php');break;
            case 'Edit_Vehicule':include('edit_vehicule.php');break;
            case 'ChangementPIN':include('frm_passwordChange.php');break;
            
            case 'PrimeDiplome':include('frm_prime_diplome.php');break;
            case 'Voir_PrimeDiplome':include('voir_prime_diplome.php');break;
            case 'Edit_PrimeDiplome':include('edit_prime_diplome.php');break;
            //case 'Direction':include('frm_direction.php');break;
            //case 'Direction':include('frm_direction.php');break;
            case 'Siege_Agent':include('voir_agent_siege.php');break;
            //case 'Direction':include('frm_direction.php');break;
            case 'Direction_Agent':include('voir_agent_direction.php');break;
            //case 'Direction':include('frm_direction.php');break;
            case 'Societe_Agent':include('voir_agent_societe.php');break;
            //case 'Direction':include('frm_direction.php');break;
            case 'Grade_Agent':include('voir_agent_grade.php');break;
            //case 'Direction':include('frm_direction.php');break;
            case 'Fonction_Agent':include('voir_agent_fonction.php');break;
            //case 'Direction':include('frm_direction.php');break;
            case 'voir_type_doc':include('voir_type_doc.php');break;
            case 'Activite_Agent':include('voir_agent_activite.php');break;
            //case 'Direction':include('frm_direction.php');break;
            case 'Syndicat_Agent':include('voir_agent_syndicat.php');break;
            //case 'Direction':include('frm_direction.php');break;
            case 'voir_conger_refuse':include('voir_conger_refuse.php');break;
            case 'Edit_type_sanct':include('Edit_type_sanct.php');break;
            case 'voir_Type_sanct':include('voir_type_sanct.php');break;
            case 'Type_sanction':include('frm_type_sanct.php');break;
            case 'Conge':include('frm_Conge.php');break;
            case 'voir_sanction':include('voir_sanction.php');break;
            case 'Edit_discipline':include('Edit_discipline.php');break;
            case 'Voir_conger':include('voir_demande_conger.php');break;
            case 'voir_conge':include('voir_conger.php');break;
            case 'Edit_type_doc':include('Edit_type_doc.php');break;
            case 'Type_document':include('frm_type_doc.php');break;
            case 'voir_conger_autorise':include('voir_conger_autorise.php');break;
            case 'Calendrier_Conges':include('frm_calendrier_conge.php');break;
            case 'Calendrier_Engagement':include('frm_calendrier_engagement.php');break;
            case 'Autorisation_Conger':include('frm_conger_autorisation.php');break;
            case 'Modification_Conger':include('Edit_conger_autorisation.php');break;
            case 'Demande_Conger':include('frm_conger_demande.php');break;
            case 'voir_demande_conge':include('voir_demande_conger.php');break;
            case 'voir_demande':include('voir_demande.php');break;
            case 'voir_conge_autorise':include('voir_conge_autorise.php');break;
            case 'Disciplinaire':include('frm_discipline.php');break;

            case 'frm_stagiaire':include('frm_stagiaire.php');break;
            case 'Voir_Stagiaire':include('voir_stagiaire.php');break;
            case 'Edit_Stagiaire':include('edit_stagiaire.php');break;


            case 'Voir_alloc_famille':include('voir_alloc_famille.php');break;
            case 'Edit_alloc_famille':include('edit_alloc_famille.php');break;
            case 'Frm_alloc_famille':include('frm_alloc_famille.php');break;
          //DATE_FORMAT(dateTaux, '%d-%m-%Y') AS DateFr
            case 'Taux':include('frm_taux.php');break;
            case 'Voir_taux':include('voir_taux.php');break;
            case 'Edit_taux':include('edit_taux.php');break;

            case 'Graphic_ActiviteAgent':include('graph_activiter_agent.php');break;
            case 'Graphic_PlanningRetraite':include('graph_planning_retraite.php');break;
            case 'Graphic_masseSal':include('graph_masseSal.php');break;

            case 'Frm_roleUser':include('frm_roleUser.php');break;
            case 'Voir_roleUser':include('voir_roleUser.php');break;
            case 'Edit_roleUser':include('edit_roleUser.php');break;

            case 'Edit_roleUser':include('edit_roleUser.php');break;
            case 'associer_droit':include('associer_droit.php');break;
            case 'voir_profil_droit':include('voir_profil_droit.php');break;
            case 'Edit_associer_droit':include('Edit_associer_droit.php');break;
            //case 'Frm_roleUser':include('frm_roleUser.php');break;
            case 'Graphic_PlanningRetraite':include('graph_planning_retraite.php');break;
            default : include('graph_historique_con.php');break;
        }
       
        ?>
        <!--Mon Code Fin-->
        
      </section>
    </section>
    <!--main content end-->
    <!--footer start-->
    <footer class="site-footer">
      <div class="text-center">
        <p>
          &copy; Copyrights <strong>CADECO SA.</strong>. Tout Droit Réserver
        </p>
        <div class="credits">
          <!--
            You are NOT allowed to delete the credit link to TemplateMag with free version.
            You can delete the credit link only if you bought the pro version.
            Buy the pro version with working PHP/AJAX contact form: https://templatemag.com/dashio-bootstrap-admin-template/
            Licensing information: https://templatemag.com/license/
          -->
          Créer Par Le<a href="https://templatemag.com/"> Département Informatique.</a>
        </div>
        <a href="index.html#" class="go-top">
          <i class="fa fa-angle-up"></i>
          </a>
      </div>
    </footer>
    <!--footer end-->
  </section>

  <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="lib/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="lib/jquery.ui.touch-punch.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="lib/common-scripts.js"></script>
  <!--script for this page-->
  
  <!--script type="text/javascript" language="javascript" src="lib/advanced-datatable/js/jquery.js"></script-->
  <script type="text/javascript" language="javascript" src="lib/advanced-datatable/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="lib/advanced-datatable/js/DT_bootstrap.js"></script>

  <!--Ajpour script -->

  <script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/plugins/uniform/jquery.uniform.min.js"></script>
<script src="assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>
<script src="assets/plugins/chosen/chosen.jquery.min.js"></script>
<script src="assets/plugins/colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="assets/plugins/tagsinput/jquery.tagsinput.min.js"></script>
<script src="assets/plugins/validVal/js/jquery.validVal.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/daterangepicker/moment.min.js"></script>
<script src="assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="assets/plugins/timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="assets/plugins/switch/static/js/bootstrap-switch.min.js"></script>
<script src="assets/plugins/jquery.dualListbox-1.3/jquery.dualListBox-1.3.min.js"></script>
<script src="assets/plugins/autosize/jquery.autosize.min.js"></script>
<script src="assets/plugins/jasny/js/bootstrap-inputmask.js"></script>
       <script src="assets/js/formsInit.js"></script>
        <script>
            $(function () { formInit(); });
        </script>



<!--<script src="assets/plugins/chosen/chosen.jquery.min.js"></script>-->
<script src="assets/plugins/validationengine/js/jquery.validationEngine.js"></script>
  <script src="assets/plugins/validationengine/js/languages/jquery.validationEngine-en.js"></script>
   <script src="assets/plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js"></script>
 <script src="assets/js/validationInit.js"></script>
 <script>
        $(function () { formValidation(); });
        </script>


  <script type="text/javascript" src="lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="lib/bootstrap-daterangepicker/date.js"></script>
  <script type="text/javascript" src="lib/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script type="text/javascript" src="lib/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
  
  <!--script src="lib/form-component.js"></script--> <!-- EMPECHE LE GRAPHIC D AFFICHER-->
  
  <!--date
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script> -->
  <!--common script for all pages
  <script src="lib/common-scripts.js"></script>-->

<script src="lib/jquery-ui-1.9.2.custom.min.js"></script>
  <script type="text/javascript" src="lib/bootstrap-fileupload/bootstrap-fileupload.js"></script>
  <script type="text/javascript" src="lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


  <script type="text/javascript" src="lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
  <script type="text/javascript" src="lib/bootstrap-daterangepicker/moment.min.js"></script>
  <script type="text/javascript" src="lib/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
  <script src="lib/advanced-form-components.js"></script>

  <script src="assets/js/scripts.js"></script>
  <script src="js/js.js"></script>

  <!--script for this page-->
  <script type="text/javascript">
    
    /* Formating function for row details 
    function fnFormatDetails(oTable, nTr) {
      var aData = oTable.fnGetData(nTr);
      var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
      sOut += '<tr><td>Rendering engine:</td><td>' + aData[1] + ' ' + aData[4] + '</td></tr>';
      sOut += '<tr><td>Link to source:</td><td>Could provide a link here</td></tr>';
      sOut += '<tr><td>Extra info:</td><td>And any further details here (images etc)</td></tr>';
      sOut += '</table>';

      return sOut;
    }
    */

    $(document).ready(function() {
      /*
       * Insert a 'details' column to the table
       */
      var nCloneTh = document.createElement('th');
      var nCloneTd = document.createElement('td');
      nCloneTd.innerHTML = '<img src="lib/advanced-datatable/images/details_open.png">';
      nCloneTd.className = "center";

      $('#hidden-table-info thead tr').each(function() {
        this.insertBefore(nCloneTh, this.childNodes[0]);
      });

      $('#hidden-table-info tbody tr').each(function() {
        this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
      });

      /*
       * Initialse DataTables, with no sorting on the 'details' column
       */
      var oTable = $('#hidden-table-info').dataTable({
        "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [0]
        }],
        "aaSorting": [
          [1, 'asc']
        ]
      });

      /* Add event listener for opening and closing details
       * Note that the indicator for showing which row is open is not controlled by DataTables,
       * rather it is done here
       */
      $('#hidden-table-info tbody td img').live('click', function() {
        var nTr = $(this).parents('tr')[0];
        if (oTable.fnIsOpen(nTr)) {
          /* This row is already open - close it */
          this.src = "lib/advanced-datatable/media/images/details_open.png";
          oTable.fnClose(nTr);
        } else {
          /* Open this row */
          this.src = "lib/advanced-datatable/images/details_close.png";
          oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
        }
      });
    });
  </script>
  
<script>
document.getElementById("btnCalcul").addEventListener("click", function() {
    // Afficher le message
    document.getElementById("messageCalcul").style.display = "block";

    // Changer le texte du bouton immédiatement
    this.value = "Calcul en cours...";

    // Désactiver le bouton après un petit délai (pour laisser le submit partir)
    setTimeout(() => {
        this.disabled = true;
    }, 100);
});
</script>



  </body>

</html>
