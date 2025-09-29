<?php
return [
    'api_key' => getenv('OPENROUTER_API_KEY') ?: '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',
    'model' => 'openai/gpt-oss-120b',  
    'max_tokens' => 1000,
    'temperature' => 0.7
];