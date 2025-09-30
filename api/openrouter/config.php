<?php
/**
 * OpenRouter API Configuration
 *
 * IMPORTANT: For security, set your API key in the .env file instead of hardcoding it here.
 * This file provides fallback defaults when ConfigManager is not used.
 *
 * Recommended usage: Use ConfigManager::getInstance() instead of requiring this file directly.
 */

return [
    'api_key' => getenv('OPENROUTER_API_KEY') ?: '',
    'model' => getenv('OPENROUTER_MODEL') ?: 'openai/gpt-oss-120b',
    'max_tokens' => (int)(getenv('OPENROUTER_MAX_TOKENS') ?: 1000),
    'temperature' => (float)(getenv('OPENROUTER_TEMPERATURE') ?: 0.7)
];