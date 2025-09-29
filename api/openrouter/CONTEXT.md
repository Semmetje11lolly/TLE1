# OpenRouter API Context

## What it does
PHP API that connects to OpenRouter AI service for text generation and chat functionality.

## Files
- `config.php` - API key and model settings
- `OpenRouterClient.php` - Main API client class  
- `index.php` - HTTP endpoint for POST requests
- `test_api.php` - Test script

## Usage
**Endpoint**: `POST /api/openrouter/index.php`

**Request**:
```json
{"message": "Your prompt here"}
```

**Response**:
```json
{"success": true, "response": "AI response"}
```

## Current Config
- Model: `openai/gpt-oss-120b`
- Max tokens: 1000
- Temperature: 0.7

## Use Cases
- Chatbot/virtual assistant
- Content generation
- Text processing
- Code assistance
- Educational tools