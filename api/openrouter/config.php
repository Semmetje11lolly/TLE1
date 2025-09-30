<?php
return [
    'api_key' => getenv('OPENROUTER_API_KEY') ?: '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',
    'model' => 'openai/gpt-oss-120b',  
    'max_tokens' => 1000,
    'temperature' => 0
];