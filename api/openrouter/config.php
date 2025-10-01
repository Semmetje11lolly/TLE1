<?php
/**
 * OpenRouter API Configuration
 *
 * IMPORTANT: For security, set your API key in includes/env.php instead of hardcoding it here.
 * This file provides fallback defaults when ConfigManager is not used.
 *
 * Recommended usage: Use ConfigManager::getInstance() instead of requiring this file directly.
 */

// Load includes/env.php for API key constant
$includesEnvPath = __DIR__ . '/../../includes/env.php';
if (file_exists($includesEnvPath)) {
    require_once $includesEnvPath;
}

return [
    'api_key' => (defined('OPENROUTER_API_KEY') ? OPENROUTER_API_KEY : null) ?: getenv('OPENROUTER_API_KEY') ?: '',
    'model' => getenv('OPENROUTER_MODEL') ?: 'openai/gpt-oss-120b',
    'max_tokens' => (int)(getenv('OPENROUTER_MAX_TOKENS') ?: 1000),
    'temperature' => (float)(getenv('OPENROUTER_TEMPERATURE') ?: 0.7)
];