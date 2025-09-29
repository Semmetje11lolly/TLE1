<?php
require_once 'OpenRouterClient.php';
$config = require 'config.php';

echo "=== OpenRouter API Test ===\n";
echo "Model: " . $config['model'] . "\n";
echo "API Key: " . substr($config['api_key'], 0, 10) . "...\n\n";

try {
    $client = new OpenRouterClient($config['api_key'], $config['model']);
    
    echo "Testing OpenRouter API...\n";
    
    $response = $client->chat([
        ['role' => 'user', 'content' => 'Hello! Please respond with just "API is working" if you can see this message.']
    ], [
        'max_tokens' => $config['max_tokens'],
        'temperature' => $config['temperature']
    ]);
    
    if (isset($response['choices'][0]['message']['content'])) {
        echo "✅ SUCCESS!\n";
        echo "Response: " . $response['choices'][0]['message']['content'] . "\n";
    } else {
        echo "❌ FAILED - No response content found\n";
        echo "Full response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";