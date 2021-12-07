<?php

    $methods = $_SERVER['REQUEST_METHOD'];
    //var_dump($methods);

    if($methods === 'GET') { //Lista os usuários   
        $users = User::get();
        $out = json_encode(User::mount_Array($users));
        echo $out;
    }else if($methods === 'POST') { //Insere usuário   
        try {
            $data = file_get_contents("php://input");
            $objData = json_decode($data);
            $dbUser = new User($objData);
            $dbUser->insert();
            $out = json_encode(User::mount_Array($dbUser));
            echo $out;
        } catch(Exception $e) {
            //echo $e->getMessage();
        }
    }else if($methods === 'PUT') {
        try {
            $data = file_get_contents("php://input");
            $objData = json_decode($data);
            $dbUser = new User($objData);
            $dbUser->update();
            $out = json_encode(User::mount_Array($dbUser));
            echo $out;
        } catch(Exception $e) {
            //echo $e->getMessage();
        }    
    }else if($methods === 'DELETE') {
        try { 
            User::deleteById($_GET['id']);
            echo '[{}]';
        } catch(Exception $e) {
            //echo $e->getMessage();
        }            

    } else {    
        loadWarning('Requisição invalida...');
    }
   

    //*/


?>