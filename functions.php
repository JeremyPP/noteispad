<?php
    /* 
    * Central de funções do NOTisPAD
    */
    require_once("init.php");
    
    
    /**
    * Costantes para strings.
    */
    $EMAIL = "email";
    $SENHA = "password";
    $TOLKEN = "tolken";
    $SERVER = "http://localhost:8888";
    
    function redirect($url) {
        header("Location: ".$url);
    }
    
    function queryToArray($queryString) {
        $saida = array();
        parse_str($queryString, $saida);
        
        return $saida;
    }
    
    /**
    * Faz uma requisição POST a url
    *
    * @param $server a url do servidor
    * @param $queryArray uma array do tipo chave -> valor especificando a query
    * @return A resposta do servidor, null caso não consiga se comunicar.
    */
    function sendPost($server, $queryArray) {
        try {
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($queryArray),
                ),
            );
            
            $context  = stream_context_create($options);
            $result = file_get_contents($server, false, $context);
            
            return $result;
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
    * Faz uma requisição GET a url
    *
    * @param $url Uma url válida
    * @return A resposta do servidor, null caso não consiga se comunicar.
    */
    function sendGet($url) {
        try {
            return file_get_contents($url);
        } catch(Exception $e) {
            return null;
        }
    }
    
    /**
    * Um atalho para $_POST['query']
    *
    * @param $query valor a ser recuperado.
    * @return Se existe: $_POST['query'], caso contrário: null
    */
    function p($query) {
        try {
            return $_POST[$query];
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
    * Verifica se um determinado valor existe na variavel $_POST do php
    *
    * @param $query valor a ser verificado
    * @return Se existe o valor.
    */
    function ep($query) {
        try {
            if (isset($_POST) and isset($_POST[$query])) {
                return true;
            }
        } catch (Exception $e) {
        }
        
        return false;
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
    * Verifica se um tolken pertence ao usuário
    *
    * @param $email Email do usuário
    * @param $tolken O tolken a ser verificado
    * @return true se o tolken pertencer ao usuário, false caso contrário.
    */
    function verifyTolken($email, $tolken) {
        global $EMAIL;
        global $SERVER;
        global $TOLKEN;
        
        $query = array("function" => "verifyTolken", $EMAIL => $email, $TOLKEN => $tolken);
        $response = json_decode(sendPost($SERVER.'/login', $query), true);
        
        return $response['sucess'] == 'true';
    }
    
    /**
    * Verifica se um usuário esta logado
    * 
    * @return True se o usuário estiver logado
    */
    function logado() {
        if (isset($_SESSION['tolken']) and isset($_SESSION['email'])){
            return true;
        }
        return false;
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