<?php

   setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
   date_default_timezone_set("America/Fortaleza");

   header('Content-Type: text/html; charset=UTF-8');
   header("Access-Control-Allow-Origin: *");
   header('Access-Control-Allow-Credentials: true');
   header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
   header("Access-Control-Allow-Headers: Authorization, Content-Type,Accept, Origin");
   
   error_reporting(6135);

   function escape_array($vetor){
      for ($i = 0; $i < count($vetor); $i++) {
         if (!is_array($vetor[$i])) {
            $vetor[$i] = pg_escape_string($vetor[$i]);
         } else {
            $vetor[$i] = escape_array($vetor[$i]);
         }
      }
      return $vetor;
   }

   foreach ($_POST as $campoPost => $valItemPost) {
      if (!is_array($valItemPost)) {
         $_POST[$campoPost] = pg_escape_string($valItemPost);
      } else {
         $_POST[$campoPost] = escape_array($valItemPost);
      }
   }

   foreach ($_GET as $campoGet => $valItemGet) {
      if (!is_array($valItemGet)) {
         $_GET[$campoGet] = pg_escape_string($valItemGet);
      } else {
         $_GET[$campoGet] = escape_array($valItemGet);
      }
   }

   // Pastas

   define('MODEL_PATH', realpath(dirname(__FILE__) . '/../models'));
   define('SERVICE_PATH', realpath(dirname(__FILE__) . '/../services'));

   // Arquivos
   require_once(realpath(dirname(__FILE__) . '/database.php'));
   require_once(realpath(dirname(__FILE__) . '/loader.php'));
   require_once(realpath(dirname(__FILE__) . '/validate.php'));
   require_once(realpath(MODEL_PATH . '/Model.php'));
   require_once(realpath(MODEL_PATH . '/User.php'));
   require_once(realpath(MODEL_PATH . '/Condominium.php'));
   require_once(realpath(MODEL_PATH . '/Check.php'));

?>