<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['printBy'])){
            $matricule = validation_donnees($_POST['matric']);
            $periode = validation_donnees($_POST['periode']);

            if(!empty($devise) && !empty($periode))
            {
                if($devise == "CDF"){
                    try {
                        header('location:print_declaration.php?matric='.$matricule.'&periode='.$periode);
                        exit();
        
                      } catch (PDOException $e) {
                        //echo "Erreur: " . $e->getMessage();
                        $_SESSION['message']  = "Opération Echouer  : ".$e->getMessage();
                        $_SESSION['typeMsg']  = "danger";
                        header('location:accueil.php?page=Pret_Print');
                        exit();
                      }

                }elseif ($devise == "USD") {
                    try {
                        header('location:print_pret_USD.php?devise='.$devise.'&siege='.$siege.'&periode='.$periode);
                        exit();
        
                      } catch (PDOException $e) {
                        //echo "Erreur: " . $e->getMessage();
                        $_SESSION['message']  = "Opération Echouer  : ".$e->getMessage();
                        $_SESSION['typeMsg']  = "danger";
                        header('location:accueil.php?page=Pret_Print');
                        exit();
                      }
                    
                }elseif($devise == "CDF&USD"){
                    try {
                        header('location:print_pret_CDF&USD.php?devise='.$devise.'&siege='.$siege.'&periode='.$periode);
                        exit();
        
                      } catch (PDOException $e) {
                        //echo "Erreur: " . $e->getMessage();
                        $_SESSION['message']  = "Opération Echouer  : ".$e->getMessage();
                        $_SESSION['typeMsg']  = "danger";
                        header('location:accueil.php?page=Pret_Print');
                        exit();
                      }

                }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez saisir un siège";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Pret_Print');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=FP-OP-PC-MS-BC');
        exit();
        
    }


