<?php
header('Content-Type: application/json');

// Recipient email (your email)
$to_email = 'darshanhadole121@gmail.com';
$subject = 'New Appointment Request';

// Collect form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$date = $_POST['date'] ?? '';
$department = $_POST['department'] ?? '';
$doctor = $_POST['doctor'] ?? '';
$message = $_POST['message'] ?? '';

// Validate required fields
if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($department) || empty($doctor)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit;
}

// Format email content
$email_content = "Appointment Details:\n\n";
$email_content .= "Name: $name\n";
$email_content .= "Email: $email\n";
$email_content .= "Phone: $phone\n";
$email_content .= "Date: " . date('F j, Y, g:i a', strtotime($date)) . "\n";
$email_content .= "Department: $department\n";
$email_content .= "Doctor: $doctor\n";
$email_content .= "Message: $message\n";

// Email headers
$headers = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";

// Send email
if (mail($to_email, $subject, $email_content, $headers)) {
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to send email']);
}
?>