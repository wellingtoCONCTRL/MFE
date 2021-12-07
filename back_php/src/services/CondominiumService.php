<?php

    $methods = $_SERVER['REQUEST_METHOD'];
    //var_dump($methods);

    if($methods === 'GET') { //Lista os condominios
        if (strtoupper($_GET['filter']) === 'TODOS'){
            $condominiums = Condominium::get();
        }elseif (strtoupper($_GET['filter']) != '') {
            $filtro = trim($_GET['filter']);
            if(ctype_upper($filtro)){
                $filtroUP = strtolower($filtro);    
            }else{
                $filtroUP = strtoupper($filtro);
            }
            $condominiums = Condominium::get(['raw' => "(bairro LIKE '%".$filtro."%' OR 
                                                         logradouro LIKE '%".$filtro."%' OR
                                                         name LIKE '%".$filtro."%' OR
                                                         bairro LIKE '%".$filtroUP."%' OR 
                                                         logradouro LIKE '%".$filtroUP."%' OR
                                                         name LIKE '%".$filtroUP."%') "]);
        }
        $out = json_encode(Condominium::mount_Array($condominiums));
        echo $out;
    }else if($methods === 'POST') {    
        try {
            $data = file_get_contents("php://input");
            $objData = json_decode($data);
            $dbCondominium = new Condominium($objData);
            $dbCondominium->insert();
            $out = json_encode(Condominium::mount_Array($dbCondominium));
            echo $out;
        } catch(Exception $e) {
           //echo $e;
        }
    }else if($methods === 'PUT') {
        try {
            $data = file_get_contents("php://input");
            $objData = json_decode($data);
            $dbCondominium = new Condominium($objData);
            $dbCondominium->update();
            $out = json_encode(Condominium::mount_Array($dbCondominium));
            echo $out;
        } catch(Exception $e) {
           //echo $e;
        }    
    }else if($methods === 'DELETE') {
        try { 
            Condominium::deleteById($_GET['id']);
            echo '[{}]';
        } catch(Exception $e) {
           //echo $e;
        }            

    } else {    
        loadWarning('Requisição invalida...');
    }
   

    //*/


?>