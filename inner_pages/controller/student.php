<?php
require_once '../../common/config/db_connect.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
        $education = filter_input(INPUT_POST, 'education', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        if (!$name || !$email || !$phone || !$country || !$message) {
            throw new Exception("Required fields are missing");
        }

        $stmt = $conn->prepare("INSERT INTO student_applications (name, email, phone, country, education_level, message) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $country, $education, $message]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Thank you for your application. We will review it and get back to you soon!'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'There was an error processing your application. Please try again.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}
?> 