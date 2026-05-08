<?php
// API Endpoint: File Claim

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $claim_type = isset($_POST['claim_type']) ? trim($_POST['claim_type']) : '';
    $claim_date = isset($_POST['claim_date']) ? trim($_POST['claim_date']) : '';
    $claim_amount = isset($_POST['claim_amount']) ? floatval($_POST['claim_amount']) : 0;
    $policy_number = isset($_POST['policy_number']) ? trim($_POST['policy_number']) : '';
    $claimant_name = isset($_POST['claimant_name']) ? trim($_POST['claimant_name']) : '';
    $claimant_email = isset($_POST['claimant_email']) ? trim($_POST['claimant_email']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $supporting_info = isset($_POST['supporting_info']) ? trim($_POST['supporting_info']) : '';
    
    // Validation
    if (empty($claim_type) || empty($claim_date) || empty($policy_number) || 
        empty($claimant_name) || empty($claimant_email) || empty($description) || $claim_amount <= 0) {
        echo "<div class='error'>❌ Please fill in all required fields.</div>";
        exit;
    }
    
    // Validate claim type
    $valid_types = ['medical', 'accident', 'property', 'theft'];
    if (!in_array($claim_type, $valid_types)) {
        echo "<div class='error'>❌ Invalid claim type.</div>";
        exit;
    }
    
    // Validate email
    if (!filter_var($claimant_email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='error'>❌ Invalid email address.</div>";
        exit;
    }
    
    // Validate date
    if (!strtotime($claim_date)) {
        echo "<div class='error'>❌ Invalid date format.</div>";
        exit;
    }
    
    // Validate amount
    if ($claim_amount < 100 || $claim_amount > 1000000) {
        echo "<div class='error'>❌ Claim amount must be between $100 and $1,000,000.</div>";
        exit;
    }
    
    // Generate claim ticket
    $claim_ticket = 'CLM-' . date('Y') . '-' . strtoupper(uniqid());
    
    // Generate estimated processing time (3-7 business days)
    $processing_days = rand(3, 7);
    $estimated_date = date('Y-m-d', strtotime("+{$processing_days} business days"));
    
    echo "<div class='success-box'>";
    echo "<h4>✅ Claim Submitted Successfully!</h4>";
    echo "<table class='quote-details'>";
    echo "<tr><td><strong>Claim Ticket:</strong></td><td>{$claim_ticket}</td></tr>";
    echo "<tr><td><strong>Claimant:</strong></td><td>" . htmlspecialchars($claimant_name) . "</td></tr>";
    echo "<tr><td><strong>Email:</strong></td><td>" . htmlspecialchars($claimant_email) . "</td></tr>";
    echo "<tr><td><strong>Policy Number:</strong></td><td>" . htmlspecialchars($policy_number) . "</td></tr>";
    echo "<tr><td><strong>Claim Type:</strong></td><td>" . ucfirst($claim_type) . "</td></tr>";
    echo "<tr><td><strong>Incident Date:</strong></td><td>{$claim_date}</td></tr>";
    echo "<tr class='highlight'><td><strong>Claim Amount:</strong></td><td>\$" . number_format($claim_amount, 2) . "</td></tr>";
    echo "<tr><td><strong>Estimated Processing Time:</strong></td><td>{$processing_days} business days</td></tr>";
    echo "<tr><td><strong>Estimated Decision Date:</strong></td><td>{$estimated_date}</td></tr>";
    echo "</table>";
    echo "<p style='margin-top: 15px; font-size: 0.9em;'>";
    echo "Your claim has been received and is being reviewed. You will receive updates at " . 
         htmlspecialchars($claimant_email) . ".";
    echo "</p>";
    echo "</div>";
} else {
    echo "<div class='error'>❌ Invalid request method.</div>";
}
?>
