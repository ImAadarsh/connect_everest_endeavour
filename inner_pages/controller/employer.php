<?php
require_once '../../common/config/db_connect.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $company_name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $industry = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        if (!$company_name || !$email || !$message) {
            throw new Exception("Required fields are missing");
        }

        $stmt = $conn->prepare("INSERT INTO employer_requests (company_name, email, industry, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$company_name, $email, $industry, $message]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Thank you for your interest. We will review your request and get back to you soon!'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'There was an error processing your request. Please try again.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}
?> 