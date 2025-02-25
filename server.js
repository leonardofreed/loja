const express = require('express');
const bodyParser = require('body-parser');
const connection = require('./db');

const app = express();
const PORT = 3000;

app.use(bodyParser.json());

app.post('/api/cadastrar', (req, res) => {
    const { name, email, password } = req.body;
    console.log('Dados recebidos:', { name, email, password });
    const query = 'INSERT INTO clientes (name, email, password) VALUES (?, ?, ?)';

    
    connection.query(query, [name, email, password], (error, results) => {
        if (error) {
            console.error('Erro ao cadastrar cliente:', error);
            return res.status(500).json({ success: false, message: 'Erro ao cadastrar cliente.' });

        }
        res.json({ success: true, message: 'Cliente cadastrado com sucesso!' });
    });
});

app.get('/api/pedidos', (req, res) => {
    const query = 'SELECT * FROM pedidos'; // Supondo que exista uma tabela de pedidos
    connection.query(query, (error, results) => {
        if (error) {
            return res.status(500).json({ success: false, message: 'Erro ao recuperar pedidos.' });
        }
        res.json({ success: true, pedidos: results });
    });
});

app.listen(PORT, () => {

    console.log(`Servidor rodando na porta ${PORT}`);
});
