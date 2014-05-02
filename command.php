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
    
    if (eg("sair")) {
        deslogar();
        redirect('.');
    }
    
    if (ep("cadastrar") and ep("plan") and ep("name") and ep("email") and ep("password")) {
        if (criarUsuario(p("name"), p("email"), p("password"), p("plan")) == true) {
            logar(p("email"), p("password"));
            redirect("me.php");
        }
    }
    
    if (ep($EMAIL) and ep($SENHA)) {
        logar(p($EMAIL), p($SENHA));
        redirect("me.php");
    }
    
?>