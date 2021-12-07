<?php
    class Model {
        protected static $tableName = '';
        protected static $columns = [];
        protected $values = [];

        function __construct($arr, $sanitize = true) {
            $this->loadFromArray($arr, $sanitize); 
        }        

        public function loadFromArray($arr, $sanitize = true) {
            if($arr) {
                //$conn = Database::getConnection();
                foreach($arr as $key => $value) {
                    $cleanValue = $value;
                    if($sanitize && isset($cleanValue)) {
                        $cleanValue = strip_tags(trim($cleanValue));
                        $cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);
                        //$cleanValue = pg_escape_string($conn, $cleanValue);
                    }
                    $this->$key =  $cleanValue;
                }
                //@pg_close($conn);
            }
        }
        
        public function __get($key) {
            return $this->values[$key];
        }

        public function __set($key, $value) {
            $this->values[$key] = $value;

        }

        public function getValues() {
            return $this->values;
        }

        public static function getOne($filters = [], $columns = '*') {
            $class = get_called_class();
            $result = static::getResultSetFromSelect($filters, $columns);
            return $result ? new $class(pg_fetch_assoc($result)) : null;           
        }

        public static function get($filters = [], $columns = '*') {
            $objects = [];
            $result = static::getResultSetFromSelect($filters, $columns);
            if($result) {
                $class = get_called_class();
                while($row = pg_fetch_array($result)) {
                    array_push($objects, new $class($row));
                }
            }
            return $objects;
        }

        public static function getResultSetFromSelect($filters = [], $columns = '*') {
            $sql = "SELECT ${columns} FROM "
                   . static::$tableName
                   . static::getFilters($filters);
            $result = Database::getResultFromQuery($sql);
            if(pg_num_rows($result) === 0) {
                return null;
            } else {
                return $result;
            }
        }

        public function insert() {
            $sql = "INSERT INTO " . static::$tableName . " ("
                . implode(",", static::$columns) . ") VALUES (";
            foreach(static::$columns as $col) {
                $complet = static::getFormatedValue($this->$col);
                if ($complet <> "''"){
                    $sql .= $complet . ",";
                } else {
                    $sql .= "DEFAULT,";
                } 
                
            }
            $sql[strlen($sql) - 1] = ')';
            $id = Database::executeSQL($sql);
            $this->id = $id;
        }

        public function update() {
            $sql = "UPDATE " . static::$tableName . " SET ";
            foreach(static::$columns as $col) {
                if($col <> 'id'){
                    $sql .= " ${col} = " . static::getFormatedValue($this->$col) . ",";
                }    
            }
            $sql[strlen($sql) - 1] = ' ';
            $sql .= "WHERE id = {$this->id}";
            Database::executeSQL($sql);
        }

        public static function getCount($filters = []) {
            $result = static::getResultSetFromSelect(
                $filters, 'count(*) as count');
            $reg =  pg_fetch_assoc($result);

            return $reg['count'];
        }

        public function delete() {
            static::deleteById($this->id);
        }    

        public static function deleteById($id) {
            $sql = "DELETE FROM " . static::$tableName . " WHERE id = {$id}";
            Database::executeSQL($sql);
        }

        private static function getFilters($filters) {
            $sql = '';
            if(count($filters) > 0) {
                $sql .= " WHERE 1 = 1";
                foreach($filters as $column => $value) {
                    if($column == 'raw') {
                        $sql .= " AND ${value}";
                    } else {
                        $sql .= " AND ${column} = " . static::getFormatedValue($value);
                    }    
                }

            }
            return $sql;
        }

        private static function getFormatedValue($value) {
            if(is_null($value)) {
                return "DEFAULT";
            }elseif(gettype($value) === 'string') {
                return "'${value}'";
            }else {
                return $value;
            }
        }
    }
    

?>