<?php
require_once 'OpenRouterClient.php';
require_once 'ConfigManager.php';

echo "=== OpenRouter API Test ===\n";

try {
    // Get config manager
    $configManager = ConfigManager::getInstance();

    echo "Model: " . $configManager->getModel() . "\n";
    echo "API Key: " . substr($configManager->getApiKey(), 0, 10) . "...\n\n";

    $client = new OpenRouterClient(
        $configManager->getApiKey(),
        $configManager->getModel()
    );

    echo "Testing OpenRouter API...\n";

    $response = $client->chat([
        ['role' => 'user', 'content' => 'Hello! Please respond with just "API is working" if you can see this message.']
    ], [
        'max_tokens' => $configManager->getMaxTokens(),
        'temperature' => $configManager->getTemperature()
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