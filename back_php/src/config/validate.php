<?php

    function existsOrError($value, $msg){
        if(!$value) { throw new Exception($msg); }
        if((is_array($value) && count($value) === 0)) { throw new Exception($msg); }
        if((gettype($value) === 'string' && !trim($value))) { throw  new Exception($msg); }
    }

    function notExistsOrError($value, $msg) {
        try {
            existsOrError($value, $msg);
        } catch (Exception $e) {
            return $e;
        }
        throw new Exception($msg);
    }

    function equalsOrError($valueA, $valueB, $msg) {
        if ($valueA !== $valueB) { throw new Exception($msg); }
    }

    function validEmail($value, $msg){
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) { throw new Exception($msg); }
    }

?>



