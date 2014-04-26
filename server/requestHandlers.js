var db = require("./notDB.js");

handlers = {
	      "/": start,
	 "/start": start,
	 "/save": save,
	"/favicon.ico": favicon
}

function start(response, query) {
	var code = query['code'];
	var page = query['page'];
	
	if (code) {
		db.getUltimaPaginaDe(code, function(ultimaPagina){
			page = (page >= 0 && page <= ultimaPagina)? page: ultimaPagina;
			
			db.getConteudoDe(code, page, function(content){
				response.write("Código: " + code + ", Página: " + page);
				response.write("\n" + content);
				response.end();
			});
		});
	} else {
		response.write("Digite um código!");
		response.end();
	}
}

// TO-DO
function save(response, query) { // lembrar que a verificação de que será salva na última página deve ser feita no front-end
	if (query["salvar"] == 'true' && query['content'] && query['code']) {
		db.getDocumento(query['code'], function(documento) {
			if (documento) {
				db.alterarDocumento(documento['_id'], documento['pages']-1, query['content'], function(pagina){
					console.log("alterado");
					start(response, query);
				});
			} else {
				db.criaDocumento(query['code'], function(documento){
					save(response, query);
				});
			}
		});
	} else {
		error(response, "Os dados estão incompletos!");
	}
}

function favicon() {
	// melhor colocar logo um favicon na pasta, pra não dar treta.
}

function error(response, msg) {
	response.write(msg);
	response.end();
}
exports.handlers = handlers;