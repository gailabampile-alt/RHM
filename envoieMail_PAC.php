<?php
    ini_set('display_errors', 1);
    error_reporting( E_ALL );
    include('sys_fonction.php');
    if(isset($_POST['submit'])){
        $from = "info@mrnuage.com";
        $to = $_POST['email'];//
        $subject = "Réinitialisation Mot de Passe";
        $message = "Votre mot de passe par Défault est : ".mot_de_passe_Aleatoire();
        $headers = "From:" . $from; 
        mail($to,$subject,$message, $headers);

        echo "Un mail a été envoyer dans votre compte";

    }
?>
        <script language="javascript">
                window.close();
            </script>
        
    

