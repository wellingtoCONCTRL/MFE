<?php
    function loadModel($modelName){
        require_once(MODEL_PATH . "/{$modelName}.php");
    }

    function loadDados($out = array ()) {
        echo json_encode($out);
    }

    function loadWarning($message = '', $status = 'Error' ){
        $item = array(
            "situacao" => $status,
            "mensagem" => $message
        );
        loadDados($item);    
    }

?>    