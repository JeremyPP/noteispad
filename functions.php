<?php
    /* 
    * Central de funções do NOTisPAD
    */
    require_once("init.php");
    
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
?>