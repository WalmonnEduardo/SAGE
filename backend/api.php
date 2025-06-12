<?php
session_start();
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS')
{
    http_response_code(200);
    exit;
}
header("Content-Type: application/json");
if (!isset($_SESSION['usuarios']))
{
    $_SESSION['usuarios'] = [];
}
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'GET')
{
    echo json_encode(['usuarios' => $_SESSION['usuarios']]);
    exit;
}
if ($method === 'POST')
{
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['nome']) || trim($data['nome']) === '')
    {
        http_response_code(400);
        echo json_encode(['mensagem' => 'Nome inválido']);
        exit;
    }
    $nome = trim($data['nome']);
    $_SESSION['usuarios'][] = $nome;

    echo json_encode([
        'mensagem' => "Usuário '$nome' adicionado!",
        'usuarios' => $_SESSION['usuarios']
    ]);
    exit;
}
http_response_code(405);
echo json_encode(['mensagem' => 'Método não permitido']);
