<?php

    if(isset($GET['durer']) && isset($GET['montPreter']) && isset($GET['interet'])){

        $durer = $GET['durer'];
        $montPreter = $GET['montPreter'];
        $interet = $GET['interet'] / 100;

        $solde = $montPreter * $interet;
        $aRetenir = $solde / $durer;


echo '
    
        <label class="col-sm-3 control-label">Solde</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="solde" value="<?php echo $solde;?>" readonly>
        </div>
        <label class="col-sm-1 control-label">A Payer</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="aPayer" value="<?php echo $aRetenir;?>" readonly>
        </div>
    ';
    //header('location : accueil.php?page=Pret') ;
    } ?>