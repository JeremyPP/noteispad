var CONSTANTES = require("./constantes.js").CONSTANTES;
var mongoq = require("mongoq");
var db = mongoq("mongodb://127.0.0.1:27017/notispad", {safe:false});
var planos     = db.collection("planos");
var documentos = db.collection("documentos");
var paginas    = db.collection("paginas");
var usuarios   = db.collection("usuarios");
var versoes    = db.collection("versoes");

// TO-DO: Colocar callback em todas essas funções, o banco de dados só funciona com callback, adapte tudo para ele.
// TODOZADO

/**
* Pega a última página de um documento específico. (ie, um documento com cinco páginas, a última página é 4)
*
* @param code O código do documento.
* @param callback callback(ultimaPagina); A função que receberá a última página. Caso não seja um código existente, a última página é 0;
*/
function getUltimaPaginaDe(code, callback) {
	getDocumento(code, function(documento){
		if (documento) {
			callback(documento["pages"] - 1);
		} else {
			callback(0);
		}		
	});
}

/**
* Recuperar o conteúdo da última versão de uma página em um Documento qualquer.
*
*@param code O código do documento,
*@param page Uma página. Se o documento existir, esse valor deve também existir.
*@param callback callback(conteudo); Recupera o conteudo da ultima versao de uma página em um documento. Caso não exista, o valor padrão será recuperado
*/
function getConteudoDe(code, page, callback) {
	getDocumento(code, function(documento){
		if (documento) {
			getUltimaVersaoDe(documento, page, function(versao) {
				if (versao) {
                    callback(versao['content']);
                } else {
                    getConteudoDe(CONSTANTES.PADRAO.DOCUMENTO._id, CONSTANTES.PADRAO.PAGINA.page, callback);
                }
			});
		} else {
			getConteudoDe(CONSTANTES.PADRAO.DOCUMENTO._id, CONSTANTES.PADRAO.PAGINA.page, callback);
		}
	});
}

/**
* Recuperar o documento do código especificado, se esse existir.
* 
* @param code O código do Documento desejado.
* @param callback callback(documento); Retorna o documento. Retorna null caso não exista o documento.
*/
function getDocumento(code, callback) {
	documentos.findOne({_id: code})
	.done(callback)
	.fail(function(err){
			console.log("erro no getDocumento - documento notDB.js\n"+err);
		});
}

/**
* Recupera a última versão de uma página especificada em um Documento existente.
*
* @param documento Um documento existente
* @param page Uma página existente.
* @param callback callback(versao); Retorna a última versão
*/
function getUltimaVersaoDe(documento, page, callback) {
	paginas.findOne({document: documento["_id"], page: parseInt(page)})
	.done(function(pagina){
            if (pagina) {
                versoes.findOne({document: pagina['document'], page: parseInt(page), version: pagina['versions'] - 1})
                .done(callback)
                .fail(function(err){
                        console.log("erro no getUltimaVersaoDe - documento notDB.js\n"+err);
                    });
            } else {
                callback(null);
            }
		})
	.fail(function(err){
			console.log("erro no getDocumento - documento notDB.js\n"+err);
		});
}

/**
* Insere uma página vaizia no documento já existente
* 
* @param code O codigo de um documento existente
* @param callback callback(pagina); Retorna a página inserida
*/
function inserePaginaNoDocumento(code, callback){
	documentos.findAndModify({_id: code}, {_id:1},{$inc: {pages: 1}}, {upsert:false})
	.done(function(documento){
			paginas.insert({document: documento["_id"], page: documento['pages'], versions: 1})
			.done(function(pagina){
					versoes.insert(
						{
							document: documento["_id"],
							page: pagina[0]['page'],
							version: 0,
							content: "",
							created: new Date().getTime()}
						)
					.done(function(){
							callback(pagina);
						})
					.fail(function(err){
							console.log("erro no inserePaginaNoDocumento - documento notDB.js\n"+err);
						});
				})
			.fail(function(err){
					console.log("erro no inserePaginaNoDocumento - documento notDB.js\n"+err);
				});
			
		})
	.fail(function(err){
			console.log("erro no inserePaginaNoDocumento - documento notDB.js\n"+err);
		});
}

/**
* Adiciona uma nova versão com o conteúdo especificado a página.
*
* @param code Um código de um documento existente.
* @param page Uma página existente.
* @param content O conteúdo em formato texto.
* @param callback callback(versao) retorna a ultima versao da pagina.
*/
function alterarDocumento(code, page, content, callback) {
	paginas.findAndModify({document: code, page: parseInt(page)}, {page:1}, {$inc:{versions: 1}}, {upsert:false})
	.done(function(pagina){
			versoes.insert(
				{
					document: code,
					page: parseInt(page),
					version: pagina['versions'],
					content: content,
					created: new Date().getTime()
				})
			.done(function(versao){
					callback(versao[0]);
				})
			.fail(function(err){
					console.log("erro no alterarDocumento - documento notDB.js\n"+err);
				});
		})
	.fail(function(err){
			console.log("erro no alterarDocumento - documento notDB.js\n"+err);
		});
}

