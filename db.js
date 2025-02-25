const mysql = require('mysql');

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'loja_bd'
});

connection.connect((err) => {
    if (err) {
        console.error('Erro ao conectar ao banco de dados: ' + err.stack);
        return;
    }
    console.log('Conectado ao banco de dados como ID ' + connection.threadId);
});

// Comando para inserir um cliente
const insertCliente = `
INSERT INTO clientes (name, email, password) VALUES ('Cliente Teste', 'cliente@teste.com', 'senha123');
`;

connection.query(insertCliente, (error) => {
    if (error) {
        console.error('Erro ao inserir cliente:', error);
        return;
    }
    console.log('Cliente inserido com sucesso.');
});

module.exports = connection;
