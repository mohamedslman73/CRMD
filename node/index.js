var app = require('express')();
var server = require('http').Server(app);
var redis = require('redis');
var mysql = require('mysql');
var io = require('socket.io')(server);

server.listen('7000');
 io.on('connection',function (socket) {
     var redisClient = redis.createClient();
     console.log('new connection started');
     redisClient.subscribe('message');

     redisClient.on('message',function (channel,message) {
         console.log('new message in queue',channel,message);
         socket.emit(channel,message);
     });
     /*
     {"body":" teststrest ","room_id":"4"}
      */
     socket.on('message',function(data){
         var sockets = io.sockets.sockets;
         var obj=JSON.stringify(data);
         var id=JSON.parse(obj);
         /*sockets.forEach(function(sock){
             if(sock.id != socket.id)
             {
                 sock.emit('message',data);
             }
         })*/

         socket.broadcast.emit('message', id.data);
         console.log(id.data);
     })
     socket.on('chat',function(data){
         var sockets = io.sockets.sockets;
         var obj=JSON.stringify(data);
         var id=JSON.parse(obj);
         // var body = data.body;
          var name = data.name;
         // var sender_id = data.sender_id ;
         // var receiver_id = data.receive_id ;
         //
         // var conn =mysql.createConnection({
         //     host:"localhost",
         //     user:"root",
         //     password:"123456",
         //     database:"crm",
         // }) ;
         // if (room_id ==null || room_id==undefined) {
         //    conn.query('INSERT INTO rooms (name) VALUES("test")');
         //    var any= conn.query(
         //         'SELECT MAX(id) FROM rooms',
         //         function (error,rows) {
         //             if(error) throw error;
         //             console.log(error);
         //             users = rows;
         //             //console.log(rows);
         //         }
         //     );
         //    console.log(any.id);
         // }
         /*sockets.forEach(function(sock){
             if(sock.id != socket.id)
             {
                 sock.emit('message',data);
             }
         })*/
         socket.broadcast.emit('message',id.data,name);
         console.log(id.data,name);
     })

 });
app.get('/',function (request,reponse) {
    reponse.sendFile(__dirname + '/index.html');
});
/*
var conn =mysql.createConnection({
    host:"localhost",
    user:"root",
    password:"123456",
    database:"crm",
}) ;

conn.connect(function (error) {
    if (error){
         console.log('there are an error');
         return;
    }
    console.log('connection done !');
});

/!*conn.query(
    'SELECT * FROM users',
    function (error,rows) {
        if(error) throw error;
        console.log(error);
        users = rows;
        console.log(rows);
    }
);*!/

conn.end(function (error) {
    if (error)
    {
        console.log('connection disconnected error');
        return;
    }
});

server.listen('4000');
var io = require('socket.io')(server);

app.get('/',function (request,reponse) {
    reponse.sendFile(__dirname + '/index.html');
});

io.on('connection',function (socket) {
   // console.log('test messaging');
    socket.on('newMessage', function (data,room,name) {
       // console.log('there are a new message '+data/!*+'on Room'+room*!/);
       // socket.to(room).emit('clientMessage',data)
        socket.to(room).emit('clientMessage',[name,data]);

    });

    socket.on('joinRoom', function (data) {
        // console.log('there are a new message '+data/!*+'on Room'+room*!/);
        // socket.to(room).emit('clientMessage',data)
         console.log('user join room '+ data);
        socket.join(data);

    });

    socket.on('leaveRoom', function (data) {
        // console.log('there are a new message '+data/!*+'on Room'+room*!/);
        // socket.to(room).emit('clientMessage',data)
        console.log('user leave this room '+ data);
        socket.leave(data);

    });
});

*/
