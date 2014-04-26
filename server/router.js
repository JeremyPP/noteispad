var url = require("url");

function route(request, response, handler) {
	var parse = url.parse(request['url'], true);
	var pathname = parse.pathname;
	var query = parse.query;
	
	if (pathname in handler) {
		handler[pathname](response, query);
	} else {
		respose.write("404 error");
		response.end();
	}
}

exports.route = route;