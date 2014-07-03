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
    * encrypt password
    * @param password in plaintext
    * @return encrypted password
    */
    function encryptPassword($password)
    {
	return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
    * Add new user
    * @param $name first name
    * @param $password password (stored encrypted)
    * @param $email email address
    * @param $plan plan id
    * @param $trans_id PayPal transaction id
    * @param $payer_id PayPal transaction id
    * @param $start_date
    * @param $has_tz if start date has time zone
    * @return new user_id 
    */
    function addUser($name, $password, $email, $plan, $tran_id, $payer_id)
    {
	$mysql = dbConnect('addUser');

	// Start date is always today at 1 second past midnight UTC
	$start_date = gmdate('Y-m-d 00:00:01');
	
	$res = $mysql->query("insert into users(user_name, email, password, plan_id, payment_date, subscr_id, payer_id) values('$name', '$email', '$password', $plan, '$start_date', '$tran_id', '$payer_id')");

	return $mysql->insert_id;
    }

    /**
    * Return userplan name and price as array
    * @param $id user id
    * @return plan number, plan name and price for user
    */
    function getUserPlan($id)
    {
	$mysql = dbConnect('getUserPlan');
	$res = $mysql->query("select plan_id from users where user_id = $id");
	$obj = $res->fetch_object();
	list ($plan, $price, $max) = getPlan($obj->plan_id);

	return array ($obj->plan_id, $plan, $price);
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
	$obj = $res->fetch_assoc();

	return $obj['user_name'];
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

	$res = $mysql->query("select count(UN.usernote_id) as ncount from usernote UN, users U where UN.user_id = $id and U.user_id = UN.user_id and usernote_time between U.payment_date and date_sub(date_add(U.payment_date, interval 1 month), interval 1 day)");
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
	if(!isset($postarray['code']))
	{
		return;
	}

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
		// Or, if the user is at their max number of notes then it's a fastnote
		if(isset($_SESSION['user_id']))
		{
			$max_notes = getMaxNotes($_SESSION['user_id']);
			$used_notes = getNotesUsed($_SESSION['user_id']);
			$notes_left = $max_notes - $used_notes;
		}

		if(!isset($_SESSION['user_id']) || (isset($_SESSION['user_id']) && !$notes_left))
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

    /**
    * update logged in users first name
    * @params $id user id, $newval new name
    * @return nothing
    */
    function updateFirstName($id, $newval)
    {
	$mysql = dbConnect('updateFirstName');
	$mysql->query("update users set user_name = '$newval' where user_id = $id");
    }

    /**
    * update logged in users email
    * @params $id user id, $newval new email
    * @return nothing
    */
    function updateEmail($id, $newval)
    {
	$mysql = dbConnect('updateEmail');
	$mysql->query("update users set email = '$newval' where user_id = $id");
    }

    /**
    * update logged in users password
    * @params $id user id, $newval new password
    * @return nothing
    */
    function updatePassword($id, $password)
    {
	$mysql = dbConnect('updatePassword');
	$encpw = password_hash($password, PASSWORD_BCRYPT);

	$mysql->query("update users set password = '$encpw', reset_id = null, reset_sent = null where user_id = $id");
    }

    /**
    * Change plan for logged in user
    * @params $id user id, $newplan new plan
    * @return nothing
    */
    function updatePlan($id, $plan)
    {
	$mysql = dbConnect('updatePlan');
	$mysql->query("update users set plan_id = $plan where user_id = $id");
    }

    /**
    * Delete a user
    * @params $id user id
    * @return nothing
    */
    function deleteUser($id)
    {
	$mysql = dbConnect('deleteUser');
	$mysql->query("delete from users where user_id = $id");
    }

    /**
    * Return days, hours and minutes until current plan ends
    * @param $id user id
    * @return Days, hours, minutes
    */
    function getTimeLeft($id)
    {
	$mysql = dbConnect('getTimeLeft');
	$res = $mysql->query("select timediff(date_sub(date_add(payment_date, interval 1 month), interval 1 day), now()) as delta from users where user_id = $id");
	$obj = $res->fetch_object();

	$date_parts = explode(':', $obj->delta);

	$days = 0;
	$hours = $date_parts[0];
	while($hours > 0)
	{
		++$days;
		$hours -= 24;
	}

	if($hours)
	{
		--$days;
		$hours += 24;
	}

	return array ($days, $hours, $date_parts[1]);
    }

    /**
    * Add the cookie and update the user table when a user chooses "Keep me logged in"
    * @params $id user id
    * @return nothing
    */
    function addAuthId($id)
    {
	$mysql = dbConnect('addAuthId');

	$key = generateKey();
	// Store an encrypted copy of the key
	$enckey = password_hash($key, PASSWORD_BCRYPT);
	$mysql->query("update users set auth_key='$enckey' where user_id = $id");
	setcookie("authid", $key, time()+3600*24*30);
    }

    /**
    * Generate a 100 byte random key
    * @params optional length (returns 100 if not given)
    * @return key
    */
    function generateKey($len = 100)
    {
	return bin2hex(mcrypt_create_iv($len, MCRYPT_DEV_URANDOM));
    }

    /**
    * Clear the cookie and update the user table when a user chooses to logout
    * @params $id user id
    * @return nothing
    */
    function clearAuthId($id)
    {
	$mysql = dbConnect('clearAuthId');

	$mysql->query("update users set auth_key = null  where user_id = $id");
	setcookie("authid", '', time()-3600);
    }

    /**
    * Check that the authid cookie is valid
    * @params authid
    * @return true if valid
    */
    function validAuthId($auth)
    {
	$uid = 0;
	$mysql = dbConnect('validAuthId');

	$res = $mysql->query("select user_id, auth_key from users where auth_key is not null");
	if($res->num_rows)
	{
		while($obj = $res->fetch_object())
		{
			if(password_verify($auth, $obj->auth_key))
			{
				$uid = $obj->user_id;
				break;
			}
		}
	}

	return $uid;
    }

    /**
    * Update reset password fields
    * @params user id, key
    * @return nothing
    */
    function updateReset($uid, $key)
    {
	$mysql = dbConnect('updateReset');
	// Don't store the id itself - bad security practice
	$enckey = password_hash($key, PASSWORD_BCRYPT);

	$res = $mysql->query("update users set reset_id = '$enckey', reset_sent = now() where user_id = $uid");
    }

    /**
    * Check that the password reset request hasn't expired and is valid
    * @params request_id
    * @return user id is valid, 0 otherwise
    */
    function resetExpired($req_id)
    {
	$uid = 0;
	$mysql = dbConnect('resetExpired');

	$res = $mysql->query("select user_id, reset_id, timestampdiff(MINUTE, reset_sent, now()) as reset_diff from users where reset_id is not null");
	if($res->num_rows)
	{
		while($obj = $res->fetch_object())
		{
			if(password_verify($req_id, $obj->reset_id) && ($obj->reset_diff < 1440))
			{
				$uid = $obj->user_id;
				break;
			}
		}
	}

	return $uid;
    }

    /**
    * Update font colour
    * @params user id, font colour
    * @return nothing
    */
    function updateFontColour($uid, $fc)
    {
	$mysql = dbConnect('updateFontColour');

	$res = $mysql->query("update users set font_colour = '$fc' where user_id = $uid");
    }

    /**
    * Update font size
    * @params user id, font size
    * @return nothing
    */
    function updateFontSize($uid, $fs)
    {
	$mysql = dbConnect('updateFontSize');

	$res = $mysql->query("update users set font_size = $fs where user_id = $uid");
    }

    /**
    * Update background colour
    * @params user id, background colour
    * @return nothing
    */
    function updateBackgroundColour($uid, $bg)
    {
	$mysql = dbConnect('updateBackgroundColour');

	$res = $mysql->query("update users set background_colour = '$bg' where user_id = $uid");
    }

    /**
    * Get list of colour hash values
    * @params none
    * @return array of hash values
    */
    function getColours()
    {
	$ret_arr = array();
	$mysql = dbConnect('getColours');

	$res = $mysql->query("select hashvalue from colours");
	while($obj = $res->fetch_object())
	{
		$ret_arr[] = $obj->hashvalue;
	}	

	return $ret_arr;
    }

    /**
    * Get the users current font colour name
    * @params user id
    * @return font colour name
    */
    function getCurrentFontColourName($uid)
    {
	$mysql = dbConnect('getCurrentFontColourName');

	$res = $mysql->query("select C.name from colours C, users U where U.user_id = $uid and C.hashvalue = U.font_colour");
	$obj = $res->fetch_object();

	return $obj->name;
    }

    /**
    * Get the users current font size name
    * @params user id
    * @return font size name
    */
    function getCurrentFontSizeName($uid)
    {
	$mysql = dbConnect('getCurrentFontSizeName');

	$res = $mysql->query("select FS.size_name from font_size FS, users U where U.user_id = $uid and FS.size_px = U.font_size");
	$obj = $res->fetch_object();

	return $obj->size_name;
    }

    /**
    * Get the users current background colour name
    * @params user id
    * @return background colour name
    */
    function getCurrentBackgroundColourName($uid)
    {
	$mysql = dbConnect('getCurrentBackgroundColourName');

	$res = $mysql->query("select C.name from colours C, users U where U.user_id = $uid and C.hashvalue = U.background_colour");
	$obj = $res->fetch_object();

	return $obj->name;
    }

    /**
    * Get the users current font colour
    * @params user id
    * @return font colour
    */
    function getCurrentFontColour($uid)
    {
	$mysql = dbConnect('getCurrentFontColour');

	$res = $mysql->query("select font_colour from users where user_id = $uid");
	$obj = $res->fetch_object();

	return $obj->font_colour;
    }

    /**
    * Get the users current background colour
    * @params user id
    * @return background colour
    */
    function getCurrentBackgroundColour($uid)
    {
	$mysql = dbConnect('getCurrentBackgroundColour');

	$res = $mysql->query("select background_colour from users where user_id = $uid");
	$obj = $res->fetch_object();

	return $obj->background_colour;
    }

    /**
    * Get the users current font size
    * @params user id
    * @return font size
    */
    function getCurrentFontSize($uid)
    {
	$mysql = dbConnect('getCurrentFontSize');

	$res = $mysql->query("select font_size from users where user_id = $uid");
	$obj = $res->fetch_object();

	return $obj->font_size;
    }

    /**
    * Get list of font sizes and names
    * @params none
    * @return array of hash values
    */
    function getFontSizes()
    {
	$ret_arr = array();
	$mysql = dbConnect('getFontSizes');

	$res = $mysql->query("select size_name, size_px from font_size");
	while($obj = $res->fetch_object())
	{
		$ret_arr[$obj->size_name] = $obj->size_px;
	}	

	return $ret_arr;
    }

    /**
    * Return paypal details as array
    * @param none
    * @return user, password and signature
    */
    function getPayPalMerchantDetails()
    {
	$mysql = dbConnect('getPayPalMerchantDetails');
	$res = $mysql->query("select user, pwd, signature, sandbox from paypal");
	$obj = $res->fetch_object();

	return array ($obj->user, $obj->pwd, $obj->signature, $obj->sandbox);
    }

    /**
    * Check that plan amount agrees with the plan subscribed to
    * @param profile, amount
    * @return true if it's good, false otherwise
    */
    function isCorrectPlan($profile, $amount)
    {
	$mysql = dbConnect('isCorrectPlan');
	$res = $mysql->query("select P.cost from plans P, users U where U.subscr_id = '$profile' and P.plan_id = U.plan_id");
	$obj = $res->fetch_object();

	return ($obj->cost == $amount);
    }

    /**
    * Update the date on a user record
    * @param subscr_id
    * @return none
    */
    function updateDate($profile)
    {
	$mysql = dbConnect('updateDate');
	$start_date = gmdate('Y-m-d 00:00:01');
	$res = $mysql->query("update users set payment_date = '$start_date' where subscr_id = '$profile'");
    }

    /**
    * Return payment profile id for user
    * @param $id user id
    * @return payment profile
    */
    function getPaymentProfile($id)
    {
	$mysql = dbConnect('getPaymentProfile');

	$res = $mysql->query("select subscr_id from users where user_id = $id");
	$obj = $res->fetch_object();

	return $obj->subscr_id;
    }

    /**
    * Check that we've had a payment response from PayPal
    * @param user id
    * @return True if it's an active plan, false otherwise
    */
    function isActivePlan($id)
    {
	$mysql = dbConnect('isActivePlan');
	$res = $mysql->query("select payment_date from users where user_id = $id");
	$obj = $res->fetch_object();

	return ($obj->payment_date != '0000-00-00 00:00:00');
    }

    /**
    * Get note counts
    * @param none
    * @return total usernotes, total fastnotes, live fastnotes
    */
    function getNoteStats()
    {
	$mysql = dbConnect('getNoteStats');
	$res = $mysql->query("select count(usernote_id) as count from usernote");
	$obj = $res->fetch_object();
	$totu = $obj->count;

	$res = $mysql->query("select count(fnote_id) as count from fastnote");
	$obj = $res->fetch_object();
	$lfn = $obj->count;

	$res = $mysql->query("select count(fnote_name) as count from fastnote_archive");
	$obj = $res->fetch_object();
	$afn = $obj->count;

	return array ($totu, $afn, $lfn);

    }

    /**
    * Convert a big disk size number into a more readable one
    * @param byte size
    * @return Value with size extension
    */
    function displaySize($bytes)
    {
	$sv = array('', 'KB', 'MB', 'GB', 'TB', 'PB');
	$i = 0;
	while($bytes >= 1024)
	{
		$bytes /= 1024;
		++$i;
	}

	return (sprintf("%.2f", $bytes) . " " . $sv[$i]);
    }

    /**
    * Return a hash of plan names and users with that plan
    * @param none
    * @return hash of plan names and user counts
    */
    function getUserCounts()
    {
	$mysql = dbConnect('getUserCounts');
	$res = $mysql->query("select P.name, count(U.plan_id) as count from plans P left join users U on (U.plan_id = P.plan_id) group by U.plan_id");
	while($obj = $res->fetch_object())
	{
		$ret[$obj->name] = $obj->count;
	}
	return $ret;
    }

    /**
    * Cancel subscription (null the subscr_id and set the payment_date to 0000-00-00 00:00:00)
    * @param subscr_id
    * @return none
    */
    function cancelSubscription($pp)
    {
	$mysql = dbConnect('cancelSubscription');
	$mysql->query("update users set subscr_id = null, payment_date = '0000-00-00 00:00:00' where subscr_id = '$pp'");
    }

    /**
    * Change the plan details for an existing user
    * @param user id, payment plan, date and amount
    * @return none
    */
    function changePlan($id, $pp, $date, $amount)
    {
	$mysql = dbConnect('changePlan');
	// Get planno using the amount
	$res = $mysql->query("select plan_id from plans where cost = $amount");
	if($res->num_rows)
	{
		$start_date = gmdate('Y-m-d 00:00:01');
		$obj = $res->fetch_object();
		$planno = $obj->plan_id;

		$mysql->query("update users set subscr_id = '$pp', payment_date = '$start_date', plan_id = $planno where user_id = $id");
	}
	else
	{
		error_log(">>>>changePlan: Invalid plan amount requested: $amount");
	}
    }

    /**
    * Get the current subscriber id for a user_id
    * @param user_id
    * @return subscr_id
    */
    function getSubscrId($id)
    {
	$mysql = dbConnect('getSubscrId');
	$res = $mysql->query("select subscr_id from users where user_id = $id");

	$obj = $res->fetch_object();
	return $obj->subscr_id;
    }

    /**
    * Get the user_id which has the payer_id and subscription code
    * @param payer_id, payment_plan
    * @return user_id or 0 if not in the table
    */
    function getUserByPayerAndSubscription($pid, $pp)
    {
	$mysql = dbConnect('getSubscriberByPayer');

	$res = $mysql->query("select user_id from users where payer_id = '$pid' and subscr_id = '$pp'");
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
    * Check that the details on the table haven't already been processed
    * @param paypal transaction id
    * @return true if already done, false otherwise
    */
    function isAlreadyDone($txn_id)
    {
	$mysql = dbConnect('isAlreadyDone');

	$res = $mysql->query("select count(txn_id) as tcount from paypal_transactions where txn_id = '$txn_id'");

	$obj = $res->fetch_object();
	return $obj->tcount;
    }

    /**
    * Create a new ticket
    * @param name, email, plan number, encrypted password
    * @return ticket
    */
    function createNewTicket($name, $email, $plan, $passwd)
    {
	$mysql = dbConnect('createNewTicket');
	$key = 'N' . generateKey(40);
	$res = $mysql->query("insert into ticket(token, name, pwd, email, planno) values('$key', '$name', '$passwd', '$email', $plan)");

	return $key;
    }

    /**
    * Create an update ticket
    * @param subscriber id
    * @return ticket
    */
    function createUpdateTicket($subscr_id)
    {
	$mysql = dbConnect('createUpdateTicket');
	$key = 'U' . generateKey(40);
	$res = $mysql->query("insert into ticket(token, subscr_id) values('$key', '$subscr_id')");

	return $key;
    }

    /**
    * Return value(s) for a ticket and remove it from the table
    * @param ticket
    * @return subscr_id for an update or name, email, password, plan number for a new
    */
    function processTicket($ticket)
    {
	$mysql = dbConnect('processTicket');


	$res = $mysql->query("select name, pwd, email, planno, subscr_id from ticket where token = '$ticket'");
	$obj = $res->fetch_object();

	if(substr($ticket, 0, 1) == 'U')
	{
		return $obj->subscr_id;
	}
	elseif(substr($ticket, 0,1) == 'N')
	{
		return array($obj->name, $obj->pwd, $obj->email, $obj->planno);
	}
	else
	{
		error_log(">>>Bad ticket: $ticket");
		return '';
	}
    }

    /**
    * Is the ticket already processed
    * @param ticket number
    * @return value of processed column
    */
    function isTicketProcessed($ticket)
    {
	$mysql = dbConnect('isTicketProcessed');
	$res = $mysql->query("select processed from ticket where token = '$ticket'");

	if(!$res->num_rows)
	{
		// Invalid ticket
		return -1;
	}
	$obj = $res->fetch_object();

	return $obj->processed;
    }

    /**
    * Close a ticket
    * @param ticket number, transaction id from PayPal
    * @return none
    */
    function closeTicket($ticket, $txn_id)
    {
	$mysql = dbConnect('closeTicket');
	$mysql->query("update ticket set processed = true where token = '$ticket'");
	$mysql->query("insert into paypal_transactions(txn_id) values('$txn_id')");
    }
?>
