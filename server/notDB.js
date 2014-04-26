var CONSTANTES = require("./constantes.js").CONSTANTES;
var mongoq = require("mongoq");
var db = mongoq("mongodb://127.0.0.1:27017/notispad", {safe:false});
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
				callback(versao['content']);
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
			versoes.findOne({document: pagina['document'], page: parseInt(page), version: pagina['versions'] - 1})
			.done(callback)
			.fail(function(err){
					console.log("erro no getUltimaVersaoDe - documento notDB.js\n"+err);
				});
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

exports.getDocumento = getDocumento;
exports.getUltimaPaginaDe = getUltimaPaginaDe;
exports.getConteudoDe = getConteudoDe;
exports.inserePaginaNoDocumento = inserePaginaNoDocumento;
exports.alterarDocumento = alterarDocumento;
exports.criaDocumento = criaDocumento;