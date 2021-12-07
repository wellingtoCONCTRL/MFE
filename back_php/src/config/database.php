<?php
    class Database {
        public static function getConnection() {

            $envPath = realpath(dirname(__FILE__).'/../env.ini');
            $env = parse_ini_file($envPath);    
            //echo extension_loaded('pgsql') ? 'yes':'no'; 
            $conn = pg_connect("host={$env['host']} 
                        port={$env['port']} 
                        dbname={$env['dbname']} 
                        user={$env['user']} 
                        password={$env['password']}");
                                
            if(!$conn){
                die ("Conexão falhou..., ");
            }
            return $conn;
        }

        public static function getResultFromQuery($sql){
            $conn = self::getConnection();
            $result = pg_query($conn, $sql);
            @pg_close($conn);
            return $result;
        }

        public static function executeSQL($sql){
            $conn = self::getConnection();
            $result = pg_query($conn, $sql);
            if(!$result){
                throw new Exception(pg_last_error($conn));
            }
            $id = pg_last_oid($result);
            @pg_close($conn);
            return $id;
        }
    }
?>