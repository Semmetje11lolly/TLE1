<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Method not allowed']));
}

require_once 'OpenRouterClient.php';
$config = require 'config.php';

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['message'])) {
        throw new Exception('Message required');
    }
    
    $client = new OpenRouterClient($config['api_key'], $config['model']);
    
    $response = $client->chat([
        ['role' => 'user', 'content' => $input['message']]
    ], [
        'max_tokens' => $config['max_tokens'],
        'temperature' => $config['temperature']
    ]);
    
    echo json_encode([
        'success' => true,
        'response' => $response['choices'][0]['message']['content']
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}