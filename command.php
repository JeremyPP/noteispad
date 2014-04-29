<?php
    /* Central de Comandos do NOTisPAD
     *
     * Essa é a interface usuario servidor.
     * Aqui é pra onde vem as requisições do usuário, e para onde serão redirecionados.
     * 
     * OBS: toda comunicação com este arquivo é feita com POST
     *
     * TO-DO definir exatamente o que é este arquivo
     */
    require_once("init.php");
    require_once("functions.php");
    
    if (ep($EMAIL) and ep($SENHA)) {
        logar(p($EMAIL), p($SENHA));
        redirect("me.php");
    }
?>