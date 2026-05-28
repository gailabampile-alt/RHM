<?php
    session_start();
    /*$id_user = '';
    *if(isset($_GET['id_user'])){
    *  $id_user = $_GET['id_user'];
    *};
    */

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
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

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
      <form class="form-login" method="POST" action="sys_creation_mot_dePasse.php">
          <?php if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="alert">×</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
            </div>
          <?php } ?>
        <h2 class="form-login-heading">Nouveau Mot de passe </h2>
        <div class="login-wrap">
          <!--input type="hidden" id_user="token" value="<?php //$id_user; ?>" name="id_user"-->
          <input type="text" class="form-control" placeholder="Saisir votre nom d'utilisateur" name="user" autofocus>
          <br>
          <input type="password" class="form-control" placeholder="mot de passe récu par mail" name="token">
          <br>
          <input type="password" class="form-control" placeholder="Nouveau mot de passe" name="passwords1">
          <br>
          <input type="password" class="form-control" placeholder="Confirmation mot de passe" name="passwords2">
          <!--label class="checkbox">
            <input type="checkbox" value="remember-me">
            <span class="pull-right">
            <a data-toggle="modal" href="login.html#myModal"> Mot de Passe Oublier?</a>
            </span>
          </label-->
          <br/><br/>
          <button class="btn btn-theme btn-block" type="submit" name="changePasse"><i class="fa fa-lock" style="margin-right: 5px;"> </i>  Changer</button>
          <hr>
          <!--div class="login-social-link centered">
            <p>or you can sign in via your social network</p>
            <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>
            <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>
          </div-->
          <div class="registration">
            Si vous étez sur la presente page c'est-à-dire que votre compte n'est pas validé ou que votre compte soit expiré, 
            il vous faut donc définir un nouveau mot de passe pour plus de sécurité.<br/><br/>
            <!--a class="" href="#">
              Joindre l'administrateur
              </a-->
          </div>
        </div>
        <!-- Modal>
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Mot de passe Oublier? </h4>
              </div>
              <div class="modal-body">
                <p>Entrer votre adresse mail professionnel.</p>
                <input type="text" name="email" placeholder="exemple@cadeco.cd" autocomplete="off" class="form-control placeholder-no-fix">
              </div>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Annuler</button>
                <a href="#" class="btn btn-theme" type="button">Réinitialiser votre compte</a>
              </div>
            </div>
          </div>
        </div>
        <modal -->
      </form>
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
