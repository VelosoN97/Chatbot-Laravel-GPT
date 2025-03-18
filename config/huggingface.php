<?php

return [
    'api_key' => env('HUGGINGFACE_API_KEY'),
    'model' => env('HUGGINGFACE_MODEL', 'gpt2'),
    'endpoint' => 'https://api-inference.huggingface.co/models/',
];