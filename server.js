var socket = require( 'socket.io' );
var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = socket.listen( server );
var port = process.env.PORT || 3000;
server.listen(port, function () {
	console.log('Server listening at port %d', port);
});
/* Creating POOL MySQL connection.*/
var mysql     =     require("mysql");
var conn    =    mysql.createPool({
      connectionLimit   :   100,
      host              :   'localhost',
      user              :   'root',
      password          :   '',
      database          :   'shopdoithev2',
      debug             :   false
});

io.on('connection', function (socket,data) {
	socket.on( 'call_data', function( data ) {
		if(data == 'success'){
			setInterval(function(){
				var sql = "SELECT `C`.*, `CS`.`http_code` as `http_code` FROM `cards` `C` LEFT JOIN `callback_sends` `CS` ON `C`.`id` = `CS`.`card_id` ORDER BY `C`.`id` DESC LIMIT 30";
			    conn.query(sql, function (err,results, fields) {
			        if (err) throw err;
			        io.sockets.emit( 'send_data',results);
			    });
			    var datenow = formatDate(Date.now());
			   	var sqltotal = "SELECT SUM(receivevalue) as realvalue FROM `cards` WHERE `date_created` = '"+datenow+"' AND `status` = 1 ORDER BY `id` DESC";
			    conn.query(sqltotal, function (err,results, fields) {
			        if (err) throw err;
			        io.sockets.emit( 'send_totaltoday',results);
			    });
			    var sqltotalreal = "SELECT SUM(money_after_rate) as realvalue FROM `cards` WHERE `date_created` = '"+datenow+"' AND `status` = 1 ORDER BY `id` DESC";
			    conn.query(sqltotalreal, function (err,results, fields) {
			        if (err) throw err;
			        io.sockets.emit( 'send_totaltodayfee',results);
			    });
			}, 6000);
		}

	});



});
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;
    return [year, month, day].join('-');
}