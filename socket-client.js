const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Server } = require("socket.io");
const io = new Server(server);

app.use(express.urlencoded({extended: true}));
app.use(express.json());

var mysql = require('mysql')
var connection = mysql.createConnection({
  host: '127.0.0.1',
  user: 'jeico',
  password: 'jeico',
  database: 'contact_tracing'
})

connection.connect()

// connection.end()

serverSocket = null;
io.on('connection', (socket) => {
    serverSocket = socket;
});

app.post('/api/scan', function (req, res) {
    let sqlQuery = `
        SELECT first_name, last_name, contact_number, address, barangays.name as barangay
        FROM contact_tracing.residents
        LEFT JOIN users
        ON residents.user_id = users.id
        LEFT JOIN barangays
        ON residents.barangay_id = barangays.id
        WHERE users.is_active = 1 AND residents.status = "APPROVED" AND residents.uuid = '` + req.body.uuid + `'`;

    connection.query(sqlQuery, function (err, rows, fields) {
        if (!err && rows.length > 0) {
            insertScannedResident(req.body.scanner_id, req.body.uuid);

            res.send(JSON.stringify({
                'is_exist': true,
                'resident': rows[0]
            }));
        } else {
            res.send(JSON.stringify({
                'is_exist': false,
            }));
        }
    });
});

function insertScannedResident(scanner_id, uuid) {
    let sqlQuery = `SELECT id FROM contact_tracing.residents WHERE residents.uuid = '` + uuid + `'`;

    let is_active_case = 0;
    connection.query(sqlQuery, function (err, rows, fields) {
        if (!err && rows.length > 0) {
            let resident_id = rows[0].id;
            sqlQuery = `INSERT INTO scanned_residents (resident_id, scanner_id, is_active_case) VALUES (` + resident_id + `, ` + scanner_id + `, ` + is_active_case + `)`;
            connection.query(sqlQuery, function (err, rows, fields) {
                serverSocket.emit("resident_scanned", { 'resident_id': resident_id, 'scanner_id': scanner_id, 'is_active_case': is_active_case });
            });
        }
    });
}

server.listen(3000);
