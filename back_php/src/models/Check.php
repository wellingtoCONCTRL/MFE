<?php
  
    class Check extends Model {

        public function validate() {
            $goBack = 0;
            try {
                existsOrError($this->email, 'Informe o E-MAIL.');
                validEmail($this->email, 'E-MAIL invalido.');
                existsOrError($this->password, 'Informe a SENHA.');
                $goBack = 1;
            } catch (Exception $msg) {
                http_response_code(400);
                echo  $msg->getMessage();
            } 
            return $goBack;
        }

        public function checkLogin() {
            if($this->validate() === 1){
                $user = User::getOne(['email' => $this->email]);
                if($user) {
                    if($user->end_date){
                        http_response_code(400);
                        echo  'Usuário esta desligado da empresa.';
                    }
                    if(password_verify($this->password, trim($user->password))) {
                        return $user;
                    }else{
                        http_response_code(400);
                        echo  'Senha invalida...';
                       
                    }
                }else{
                    http_response_code(400);
                    echo  'Usuário não cadastrado.';
                }
            } 
            die();   
        }

    }

?>    