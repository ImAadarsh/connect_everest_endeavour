<?php
require_once 'common/config/db_connect.php';

// Initialize response array
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    $budget = isset($_POST['budget']) ? trim($_POST['budget']) : '';

    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $response['status'] = 'error';
        $response['message'] = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['status'] = 'error';
        $response['message'] = 'Please enter a valid email address.';
    } else {
        try {
            // Prepare SQL statement
            $sql = "INSERT INTO contact_messages (name, email, subject, message, budget, created_at) 
                    VALUES (:name, :email, :subject, :message, :budget, NOW())";
            
            $stmt = $conn->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':message', $message);
            $stmt->bindParam(':budget', $budget);
            
            // Execute the statement
            if ($stmt->execute()) {
                // Send email notification
                $to = "hello@connecteverest.co.uk";
                $email_subject = "New Contact Form Submission: " . $subject;
                
                $email_body = "You have received a new contact form submission:\n\n";
                $email_body .= "Name: " . $name . "\n";
                $email_body .= "Email: " . $email . "\n";
                $email_body .= "Subject: " . $subject . "\n";
                $email_body .= "Budget: " . $budget . "\n\n";
                $email_body .= "Message:\n" . $message;
                
                $headers = "From: " . $email . "\r\n";
                $headers .= "Reply-To: " . $email . "\r\n";
                $headers .= "X-Mailer: PHP/" . phpversion();
                
                mail($to, $email_subject, $email_body, $headers);
                
                $response['status'] = 'success';
                $response['message'] = 'Thank you for your message. We will get back to you soon!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Sorry, there was an error sending your message. Please try again later.';
            }
        } catch(PDOException $e) {
            $response['status'] = 'error';
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?> 