<?php
session_start();

// Define the error messages
$errorMessages = [
    'invalid_request' => 'Invalid request. Please try again.',
    'empty_license' => 'The license key cannot be empty. Please enter a valid license key.',
    'invalid_license_format' => 'The license key format is invalid. Please enter a valid license key.',
    'file_permission' => 'Unable to write to the configuration file. Please check file permissions.',
    'write_failed' => 'Failed to write to the configuration file. Please try again.',
    'license_check' => 'There was an error while checking the license. Please try again later.',
    'db' => 'A database error occurred. Please try again later.',
    'update_failed' => 'An error occurred while updating the settings. Please try again.',
    'session_expired' => 'Your session has expired. Please log in again.',
    'access_denied' => 'Access denied. You do not have permission to view this page.',
    'default' => 'An unexpected error occurred. Please try again later.'
];

// Get the error type from the query parameter
$errorType = isset($_GET['error']) ? $_GET['error'] : 'default';

// Get the corresponding error message
$errorMessage = isset($errorMessages[$errorType]) ? $errorMessages[$errorType] : $errorMessages['default'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - AppRocket</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .error-container {
            text-align: center;
            padding: 30px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background-color: #ffffff;
        }
        .error-title {
            font-size: 24px;
            font-weight: bold;
            color: #dc3545;
        }
        .error-message {
            margin-top: 20px;
            font-size: 18px;
            color: #6c757d;
        }
        .back-button {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-title">Error</div>
        <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
        <div class="back-button">
            <a href="javascript:history.back()" class="btn btn-primary">Go Back</a>
        </div>
    </div>
</body>
</html>
