<?php
 session_start();
if ($_POST['type_paie'] == "N") {
    include "traitement_normal.php";
} elseif ($_POST['type_paie'] == "G") {
    include "traitement_normal.php";
} elseif ($_POST['type_paie'] == "R") {
    include "traitement_rentree.php";
} elseif ($_POST['type_paie'] == "V") {
    include "traitement_rente.php";
}else {
    $_SESSION['message']="❌ Type de paie non reconnu ";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Calcul-Paie');
             exit();
}