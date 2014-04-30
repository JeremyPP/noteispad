var db = require("./notDB.js");
var CONSTANTES = require("./constantes.js").CONSTANTES;

handlers = {
	      "/": start,
	 "/page": start,
     "/login": login,
	"/favicon.ico": favicon
}

function start(response, query) {
    switch (query['function']) {
        case 'save':
            save(response, query);
            break;
        case 'new':
            novaPagina(response, query);
            break;
        case 'getInfo':
            getInfo(response, query);
            break;
        case 'exist':
            exist(response, query);
            break;
        case 'atribuirPosse':
            atribuirPosse(response, query);
            break;
        default:
            get(response, query);
    }
}

function atribuirPosse(response, query){
    if (query['code'] && query['email']) {
        db.trocaUsuarioNota(query['code'], query['email'], function(sucess){
            db.appendNotaUsuario(query['email'], query['code'], function(sucess){
                db.incrementaNotasUsuario(query['email'], 1, function(qnt) {
                    writeSucess(response, qnt?true:false);
                });
            });
        });
    } else {
        error(response, CONSTANTES.SUCESS.FALSO);
    }
}

function exist(response, query) {
    if (query['email']) {
        db.getUsuario(query['email'], function(usuario){
            var json = '';
            if (usuario) {
                json = '{"sucess": "true"}';
            } else {
                json = CONSTANTES.SUCESS.FALSO;
            }
            write(response, json);
        });
    } else {
        db.getDocumento
    }
}

function get(response, query) {
    var code = query['code'];
    var page = query['page'];

    if (code) {
        db.getUltimaPaginaDe(code, function(ultimaPagina){
            page = (page >= 0 && page <= ultimaPagina)? page: ultimaPagina;
            
            db.getConteudoDe(code, page, function(content){
                    code = JSON.stringify(code);
                    content = JSON.stringify(content);
                    json = '{"sucess": "true", "document": '+ code + ', "page": '+page+', "content": '+content+'}';
                
                write(response, json);
            });
        });
    } else {
        error(response, CONSTANTES.SUCESS.FALSO);
    }
}

// TO-DO
function save(response, query) { // lembrar que a verificação de que será salva na última página deve ser feita no front-end
	if (query['content'] && query['code']) {
		db.getDocumento(query['code'], function(documento) {
			if (documento) {
				db.alterarDocumento(documento['_id'], documento['pages']-1, query['content'], function(pagina){
                    query['function'] = 'get';
					start(response, query);
				});
			} else {
				db.criaDocumento(query['code'], function(documento){
					save(response, query);
				});
			}
		});
	} else {
		error(response, CONSTANTES.SUCESS.FALSO);
	}
}

function novaPagina(response, query) {
    if (query['code']) {
        db.inserePaginaNoDocumento(query['code'], function(pagina) {
            if (pagina) {
                query['function'] = 'get';
                start(response, query);
            } else {
                error(response, CONSTANTES.SUCESS.FALSO);
            }
        });
    } else {
		error(response, CONSTANTES.SUCESS.FALSO);
	}
}

function getInfo(response, query) {
    if(query['code']) {
        db.getPaginas(query['code'], function(pages){
            var json = '{"sucess": "true", "pages": '+pages+'}';
            write(response, json);
        });
    } else if(query['email']){
        db.getUsuario(query['email'], function(usuario) {
            if (usuario) {
                delete usuario['tolkens'];
                delete usuario['password'];
                
                usuario['sucess'] = 'true';
                var json = JSON.stringify(usuario);
                
                write(response, json);
            } else {
                error(response, CONSTANTES.SUCESS.FALSO);
            }
        });
    } else if (query['plan']){
        db.getPlano(query['plan'], function(plano) {
            if(plano){
                plano['sucess'] = 'true';
                var json = JSON.stringify(plano);
                
                write(response, json);
            } else {
                error(response, CONSTANTES.SUCESS.FALSO);
            }
        });
    } else {
        error(response, CONSTANTES.SUCESS.FALSO);
    }
}

/**
* Gerencia comandos referentes a login e verificação de autenticidade do usuário
*   
* @param response A resposta para o client
* @param query O query da requisição
*/
function login(response, query) {
    if (query['method'] == "POST") {
        switch (query['function']) {
            case 'login':
                logar(response, query);
                break;
            case 'verifyTolken':
                verifyTolken(response, query);
                break;
            case 'setTolken':
                setTolken(response, query);
                break;
            case 'insereUsuario':
                insereUsuario(response, query);
                break;
            default:
                error(response, CONSTANTES.SUCESS.FALSO);
        }        
    }else {
        error(response, CONSTANTES.SUCESS.FALSO);
    }
}

function insereUsuario(response, query) {
    if (query['json']) {
        db.insereUsuario(JSON.parse(query['json']), function(sucess) {
            writeSucess(response, sucess);
        });
    } else {
        error(response, CONSTANTES,SUCESS,FALSO);
    }
}

/**
* Verifica autenticidade do usuário
*
* @param response A resposta para o client
* @param query O query da requisição
*/
function logar(response, query) {
    if (query['email'] && query['password']) {
        db.getUsuario(query['email'], function(usuario) {
            var json = '';
            if (usuario) {
                json = '{"sucess": "' + (usuario['password'] == query['password']) + '"}';
            } else {
                json = CONSTANTES.SUCESS.FALSO;
            }
            
            write(response, json);
        });
    } else {
        error(response, CONSTANTES.SUCESS.FALSO);
    }
}

/**
* Verifica se o tolken pertence ao usuário.
*/
function verifyTolken(response, query) {
    if (query['email'] && query['tolken']) {
        db.getTolkens(query['email'], function(tolkens) {
            if (tolkens) {
                contains(query['tolken'], tolkens, function(contain) {
                    var json = '{"sucess": "'+contain+'"}';
                    write(response, json);
                });
            } else { 
                error(response, CONSTANTES.SUCESS.FALSO);
            }
        });
    } else {
        error(response, CONSTANTES.SUCESS.FALSO);
    }
}

function contains(element, array, callback) {
    var length = array.length;
    function loop(){
        if (length) {
            if (element == array[--length]) {
                callback(true);
            } else {
                setTimeout(loop, 10);
            }
        } else {
            callback(false);
        }
    }
    loop();
}


function setTolken(response, query) {
    if (query['email'] && query['tolken']) {
        db.setTolkenUsuario(query['email'], query['tolken'], function(sucess) {
            var json = '{"sucess": "' + sucess + '"}';
            write(response, json);
        });
    } else {
        error(response, CONSTANTES.SUCESS.FALSO);
    }
}

function favicon(response, query) {
	// melhor colocar logo um favicon na pasta, pra não dar treta.
    response.end();
}

function writeSucess(response, sucess) {
    write(response, '{"sucess": "'+sucess+'"}');
}

function write(response, msg) {
	response.write(msg);
	response.end();
}

function error(response, msg) {
    write(response, msg);
}

exports.handlers = handlers;