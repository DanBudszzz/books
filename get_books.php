<?php
header("Access-Control-Allow-Origin: https://olivareznursinghub.netlify.app");
header("Content-Type: application/json");

try {
    if (!file_exists('books.json')) {
        file_put_contents('books.json', '[]');
    }

    $books = file_get_contents('books.json');
    
    if ($books === false) {
        throw new Exception('Failed to read books file');
    }

    // Validate JSON
    json_decode($books);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON format in books file');
    }

    echo $books;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}
?>