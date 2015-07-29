var redis  = require('redis');
var client = redis.createClient();

module.exports = function(app) {
	
	// api
	app.get('/api/getPendings', function(req, res) {
		
		client.lrange('resque:queue:default',0, -1, function(error, replies){

	    	var result = [];
			replies.forEach(function(item){
				var parsed = JSON.parse(item);
				

				result.push({
					'name' : parsed.args[0].name , 
					'mobno' : parsed.args[0].mobno, 
					'email' : parsed.args[0].email
				})
			})
			res.json(result);	
			res.end();
		});

	});

	// load index html file
	app.get('*', function(req, res) {
		res.sendfile('./public/index.html');
	});
};