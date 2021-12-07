<?php
    
    $methods = $_SERVER['REQUEST_METHOD'];

    if($methods === 'POST') {    
        $data = file_get_contents("php://input");
        $objData = json_decode($data);
        $check = new Check($objData);
        try {
            $user = $check->checkLogin();
            $out = json_encode(User::mount_row($user));
            echo $out;
        } catch(Exception $e) {
           //echo $e;
        }
    }    

?>