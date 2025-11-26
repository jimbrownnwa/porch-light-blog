<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

// Extend PHP timeout for API calls
set_time_limit(180);

header('Content-Type: application/json');

// Validate cron token
$token = $_GET['token'] ?? '';
if ($token !== CRON_TOKEN) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Invalid or missing token']);
    exit;
}

// Check if we can generate a new post
if (!canGeneratePost()) {
    echo json_encode(['status' => 'skipped', 'message' => 'Too soon since last post']);
    exit;
}

// Get next topic
$topicData = getNextTopic();
if (!$topicData) {
    echo json_encode(['status' => 'error', 'message' => 'No unused topics available']);
    exit;
}

$topic = $topicData['topic'];
$topicId = $topicData['id'];

// Load prompt template from claude.md
$promptTemplate = file_get_contents(__DIR__ . '/claude.md');
if ($promptTemplate === false) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to load claude.md prompt template']);
    exit;
}

// Replace {{TOPIC}} placeholder with actual topic
$prompt = str_replace('{{TOPIC}}', $topic, $promptTemplate);

// Strip the markdown header if present (first line starting with #)
$prompt = preg_replace('/^#[^\n]*\n+/', '', $prompt);

// Check API key is set
if (empty(CLAUDE_API_KEY)) {
    echo json_encode(['status' => 'error', 'message' => 'CLAUDE_API_KEY environment variable not set']);
    exit;
}

// Call Claude API
$ch = curl_init('https://api.anthropic.com/v1/messages');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_TIMEOUT => 120,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'x-api-key: ' . CLAUDE_API_KEY,
        'anthropic-version: 2023-06-01'
    ],
    CURLOPT_POSTFIELDS => json_encode([
        'model' => CLAUDE_MODEL,
        'max_tokens' => 4096,
        'messages' => [
            ['role' => 'user', 'content' => $prompt]
        ]
    ])
]);

$response = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($curlError) {
    echo json_encode(['status' => 'error', 'message' => 'cURL error: ' . $curlError]);
    exit;
}

if ($httpCode !== 200) {
    echo json_encode(['status' => 'error', 'message' => 'API request failed', 'code' => $httpCode, 'response' => $response]);
    exit;
}

$apiResponse = json_decode($response, true);
$content = $apiResponse['content'][0]['text'] ?? '';

// Strip markdown code blocks if present
$content = preg_replace('/^```json\s*/', '', $content);
$content = preg_replace('/\s*```$/', '', $content);

// Parse the JSON response from Claude
$postData = json_decode($content, true);
if (!$postData) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to parse Claude response', 'raw' => $content]);
    exit;
}

// Generate slug from title
$slug = strtolower(trim($postData['title']));
$slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
$slug = trim($slug, '-');
$slug = substr($slug, 0, 100);

// Generate books HTML with affiliate links
$booksHtml = '<div class="recommended-books"><h3>Recommended Reading</h3>';
foreach ($postData['books'] as $book) {
    $searchQuery = urlencode($book['amazon_search']);
    $affiliateLink = "https://www.amazon.com/s?k={$searchQuery}&tag=" . AMAZON_AFFILIATE_TAG;

    $booksHtml .= '<div class="book-item">';
    $booksHtml .= '<h4><a href="' . htmlspecialchars($affiliateLink) . '" target="_blank" rel="noopener">' . htmlspecialchars($book['title']) . '</a></h4>';
    $booksHtml .= '<p class="book-author">by ' . htmlspecialchars($book['author']) . '</p>';
    $booksHtml .= '<p class="book-desc">' . htmlspecialchars($book['description']) . '</p>';
    $booksHtml .= '</div>';
}
$booksHtml .= '</div>';

// Save post to database
$postId = savePost(
    $postData['title'],
    $slug,
    $postData['meta_description'],
    $postData['content'],
    $booksHtml,
    $topic
);

// Mark topic as used
markTopicUsed($topicId);

echo json_encode([
    'status' => 'success',
    'post_id' => $postId,
    'title' => $postData['title'],
    'slug' => $slug
]);
