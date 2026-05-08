<?php
// API Endpoint: Send Message

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    // Validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "❌ Please fill in all required fields.";
        exit;
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ Invalid email address.";
        exit;
    }
    
    // Length validation
    if (strlen($message) < 10 || strlen($message) > 5000) {
        echo "❌ Message must be between 10 and 5000 characters.";
        exit;
    }
    
    // Generate ticket
    $ticket = 'MSG-' . strtoupper(uniqid());
    
    echo "✅ Thank you for contacting us! Your message has been received.<br>";
    echo "Ticket Number: <strong>{$ticket}</strong><br>";
    echo "We will get back to you within 24 hours at " . htmlspecialchars($email) . ".";
} else {
    echo "❌ Invalid request method.";
}
?>
