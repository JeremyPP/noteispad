<?php
    /* 
    * Central de funções do NOTisPAD
    */
    require_once("init.php");
    require_once("password.php");
    
    
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
    * dbConnect - connect to the database
    * @param string to include in error output
    * @return db handle for opened db or -1 if error
    */
    function dbConnect($err_str)
    {
        // Change these
	$dbhost = '127.0.0.1';
	$dbname = 'noteispad';
	$dbuser = 'noteispad';
	$dbpass = 'h0undd0g';

	$mysql = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if($mysql->connect_errno)
	{
		error_log("Connection error in $err_str" . $mysqli->connect_error);
		return 0;
	}
	else
	{
		return $mysql;
	}
    }

    /**
    * Get plan details
    * @param $plan the plan number (from the plan_no column in the db)
    * @return plan name, plan price and number of notes per month
    */
    function getPlan($plan)
    {
	$mysql = dbConnect('getPlan');
	
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

    /**
    * Check to see if a user already exists
    * @param $email email address
    * @return 0 if invalid user, user_id otherwise
    */
    function checkUser($email)
    {
	$mysql = dbConnect('checkUser');

	$res = $mysql->query("select user_id from users where email = '$email'");
	if($res->num_rows)
	{
		$obj = $res->fetch_object();
		$uid = $obj->user_id;
	}
	else
	{
		$uid = 0;
	}

	return $uid;
    }
	
    /**
    * Add new user
    * @param $name first name
    * @param $password password (stored encrypted
    * @param $email email address
    * @return new user_id 
    */
    function addUser($name, $password, $email, $plan)
    {
	$mysql = dbConnect('addUser');

	$encpw = password_hash($password, PASSWORD_BCRYPT);

	$res = $mysql->query("insert into users(user_name, email, password, plan_id) values('$_POST[name]', '$_POST[email]', '$encpw', $plan)");

	return $mysql->insert_id;
    }
	
    /**
    * Return firstname for user
    * @param $id user id
    * @return Users first name
    */
    function getFirstName($id)
    {
	$mysql = dbConnect('getFirstName');

	$res = $mysql->query("select user_name from users where user_id = $id");
	$obj = $res->fetch_object();

	return $obj->user_name;
    }

    /**
    * Check that the supplied password agrees with what's in the table
    * @param $uid user_id
    * @param $password the supplied password
    * @return true if the password agrees with what's held in the database
    */
    function validPassword($id, $pass)
    {
	$mysql = dbConnect('validPassword');

	$res = $mysql->query("select password from users where user_id = $id");
	$obj = $res->fetch_object();

	return password_verify($pass, $obj->password);
    }

    /**
    * Return email for user
    * @param $id user id
    * @return Users email address
    */
    function getEmail($id)
    {
	$mysql = dbConnect('getEmail');

	$res = $mysql->query("select email from users where user_id = $id");
	$obj = $res->fetch_object();

	return $obj->email;
    }

    /**
    * Return total count of notes used by this user
    * @param $id user id
    * @return total Count of notes used
    */
    function getTotalNotes($id)
    {
	$mysql = dbConnect('getTotalNotes');

	$res = $mysql->query("select count(usernote_id) as ncount from usernote where user_id = $id");
	$obj = $res->fetch_object();

	return $obj->ncount;
    }

    /**
    * Return count of notes used in payment period
    * @param $id user id
    * @return Count of notes used
    */
    function getNotesUsed($id)
    {
	$mysql = dbConnect('getNotesUsed');

	$res = $mysql->query("select count(UN.usernote_id) as ncount from usernote UN, users U where UN.user_id = $id and U.user_id = UN.user_id and usernote_time between U.paid_date and date_sub(date_add(U.paid_date, interval 1 month), interval 1 day)");
	$obj = $res->fetch_object();

	return $obj->ncount;
    }

    /**
    * Return plan max notes for user
    * @param $id user id
    * @return Max notes for plan for user
    */
    function getMaxNotes($id)
    {
	$mysql = dbConnect('getMaxNotes');

	$res = $mysql->query("select P.notes_per_month as pcount from plans P, users U where U.user_id = $id and P.plan_id = U.plan_id");
	$obj = $res->fetch_object();

	return $obj->pcount;
    }

    /**
    * Return note type
    * @param note code
    * @return 'F'astnote, 'U'sernote or 'X' if note doesn't exist
    */
    function getNoteType($code)
    {
	$mysql = dbConnect('getNoteType');
	
	$res = $mysql->query("select count(*) as rcount, 'F' as rtype from fastnote where fnote_name = '$code' union select count(*) as rcount, 'U' as rtype from usernote where usernote_name = '$code'");

	while($obj = $res->fetch_object())
	{
		if($obj->rcount)
		{
			return $obj->rtype;
		}
	}

	return 'X';
    }

    /**
    * Return note text
    * @param note code, sequence sql (either a value or a sub-select)
    * @return text of note
    */
    function getNoteText($code, $seq_sql)
    {
	$ret_text = "Welcome!

You have just created a nonexistent code, so a new note has been created.
Once saved, this note will be associated to this code.
Save this code to access your notes again, or to share it with others people.
If you share the code, don't worry, the original content of your note will cannot be changed.
Once the note saved, any changes made will be saved to another 'page'.
You can access all existing pages by clicking on 'View all'.
Also, you can create a new note with a brand new code or access another existing note by clicking on 'New Note' in the upper right corner.
We hope you enjoy our services.
We are here if you have any question.
Regards,

The NOT is PAD! team.";

	$mysql = dbConnect('getNoteText');

	// First of all, is this a fastnote or a usernote?
	$res = getNoteType($code);

	if($res == "F")
	{
		$result = $mysql->query("select FL.fnote_text as fntext from fastnote_lines FL, fastnote F where F.fnote_name = '$code' and FL.fnote_id = F.fnote_id and FL.fnote_seq = " . $seq_sql);

		if($result->num_rows)
		{
			$obj = $result->fetch_object();
			$ret_text = $obj->fntext;
		}
	}
	elseif($res == "U")
	{
		$res = $mysql->query("select treat_as_fastnote from usernote where usernote_name = '$code'");
		$obj = $res->fetch_object();
		$base_sql = "select UL.usernote_text as untext from usernote_lines UL, usernote U where U.usernote_name = '$code' and UL.usernote_id = U.usernote_id";
		if($obj->treat_as_fastnote)
		{
			$base_sql .= " and UL.usernote_seq = (select max(UL.usernote_seq) from usernote_lines UL where UL.usernote_id = U.usernote_id)";
		}

		$res = $mysql->query($base_sql);
		$obj = $res->fetch_object();
		$ret_text = $obj->untext;
	}

	return $ret_text;
    }

    /**
    * Save note - creates a new one if needed, otherwise just create a new version unless it's a usernote
    * in which case it all depeneds on who's editing the note:
    * if it's the owner then add a new note or update an existing one (unless it's already marked as being treated
    * as a fastnote.
    * @param $array Post array
    * @return Nothing at the moment - will add error checking at a later date
    */
    function saveNote($postarray)
    {
	$mysql = dbConnect('saveNote');

	$type = getNoteType($postarray['code']);
	if($type == "F")
	{
		$result = $mysql->query("select fnote_id from fastnote where fnote_name = '$postarray[code]'");
		$obj = $result->fetch_object();
		$fnote_id = $obj->fnote_id;

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
	elseif($type == "U")
	{
		// It's a usernote. If we're the owner and it's never been edited by anyone else then update the existing one.
		$un = $mysql->query("select usernote_id, user_id, treat_as_fastnote from usernote where usernote_name = '$postarray[code]'");
		$un_obj = $un->fetch_object();

		if($un_obj->treat_as_fastnote)
		{
			$res = $mysql->query("select max(usernote_seq) as seq_no from usernote_lines where usernote_id = $un_obj->usernote_id");
			$obj = $res->fetch_object();
			$seq_no = $obj->seq_no;
			++$seq_no;
			$mysql->query("insert into usernote_lines(usernote_id,usernote_seq,usernote_text) values($un_obj->usernote_id, $seq_no, '$postarray[content]')");
		}
		else
		{
			// Not a fastnote but if we're not the owner then it becomes like one
			if(!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != $un_obj->user_id))
			{
				$mysql->query("update usernote set treat_as_fastnote=true where usernote_id = $un_obj->usernote_id");
				$mysql->query("insert into usernote_lines(usernote_id,usernote_seq,usernote_text) values($un_obj->usernote_id, 2, '$postarray[content]')");
			}
			else
			{
				// If we're here then it should be a usernote updated by the owner
				$mysql->query("update usernote_lines set usernote_text = '$postarray[content]' where usernote_id = $un_obj->usernote_id");
			}
		}
	}
	elseif($type == "X")
	{
		// If user_id is set then it's a usernote otherwise it's a fastnote
		if(!isset($_SESSION['user_id']))
		{
			$result = $mysql->query("insert into fastnote(fnote_name) values('$postarray[code]')");
			if(!$result)
			{
				error_log("Insert failed: " . $mysql->error);
			}

			$fnote_id = $mysql->insert_id;

			$mysql->query("insert into fastnote_lines(fnote_id, fnote_text) values($fnote_id, '$postarray[content]')");

			// Also create the event to call the sp for deletion after 7 days
			$result = $mysql->query("create event $postarray[code]_delete on schedule at now() + interval 7 day do call delete_fastnote_sp('$postarray[code]');");
			if(!$result)
			{
				error_log("Create event failed: " . $mysql->error);
			}
		}
		else
		{
			$mysql->query("insert into usernote(user_id,usernote_name) values($_SESSION[user_id], '$postarray[code]')");
			$un_no = $mysql->insert_id;
			$mysql->query("insert into usernote_lines(usernote_id, usernote_text) values($un_no, '$postarray[content]')");
		}
	}
    }
?>
