
<?php
function date_fr($dateSql)
{
    if (empty($dateSql)) {
        return "";
    }

    // Tableau des mois en français
    $mois = [
        "01" => "janvier",
        "02" => "février",
        "03" => "mars",
        "04" => "avril",
        "05" => "mai",
        "06" => "juin",
        "07" => "juillet",
        "08" => "août",
        "09" => "septembre",
        "10" => "octobre",
        "11" => "novembre",
        "12" => "décembre"
    ];

    $timestamp = strtotime($dateSql);

    $jour = date("d", $timestamp);
    $moisNum = date("m", $timestamp);
    $annee = date("Y", $timestamp);

    return $jour . " " . $mois[$moisNum] . " " . $annee;
}
?>
