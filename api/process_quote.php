<?php
// API Endpoint: Process Quote
// This endpoint handles quote requests and calculates premium rates

header('Content-Type: text/html; charset=UTF-8');

// Validation cache to optimize performance
$validation_cache = [];

// Input validation function (appears secure but has subtle bypass)
function validate_policy_reference($policy_ref) {
    global $validation_cache;
    
    // Looks like it's validating, but the validation is incomplete
    if (empty($policy_ref)) {
        return true; // Optional field
    }
    
    // Check cache first
    $cache_key = md5($policy_ref);
    if (isset($validation_cache[$cache_key])) {
        return $validation_cache[$cache_key];
    }
    
    // Length validation only - appears to be a security check but isn't strict enough
    // The developer thought checking length would be sufficient
    if (strlen($policy_ref) >= 3 && strlen($policy_ref) <= 200) {
        $validation_cache[$cache_key] = true;
        return true;
    }
    
    $validation_cache[$cache_key] = false;
    return false;
}

function calculate_quote($coverage_type, $coverage_amount) {
    $base_rates = [
        'health' => 0.08,
        'auto' => 0.12,
        'home' => 0.06,
        'life' => 0.04,
        'travel' => 0.03
    ];
    
    $rate = isset($base_rates[$coverage_type]) ? $base_rates[$coverage_type] : 0.10;
    $annual_premium = $coverage_amount * $rate;
    $monthly_premium = $annual_premium / 12;
    
    return [
        'annual' => round($annual_premium, 2),
        'monthly' => round($monthly_premium, 2)
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $coverage_type = isset($_POST['coverage_type']) ? trim($_POST['coverage_type']) : '';
    $coverage_amount = isset($_POST['coverage_amount']) ? intval($_POST['coverage_amount']) : 0;
    $policy_reference = isset($_POST['policy_reference']) ? trim($_POST['policy_reference']) : '';
    
    // Basic validation
    if (empty($fullname) || empty($email) || empty($coverage_type) || $coverage_amount <= 0) {
        echo "<div class='error'>❌ Please fill in all required fields.</div>";
        exit;
    }
    
    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='error'>❌ Invalid email address.</div>";
        exit;
    }
    
    // Coverage type validation
    $valid_types = ['health', 'auto', 'home', 'life', 'travel'];
    if (!in_array($coverage_type, $valid_types)) {
        echo "<div class='error'>❌ Invalid coverage type selected.</div>";
        exit;
    }
    
    // Coverage amount validation
    if ($coverage_amount < 10000 || $coverage_amount > 10000000) {
        echo "<div class='error'>❌ Coverage amount must be between $10,000 and $10,000,000.</div>";
        exit;
    }
    
    // Policy reference validation - THIS IS THE VULNERABLE PARAMETER
    if (!validate_policy_reference($policy_reference)) {
        echo "<div class='error'>❌ Invalid policy reference format.</div>";
        exit;
    }
    
    // Calculate quote
    $quote = calculate_quote($coverage_type, $coverage_amount);
    
    // VULNERABILITY: OS Command Injection
    // The policy_reference is passed to a system command without proper sanitization
    // This feature was added to "optimize policy lookup performance"
    
    if (!empty($policy_reference)) {
        // Performance optimization: Check policy reference against historical database
        // Uses system grep for fast searching through policy records
        $policy_file = "/dev/null"; // Fallback - normally would be /var/lib/inception/policies.dat
        
        // The command construction is vulnerable because $policy_reference is not properly escaped
        // with escapeshellarg() - only checked with length which doesn't prevent injection
        $cmd = "grep -l " . $policy_reference . " " . $policy_file . " 2>&1";
        
        // Attempting to execute the command to verify policy exists
        // Output is now displayed for debugging purposes
        $policy_check_result = shell_exec($cmd);
        
        // Example vulnerable payloads:
        // 1. ; whoami #
        // 2. ; id #
        // 3. ; ls -la /tmp #
        // 4. $(whoami)
        // 5. `id`
    }
    
    // Generate quote details
    $quote_id = 'QUOTE-' . strtoupper(uniqid());
    $coverage_name = ucfirst(str_replace('_', ' ', $coverage_type));
    
    echo "<div class='success-box'>";
    echo "<h4>✅ Quote Generated Successfully!</h4>";
    echo "<table class='quote-details'>";
    echo "<tr><td><strong>Quote ID:</strong></td><td>{$quote_id}</td></tr>";
    echo "<tr><td><strong>Name:</strong></td><td>" . htmlspecialchars($fullname) . "</td></tr>";
    echo "<tr><td><strong>Email:</strong></td><td>" . htmlspecialchars($email) . "</td></tr>";
    echo "<tr><td><strong>Coverage Type:</strong></td><td>{$coverage_name}</td></tr>";
    echo "<tr><td><strong>Coverage Amount:</strong></td><td>\$" . number_format($coverage_amount, 2) . "</td></tr>";
    echo "<tr class='highlight'><td><strong>Monthly Premium:</strong></td><td>\$" . number_format($quote['monthly'], 2) . "</td></tr>";
    echo "<tr class='highlight'><td><strong>Annual Premium:</strong></td><td>\$" . number_format($quote['annual'], 2) . "</td></tr>";
    echo "</table>";
    echo "<p style='margin-top: 15px; font-size: 0.9em;'>Quote valid for 30 days. Please contact our sales team to proceed.</p>";
    
    // Debug info - shows command injection output
    if (!empty($policy_reference) && $policy_check_result) {
        echo "<hr style='margin: 15px 0;'>";
        echo "<div style='background: #f5f5f5; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 0.85em; white-space: pre-wrap; word-break: break-all;'>";
        echo "<strong>Policy Verification Output:</strong><br>";
        echo htmlspecialchars($policy_check_result);
        echo "</div>";
    }
    
    echo "</div>";
} else {
    echo "<div class='error'>❌ Invalid request method.</div>";
}
?>
