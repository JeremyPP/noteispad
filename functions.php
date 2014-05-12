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

    /**
    * Save fastnote - creates a new one if needed, otherwise just create a new version
    * @param $array Post array
    * @return Nothing at the moment - will add error checking at a later date
    */
    function saveFastnote($postarray)
    {
	$dbhost = '127.0.0.1';
	$dbname = 'noteispad';
	$dbuser = 'noteispad';
	$dbpass = 'h0undd0g';

	$mysql = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if($mysql->connect_errno)
	{
		error_log("Connection error in saveFastnote" . $mysqli->connect_error);
		return 0;
	}

	// Is there an existing fastnote with this name?
	$result = $mysql->query("select fnote_id from fastnote where fnote_name = '$postarray[code]'");
	if(!$result->num_rows)
	{
		// There is not so create a new fastnote
		$result = $mysql->query("insert into fastnote(fnote_name) values('$postarray[code]')");
		if(!$result)
		{
			error_log("Insert failed: " . $mysql->error);
		}

		$fnote_id = $mysql->insert_id;

		// Also create the event to call the sp for deletion after 7 days
		$result = $mysql->query("create event $postarray[code]_delete on schedule at now() + interval 7 day do call delete_fastnote_sp('$postarray[code]');");
		if(!$result)
		{
			error_log("Create event failed: " . $mysql->error);
		}

	}
	else
	{
		$obj = $result->fetch_object();
		$fnote_id = $obj->fnote_id;
	}

	// Now insert the line
	$result = $mysql->query("select max(fnote_seq) as fnseq from fastnote_lines where fnote_id = $fnote_id");
	if($result->num_rows)
	{
		$obj = $result->fetch_object();
		$fnote_seq = $obj->fnseq;
	}
	else
	{
		$fnote_seq = 0;
	}

	++$fnote_seq;

	$mysql->query("insert into fastnote_lines(fnote_id, fnote_seq, fnote_text) values($fnote_id, $fnote_seq, '$postarray[content]')");
    }

    /**
    * Get plan details
    * @param $plan the plan number (from the plan_no column in the db)
    * @return plan name, plan price and number of notes per month
    */
    function getPlan($plan)
    {
	$dbhost = '127.0.0.1';
	$dbname = 'noteispad';
	$dbuser = 'noteispad';
	$dbpass = 'h0undd0g';

	$mysql = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if($mysql->connect_errno)
	{
		error_log("Connection error in saveFastnote" . $mysqli->connect_error);
		return 0;
	}
	
	$res = $mysql->query("select name, cost, notes_per_month from plans where plan_id = $plan");
	if(!$res->num_rows)
	{
		error_log("Unknown plan requested: " . $plan);
		$name = "Unknown";
		$price = "Unknown";
		$notes = "Unknown";
	}
	else
	{
		$obj = $res->fetch_object();
		$name = $obj->name;
		$price = $obj->cost;
		$notes = $obj->notes_per_month;
	}

	return array ($name, $price, $notes);
    }
?>
