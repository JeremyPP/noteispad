var url = require("url");
var querystring = require("querystring");

function route(request, response, handler) {
    var parse = url.parse(request['url'], true);
    var pathname = parse.pathname;
    
    switch (request.method) {
        case "GET":
            var query = parse.query;
                query['method'] = 'GET';
                
            hand(response, handler, pathname, query);
            break;
        case "POST":        
            var allPostData = '';
            request.on('data', function(chunk) {
                allPostData += chunk;
            });
            request.on('end', function() {
                var query = querystring.parse(allPostData);
                    query['method'] = 'POST';
                    
                hand(response, handler, pathname, query);
            });
            break;
        default:
            response.write('{"sucess": "false"}');
            response.end();
    }
}

function hand(response, handler, pathname, query) {
    if (pathname in handler) {
        handler[pathname](response, query);
    } else {
        respose.write("404 error");
        response.end();
    }
}

exports.route = route;