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
    $PLANOS = ['basico', 'pro', 'premium'];
    
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
    * Um atalho para $_GET['query']
    *
    * @param $query valor a ser recuperado.
    * @return Se existe: $_GET['query'], caso contrário: null
    */
    function g($query) {
        try {
            return $_GET[$query];
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
    * Verifica se um determinado valor existe na variavel $_GET do php
    *
    * @param $query valor a ser verificado
    * @return Se existe o valor.
    */
    function eg($query) {
        try {
            if (isset($_GET) and isset($_GET[$query])) {
                return true;
            }
        } catch (Exception $e) {
        }
        
        return false;
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
    
    /**
    * Um atalho para $_SESSION['query']
    *
    * @param $query valor a ser recuperado.
    * @return Se existe: $_SESSION['query'], caso contrário: null
    */
    function s($query) {
        try {
            return $_SESSION[$query];
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
    * Verifica se um determinado valor existe na variavel $_SESSION do php
    *
    * @param $query valor a ser verificado
    * @return Se existe o valor.
    */
    function es($query) {
        try {
            if (isset($_SESSION) and isset($_SESSION[$query])) {
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
            return verifyTolken(s('email'), s('tolken'));
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
    
    function existeUsuairo($email) {
        global $SERVER;
        
        $query = array('function' => 'exist', 'email' => $email);
        $response = json_decode(sendPost($SERVER, $query), true);
        
        return $response['sucess'] == 'true';
    }
    
    function validePlano($plano) {
        global $PLANOS;
    
        return in_array(strtolower($plano), $PLANOS);
    }
    
    /**
    * Criar Usuario
    * 
    * @return true se ok, ou uma string com o erro.
    */
    function criarUsuario($nome, $email, $senha, $plano) {
        global $SERVER;
    
        if (!validePlano($plano)) { return "Este não é um de nossos planos."; }
        if (existeUsuairo($email)) { return "Usuário existente"; }
        
        $created = time();
        $jsonDecoded = array(
            '_id' => $email,
            "plan" => array("type" => $plano, "begin" => $created),
            "notes" => 0,
            "codes" => [],
            "created" => $created,
            "name" => array("first" => explode(" ", $nome." ")[0], "complete" => $nome),
            "password" => $senha,
            "tolkens" => []
        );
        $jsonEncoded = json_encode($jsonDecoded);
        
        $query = array('function' => "insereUsuario", "json" => $jsonEncoded);
        $response = json_decode(sendPost($SERVER.'/login', $query), true);
        
        return $response['sucess'] == 'true';
    }
    
    function getUserInfo($email, $tolken) {
        try {
            if (verifyTolken($email, $tolken)) {
                global $SERVER;
                
                $query = array('function' => 'getInfo', 'email' => $email);
                $response = json_decode(sendPost($SERVER, $query), true);
                
                if ($response['sucess'] == 'true') {
                    return $response;
                }
            }
        } catch (Exception $e) {
        }
        return false;
    }
    
    function getPlanInfo($plano) {
        try{
            global $SERVER;
            
            $query = array('function' => 'getInfo', 'plan' => $plano);
            $response = json_decode(sendPost($SERVER, $query), true);
            
            if ($response['sucess'] = 'true') {
                return $response;
            }
        } catch(Eception $e) {
        }
        return false;
    }
    
    function existeDocumento($code) {
        global $SERVER;
        
        $query = array("function" => "getInfo", "code" => $code);
        $pages = json_decode(sendPost($SERVER, $query), true)['pages'];
        
        return $pages > 0;
    }
    
    function criarDocumento($code, $content) {
        global $SERVER;
        
        if (!existeDocumento($code)) {
            $query['function'] = 'save';
            $query['code'] = $code;
            $query['content'] = $content;
            
            $json = json_decode(sendPost($SERVER, $query),true);
            
            return $json['sucess'] == 'true';
        }
        
        return false;
    }
    
    function atribuirPosse($code, $email) {
        try{
            global $SERVER;
            
            if(!existeDocumento($code)) { return false; }
            
            $query = array('function' => 'atribuirPosse', 'code' => $code, 'email' => $email);
            $response = json_decode(sendPost($SERVER, $query), true);
                
            if ($response['sucess'] = 'true') {
                return $response;
            }
        } catch(Eception $e) {
        }
        return false;
    }
    
    function getContent($code = "default", $page = -1, $version = -1) {
        global $SERVER;
        
        $query = array("code" => $code, "page" => $page, "version" => $version);
        $response = json_decode(sendPost($SERVER, $query), true);
        
        
        return $response['content'];
    }
    
    function deslogar() {
        if(es('email')) { unset($_SESSION['email']);}
        if(es('tolken')) { unset($_SESSION['tolken']);}
    }
?>