<?php
// Test environment variables
header('Content-Type: application/json');

$env = [
    'CLAUDE_API_KEY' => getenv('CLAUDE_API_KEY') !== false ? 'SET (length: ' . strlen(getenv('CLAUDE_API_KEY')) . ')' : 'NOT SET',
    'AMAZON_AFFILIATE_TAG' => getenv('AMAZON_AFFILIATE_TAG') !== false ? getenv('AMAZON_AFFILIATE_TAG') : 'NOT SET',
    'CRON_TOKEN' => getenv('CRON_TOKEN') !== false ? getenv('CRON_TOKEN') : 'NOT SET',
];

echo json_encode($env, JSON_PRETTY_PRINT);
