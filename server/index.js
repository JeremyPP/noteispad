server   = require("./server.js");
router   = require("./router.js");
handlers = require("./requestHandlers.js");

server . start(router.route, handlers.handlers);
