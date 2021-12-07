<?php

    //Lista as quantidades de usuários e condominiums para componete menu    
    if(isset($_GET)) {
        if (strtoupper($_GET['status']) === 'A'){
            $usercount = User::getActiveUsersCount();
        }elseif (strtoupper($_GET['status']) === 'D') {    
            $usercount = User::getDesativeUsersCount();
        }    
        if ($usercount === null) { $usercount = 0;}
        $count = array("users" => $usercount);
        $out = json_encode($count);
    }else{
        loadWarning('Requisição invalida...');
    }
    echo $out;

    //*/
    
?>