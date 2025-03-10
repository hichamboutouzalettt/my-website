<?php
session_start();
if (!isset($_SESSION['user_admin']) || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    header('Location: ../login.php');
    exit;
}
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header('Location: ../login.php');
    exit;
}
$_SESSION['last_activity'] = time();
require_once 'csrf_token.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCSRFToken($_POST['csrf_token']);
}
function validateInput($inputName, $filter = FILTER_SANITIZE_SPECIAL_CHARS) {
    return filter_input(INPUT_POST, $inputName, $filter);
}
$new_username = validateInput('new_username');
$new_password = validateInput('new_password');
if (!empty($new_username) && !empty($new_password)) {
    if (strlen($new_username) < 5 || strlen($new_password) < 8) {
        header('Location: ../error.php?error=invalid_credentials');
        exit;
    }
    $ad_f = realpath(dirname(__FILE__) . '/../../admin-configuration.php');
    
    if (!is_writable($ad_f)) {
        error_log("Unable to write to admin configuration file: $ad_f");
        header('Location: ../error.php?error=config_write');
        exit;
    }
    $data = "<?php\n";
    $data .= "\$username_admin = " . var_export($new_username, true) . ";\n";
    $data .= "\$password_admin = " . var_export($new_password, true) . ";\n";
    $data .= "?>";
    if (file_put_contents($ad_f, $data, LOCK_EX) === false) {
        error_log("Failed to write admin configuration to file: $ad_f");
        header('Location: ../error.php?error=config_write');
        exit;
    }
    session_unset(); 
    session_destroy();
    header('Location: ../login.php?rmsg=s');
    exit;
} else {
    header('Location: ../c-psw.php');
    exit;
}
?>