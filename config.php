<?php
// Configuration file for Inception Inc.

define('APP_NAME', 'Inception Inc.');
define('APP_VERSION', '1.0.0');
define('APP_ENV', 'development'); // Set to 'production' to disable error display

// Database configuration (not used, but part of normal setup)
define('DB_HOST', 'localhost');
define('DB_USER', 'inception_user');
define('DB_PASS', 'inception_pass');
define('DB_NAME', 'inception_db');

// Security settings
define('ENABLE_DEBUG', true);
define('MAX_UPLOAD_SIZE', 5242880); // 5MB

// Feature flags
define('POLICY_VALIDATION_ENABLED', true);
define('QUOTE_CACHING_ENABLED', false);

// Company info
define('COMPANY_EMAIL', 'info@inceptioninc.local');
define('COMPANY_PHONE', '+1 (800) 555-0123');
define('COMPANY_ADDRESS', '123 Insurance Boulevard, San Francisco, CA 94102');

// Error handling
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
}

// Custom error handler
function handleError($errno, $errstr, $errfile, $errline) {
    if (APP_ENV === 'development') {
        echo "Error [$errno]: $errstr in $errfile on line $errline";
    }
    return true;
}

set_error_handler("handleError");
?>
