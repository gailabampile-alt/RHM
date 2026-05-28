<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>PAC - Software</title>

  <!-- Favicons -->
  <link href="img/logo_hrm_icon.png" rel="icon">
  <link href="img/logo_hrm_background (1).jpg" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
  
  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->
</head>

<body>
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
  <div id="login-page">
    <div class="container">
      <form class="form-login" action="sys_login.php" method="POST">
        <?php if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="alert">×</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
            </div>
          <?php } ?>
        <h2 class="form-login-heading">Connexion</h2>
        <div class="login-wrap">
          <input type="text" class="form-control" placeholder="Nom d'utilisateur" name="username" autofocus required>
          <br>
          <input type="password" class="form-control" placeholder="Votre mot de passe" name="passwords" required>
          <label class="checkbox">
            <!--input type="checkbox" value="remember-me"-->
            <span class="pull-right">
              <br>
              <a data-toggle="modal" href="login.html#myModal"> Mot de Passe Oublier?</a>

            </span>
            
          </label>
          <br/><br/>
          <button class="btn btn-theme btn-block" href="#" type="submit" name="login"><i class="fa fa-lock" style="margin-right: 5px;"> </i>  Se Connecter</button>
          <hr>
          <!--div class="login-social-link centered">
            <p>or you can sign in via your social network</p>
            <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>
            <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>
          </div-->
          <div class="registration">
            Si vous n'avez pas de compte professionnel veuillez contacter votre administrateur<br/><br/>
            <a class="" href="#">
              Joindre l'administrateur
              </a>
          </div>
        </div>

      </form>
        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Mot de passe Oublier? </h4>
              </div>
              
              <form method="POST" action="https://mrnuage.com/envoieMail_PAC.php">
                <div class="modal-body">
                  <p>Entrer votre adresse mail professionnel.</p>
                  <input type="email" name="email" placeholder="exemple@cadeco.cd" autocomplete="off" class="form-control placeholder-no-fix">
                </div>
                <div class="modal-footer">
                  <button data-dismiss="modal" class="btn btn-default" type="button">Annuler</button>
                  <button class="btn btn-theme" type="submit" name="submit">Réinitialiser votre compte</button>
                </div>

              </form>
              
            </div>
          </div>
        </div>
        <!-- modal -->
      
    </div>
  </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <!--BACKSTRETCH-->
  <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  <script type="text/javascript" src="lib/jquery.backstretch.min.js"></script>
  <script>
    $.backstretch("img/Guichet.jpg", {
      speed: 500
    });
  </script>
</body>

</html>
