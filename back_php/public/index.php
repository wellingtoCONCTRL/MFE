<?php
    //phpinfo(); /*
    
    require_once(dirname(__FILE__, 2) . '/src/config/required.php');

    $uri = urldecode(
        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
    );
    
    if($uri === '/' || $uri === '' || $uri === '/index.php'){
        loadWarning('URL invalida...');
    }else{
        require_once(SERVICE_PATH . "/{$uri}".".php");
    }


    //*/
?>