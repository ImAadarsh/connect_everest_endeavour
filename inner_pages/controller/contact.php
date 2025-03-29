<?php
require_once '../../common/config/db_connect.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
        $budget = filter_input(INPUT_POST, 'budget', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        if (!$name || !$email || !$message) {
            throw new Exception("Required fields are missing");
        }

        $stmt = $conn->prepare("INSERT INTO contact_queries (name, email, subject, budget, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $budget, $message]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Thank you for your message. We will get back to you soon!'
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
