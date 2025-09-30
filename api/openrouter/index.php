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
require_once 'ConfigManager.php';

try {
    // Get config manager
    $configManager = ConfigManager::getInstance();

    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['message'])) {
        throw new Exception('Message required');
    }

    // Create client using ConfigManager
    $client = new OpenRouterClient(
        $configManager->getApiKey(),
        $configManager->getModel()
    );

    $response = $client->chat([
        ['role' => 'user', 'content' => $input['message']]
    ], [
        'max_tokens' => $configManager->getMaxTokens(),
        'temperature' => $configManager->getTemperature()
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