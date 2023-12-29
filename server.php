<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $input = file_get_contents('php://input');

    // Decode the JSON data
    $newComment = json_decode($input, true);

    // Validate and sanitize the data
    $name = isset($newComment['name']) ? htmlspecialchars($newComment['name']) : '';
    $text = isset($newComment['text']) ? htmlspecialchars($newComment['text']) : '';

    // Check if both name and text are present
    if ($name !== '' && $text !== '') {
        // Read existing comments from the JSON file
        $comments = file_exists('comments.json') ? json_decode(file_get_contents('comments.json'), true) : [];

        // Add the new comment to the array
        $newComment['id'] = count($comments) + 1;
        $comments[] = $newComment;

        // Save the updated comments back to the JSON file
        file_put_contents('comments.json', json_encode($comments, JSON_PRETTY_PRINT));

        // Respond with the new comment
        http_response_code(201);
        echo json_encode($newComment);
    } else {
        // Invalid data, respond with an error
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Invalid data']);
    }
} else {
    // Respond with a 404 error for non-POST requests
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'Not Found']);
}
?>
