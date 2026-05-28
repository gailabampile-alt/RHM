<?php
session_start();

try {
    require_once('sys_connexion.php');
    require_once('sys_fonction.php');

    if (isset($_POST['printBy'])) {
        $devise = validation_donnees($_POST['devise'] ?? '');
        $siege = validation_donnees($_POST['siege'] ?? '');
        $periode = validation_donnees($_POST['periode'] ?? '');

        if ($devise === '') {
            $_SESSION['message'] = 'Operation echouee : veuillez choisir une devise';
            $_SESSION['typeMsg'] = 'danger';
            header('location:accueil.php?page=Pret_Print');
            exit();
        }

        $params = array(
            'devise' => $devise,
        );

        if ($siege !== '') {
            $params['siege'] = $siege;
        }

        if ($periode !== '') {
            $params['periode'] = $periode;
        }

        header('location:print_pret.php?' . http_build_query($params));
        exit();
    }
} catch (PDOException $ex) {
    $_SESSION['message'] = 'Erreur : ' . $ex->getMessage();
    $_SESSION['typeMsg'] = 'danger';
    header('location:accueil.php?page=FP-OP-PC-MS-BC');
    exit();
}
?>
