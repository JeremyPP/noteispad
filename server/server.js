var http = require("http");

function start(route, handler){
	function onRequest(request, response) {
		response.writeHead(200, {"Content-Type": "text/plain; charset=utf-8"});
		
		route(request, response, handler);
	}
	
	http.createServer(onRequest).listen(8888);
	
	console.log("Server is up!");
}

exports.start = start;