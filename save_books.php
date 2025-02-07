<?php
header("Access-Control-Allow-Origin: https://olivareznursinghub.netlify.app");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON format');
        }

        if (!is_array($data)) {
            throw new Exception('Data must be an array');
        }

        $result = file_put_contents('books.json', json_encode($data, JSON_PRETTY_PRINT));

        if ($result === false) {
            throw new Exception('Failed to save data');
        }

        echo json_encode(['success' => true, 'message' => 'Books saved successfully']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
}
?>