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

    socket.on('room_default', function(room){
        console.log('Client on default room ', room);
        socket.join(room);

    });

    socket.on('send.message', function(data){
    	
    	console.log("message ", data.message, data.user);
		io.sockets.in(data.room).emit('message', {
			room : data.room,
			message : data.message,
			user : data.user,
            time : data.time,
            message_seen : data.message_seen,
            user_id : data.user_id,
            receiver : data.receiver
		});

    });
    socket.on('get.users', function(room){
        var no_room = io.sockets.adapter.rooms[room];
        io.sockets.in(room).emit('send.users', no_room.length);
    });

    socket.on('notify_user', function(data){
        console.log('Notify user in room ', data.user, ' open room: ', data.room);
        io.sockets.in(data.user).emit('new.message', {
            room : data.room,
            emitter : data.emitter,
            emitter_name : data.emitter_name
        });
    });

    socket.on('clear.chat', function(room){
        console.log('Clear chat ', room);
        io.sockets.in(room).emit('delete.chat', {
            room : room
        });
    });
   
});


server.listen(3000);
