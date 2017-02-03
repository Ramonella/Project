var express = require('express'),
app = express(),
server = require('http').createServer(app),
io = require('socket.io').listen(server);
conversations = {};

app.get('/', function(request, response){
	
	response.sendFile(__dirname+'/index.html');

});


io.sockets.on('connection', function(socket) {
    
    console.log('Client connected!');
    socket.on('room', function(room) {
        console.log('client on room ', room);
        socket.join(room);
    });

    socket.on('send.message', function(data){
    	
    	console.log("message ", data.message, data.user);
		io.sockets.in(data.room).emit('message', {
			room : data.room,
			message : data.message,
			user : data.user,
            time : data.time,
            user_id : data.user_id
		});

    });
});


server.listen(3000);
