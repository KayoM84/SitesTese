<?php
// Conexão com o MySQL. Preencha apenas os 4 valores abaixo.
const DB_HOST = '127.0.0.1';     // o MySQL roda na mesma máquina (Codespace) que o PHP
const DB_NOME = 'app_login';     // criado pelo banco.sql
const DB_USUARIO = 'kayo';
const DB_SENHA = '1234';

function conectar(): PDO
{
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NOME . ';charset=utf8mb4';
    return new PDO($dsn, DB_USUARIO, DB_SENHA, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}

// Responde em JSON e encerra.
function responder(int $codigo, array $dados): void
{
    http_response_code($codigo);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit;
}

// Lê o corpo JSON enviado pela página.
function lerJson(): array
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        responder(405, ['erro' => 'Método não permitido.']);
    }
    $dados = json_decode(file_get_contents('php://input'), true);
    return is_array($dados) ? $dados : [];
}
