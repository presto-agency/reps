'use strict';

const express = require('express');
const http = require('http');
const socketio = require('socket.io');
class Server {
    constructor() {
        this.port = process.env.SOCKET_PORT || 3001;
        this.host = process.env.SOCKET_HOST || 'reps.loc';
        this.app = express();
        this.http = http.Server(this.app);
        this.socket = socketio(this.http);
    }

    appRun() {
        this.app.use(express.static(__dirname + '/uploads'));


        this.http.listen(this.port, this.host, () => {
            console.log(`Listening on http://${this.host}:${this.port}`);

        this.socket.on('connection', ()=>{
            console.log('user connected')
        })

        });

    }
}

const app = new Server();
app.appRun();