/**
* Cria uma nova entrada no banco de dados com o código especificado.
*
*@param code O código do novo documento. Esta função só deve ser chamada se a certeza da inexistencia do código for comprovada.
*@param callback callback(documento) Retorna o documento criado
*/
function criaDocumento(code, callback){
	documentos.insert({_id: code, pages: 0})
	.done(function(documentos){
			inserePaginaNoDocumento(documentos[0]['_id'],  function(pagina){
					callback(documentos[0]);
				});
		})
	.fail(function(err){
			console.log("erro no criaDocumento - documento notDB.js\n"+err);
		});
}

/**
* Retorna o usuario com o email especificado.
*
* @param email O email do usuário
* @param callback; callback(usuario). Retorna o usuario, caso exista, null caso contrário
*/
function getUsuario(email, callback) {
    usuarios.findOne({_id: email})
    .done(callback)
	.fail(function(err){
			console.log("erro no getUsuario - documento notDB.js\n"+err);
            callback(null);
		});
}

/**
* Adiciona um tolken ao usuário.
*
* @param email O email do usuário
* @param tolken O tolken a ser adicionado
* @param callback; callback(usuario). Retorna true se adicionou false caso contrário.
*/
function setTolkenUsuario(email, tolken, callback) {
    console.log(tolken);
    usuarios.update({_id: email}, {$push: {"tolkens": tolken}}, {upsert: false})
    .done(function(usuario) {
            callback(true);
        })
	.fail(function(err){
			console.log("erro no setTolken - documento notDB.js\n"+err);
            callback(false);
		});
}

/**
* Retorna os tolkens do usuario
*
* @param email O email do usuario
* @param callback callback(tolkens) A array de tolkens do usuario. OU null se nao existir usuario.
*/
function getTolkens(email, callback) {
    usuarios.findOne({_id: email})
    .done(function(usuario){
            if (usuario) {
                callback(usuario['tolkens']);
            } else {
                callback(null);
            }
        })
	.fail(function(err){
			console.log("erro no getTolkens - documento notDB.js\n"+err);
            callback(null);
		});
    
}

/**
* Retorna o número de páginas do documento
*
* @param code O código do documento.
* @param callback; callback(paginas) Número de páginas
*/
function getPaginas(code, callback) {
    documentos.findOne({_id: code})
    .done(function(documento) {
        if (documento) {
            callback(documento['pages']);
        } else {
            callback(0);
        }
    })
	.fail(function(err){
			console.log("erro no getPaginas - documento notDB.js\n"+err);
            callback(false);
		});
}

/**
* @param json Um string json com os dados a serem inseridos na coleção usuários.
*/
function insereUsuario(json, callback) {
    usuarios.insert(json)
    .done(function(usuario){
        callback(usuario?true:false);
    })
	.fail(function(err){
			console.log("erro no insereUsuario - documento notDB.js\n"+err);
            callback(false);
		});
}

function getPlano(plano, callback) {
    planos.findOne({_id: plano})
    .done(callback)
	.fail(function(err){
			console.log("erro no getPlano - documento notDB.js\n"+err);
            callback(false);
		});
}

function trocaUsuarioNota(code, email, callback) {
    documentos.update({_id: code}, {$set:{user: email}})
    .done(function(documento){
        callback(documento?true:false);
        })
	.fail(function(err){
			console.log("erro no trocaUsuarioNota - documento notDB.js\n"+err);
            callback(false);
		});
}

function appendNotaUsuario(email, code, callback) {
    usuarios.update({_id: email}, {$push:{codes:code}})
    .done(function(usuario){
        callback(usuario?true:false);
        })
	.fail(function(err){
			console.log("erro no appendNotaUsuario - documento notDB.js\n"+err);
            callback(false);
		});
}

/**
* Retorna nova quantidade
*/
function incrementaNotasUsuario(email, qnt, callback) {
    usuarios.update({_id:email}, {$inc:{notes:qnt}})
    .done(function(usuario){
        callback(usuario?usuario[0]['notes']:false);
        })
	.fail(function(err){
			console.log("erro no incrementaNotasUsuario - documento notDB.js\n"+err);
            callback(false);
		});
}

exports.incrementaNotasUsuario = incrementaNotasUsuario;
exports.appendNotaUsuario = appendNotaUsuario;
exports.getDocumento = getDocumento;
exports.getUltimaPaginaDe = getUltimaPaginaDe;
exports.getConteudoDe = getConteudoDe;
exports.inserePaginaNoDocumento = inserePaginaNoDocumento;
exports.alterarDocumento = alterarDocumento;
exports.criaDocumento = criaDocumento;
exports.getUsuario = getUsuario;
exports.setTolkenUsuario = setTolkenUsuario;
exports.getPaginas = getPaginas;
exports.getTolkens = getTolkens;
exports.insereUsuario = insereUsuario;
exports.getPlano = getPlano;
exports.trocaUsuarioNota = trocaUsuarioNota;