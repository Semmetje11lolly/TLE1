<?php
class OpenRouterClient {
    private string $apiKey;
    private string $baseUrl = 'https://openrouter.ai/api/v1/chat/completions';
    private string $model;
    
    public function __construct(string $apiKey, string $model = 'openai/gpt-4o-mini') {
        $this->apiKey = $apiKey;
        $this->model = $model;
    }
    
    public function chat(array $messages, array $options = []): array {
        $payload = array_merge([
            'model' => $this->model,
            'messages' => $messages
        ], $options);
        
        $ch = curl_init($this->baseUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
                'HTTP-Referer: ' . ($_SERVER['HTTP_HOST'] ?? 'localhost'),
                'X-Title: ' . 'My App'
            ]
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception('API Error: ' . $response);
        }
        
        return json_decode($response, true);
    }
}