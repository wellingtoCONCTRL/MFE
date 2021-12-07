<?php
    class User extends Model {
        protected static $tableName = 'users';
        protected static $columns = ['id', 
                                     'name', 
                                     'password', 
                                     'email', 
                                     'start_date', 
                                     'end_date', 
                                     'is_admin'
        ];

        public static function getActiveUsersCount() {
            return static::getCount(['raw' => 'end_date IS NULL']);
        }

        public static function getDesativeUsersCount() {
            return static::getCount(['raw' => 'end_date IS NOT NULL']);
        }

        public static function mount_row($obj){
                $item = array(
                    "id" => $obj->id,
                    "name" => $obj->name,
                    "email" => $obj->email,
                    "start_date" => $obj->start_date,
                    "end_date" => $obj->end_date,
                    "is_admin" => $obj->is_admin
                );
            return $item; 
        }

        public static function mount_Array($object = array()){
            foreach($object as $user) {
                $user->start_date = (new DateTime($user->start_date))->format('d/m/Y');    
                if($user->end_date) {
                    $user->end_date = (new DateTime($user->end_date))->format('d/m/Y');
                }
                $item[] = array(
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "start_date" => $user->start_date,
                    "end_date" => $user->end_date,
                    "is_admin" => $user->is_admin
                );
            }
            return $item; 
        }

        public function insert() {
            if($this->validate() === 1){
                $this->is_admin = $this->is_admin ? 't' : 'f';
                $this->password = password_hash($this->password, PASSWORD_DEFAULT);
                if(!$this->end_date) $this->end_date = null;
                return parent::insert();
            }
        }

        public function update() {
            if($this->validate() === 1){
                $this->is_admin = $this->is_admin ? 't' : 'f';
                if(!$this->end_date) $this->end_date = null;
                $this->password = password_hash($this->password, PASSWORD_DEFAULT);
                return parent::update();
            }    
        }

        private function validate() {
            $goBack = 0;
            try {
                existsOrError($this->name, '[Informe o NOME.]');
                existsOrError($this->email, 'Informe o E-MAIL.');
                validEmail($this->email, '[E-MAIL invalido.]');
                existsOrError($this->password, 'Informe a SENHA.');
                existsOrError($this->confirmPassword, 'CONFIRME a Senha.');
                equalsOrError($this->password, $this->confirmPassword, 'As senhas não são iguais.');
                existsOrError($this->start_date, 'Informe a data de ADMISSÃO.');
                $goBack = 1;
            } catch (Exception $msg) {
                http_response_code(400);
                echo  $msg->getMessage();
            } 
            return $goBack;
        }    
    }

?>