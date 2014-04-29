<?php
    /* Central de Comandos do NOTisPAD
     *
     * Essa é a interface usuario servidor.
     * Nesta interface estão presentes funções que permitirão verificar autencidade do usuário, recuperação de informações
     * definir configurações, etc.
     * 
     * OBS: toda comunicação com este arquivo é feita com POST
     *
     * TO-DO definir exatamente o que é este arquivo
     */
    require_once("init.php");
    require_once("functions.php");
    
    /**
    * Costantes para strings.
    */
    $EMAIL = "email";
    $SENHA = "password";
    $TOLKEN = "tolken";
    $SERVER = "http://localhost:8888";
    
    if (!isset($_SESSION[$EMAIL]) or !isset($_SESSION[$TOLKEN])) {
        if (ep($EMAIL) and ep($SENHA)) {
            logar(p($EMAIL), p($SENHA));
        }
    } else {
        if (ep($EMAIL) and ep($SENHA)) {
            logar(p($EMAIL), p($SENHA));
        }
    }
    
    function logar($email, $senha) {
        global $EMAIL;
        global $SENHA;
        global $SERVER;
        global $TOLKEN;
        
        $query = array("function" => "login", $EMAIL => $email, $SENHA => $senha);
        $response = json_decode(sendPost($SERVER.'/login', $query), true);
        $json = '{"sucess": "';
        if (isset($response['sucess']) and $response['sucess'] == 'true') {
            $tolken = setTolken($email);
            if ($tolken) {
                $_SESSION[$EMAIL] = $email;
                $_SESSION[$TOLKEN] = $tolken;
                $json .= 'true';
            } else {
                $json .= 'false';
            }
        } else {
            $json .= 'false';
        }
        $json .= '"}';
        
        return $json;
    }
    
    /**
    * Gera um tolken de acesso para o usuário.
    * 
    * @param $email O email do usuário que receberá o tolken
    * @return Uma string contendo o tolken, se a operação resultar em sucesso. null caso contrário.
    */
    function setTolken($email) {
        global $TOLKEN;
        global $SERVER;
        global $EMAIL;
        
        $tolken = sha1(mt_rand() . $TOLKEN);
        
        $query = array("function" => "setTolken", $EMAIL => $email, $TOLKEN => $tolken);
        $response = json_decode(sendPost($SERVER.'/login', $query), true);
        
        if (isset($response['sucess']) and $response['sucess'] == 'true') {
            return $tolken;
        } else {
            return null;
        }
    }
?>