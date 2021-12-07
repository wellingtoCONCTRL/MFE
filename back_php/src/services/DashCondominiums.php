<?php

    //Lista as quantidades de usuários e condominiums para componete menu    
    if(isset($_GET)) {
        $condcount = Condominium::getCount();
        $count = array("condominiums"  => $condcount);
        $out = json_encode($count);
    }else{
        loadWarning('Requisição invalida...');
    }
    echo $out;

    //*/
    
?>