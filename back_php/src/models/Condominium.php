<?php
    class Condominium extends Model {
        protected static $tableName = 'condominiums';
        protected static $columns = ['id', 
                                     'cnpj_cpf', 
                                     'name', 
                                     'logradouro', 
                                     'bairro', 
                                     'cep', 
                                     'cidade',
                                     'uf',
                                     'email'
        ];

        public static function getActiveCondsCount() {
            return static::getCount();
        }

        public static function mount_Array($object = array()){
            foreach($object as $cond) {
                $item[] = array(
                    "id" => $cond->id,
                    "cnpj_cpf" => $cond->cnpj_cpf,
                    "name" => $cond->name,
                    "logradouro" => $cond->logradouro,
                    "bairro" => $cond->bairro,
                    "cep" => $cond->cep,
                    "cidade" => $cond->cidade,
                    "uf" => $cond->uf,
                    "email" => $cond->email
                );
              
            }
            return $item; 
        }

        public function insert() {
            if($this->validate() === 1){
                return parent::insert();
            }
        }

        public function update() {
            if($this->validate() === 1){
                return parent::update();
            }    

        }
    
        private function validate() {
            $goBack = 0;
            try {
                existsOrError($this->cnpj_cpf, 'Informe o CNPJ.');
                existsOrError($this->name, 'Informe o NOME.');
                existsOrError($this->logradouro, 'Informe o LOGRADOURO.');
                existsOrError($this->bairro, 'Informe o BAIRRO.');
                existsOrError($this->cep, 'Informe o CEP.');
                existsOrError($this->cidade, 'Informe o CIDADE.');
                existsOrError($this->uf, 'Informe o UF.');
                if($this->email) { 
                    validEmail($this->email, 'E-MAIL invalido.');
                }    
                $goBack = 1;
            } catch (Exception $msg) {
                http_response_code(400);
                echo  $msg->getMessage();
            } 
            return $goBack;
        }
    

    }

?>