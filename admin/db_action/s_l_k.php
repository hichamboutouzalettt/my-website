<?php
session_start();
require_once 'csrf_token.php';
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
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../error.php?error=invalid_request');
    exit;
}
verifyCSRFToken($_POST['csrf_token']);
$license_key = filter_input(INPUT_POST, 'l_key', FILTER_SANITIZE_SPECIAL_CHARS);
if (empty($license_key)) {
    header('Location: ../error.php?error=empty_license');
    exit;
}
if (!preg_match('/^[a-zA-Z0-9-]{10,40}$/', $license_key)) {
    header('Location: ../error.php?error=invalid_license_format');
    exit;
}
$config_file = realpath(dirname(__FILE__) . '/m_s_k.php');
if ($config_file === false || !is_writable($config_file)) {
    error_log("Unable to write to license key file: $config_file");
    header('Location: ../error.php?error=file_permission');
    exit;
}
$data = "<?php\n\$lI = " . var_export($license_key, true) . ";\n?>";
$temp_file = tempnam(sys_get_temp_dir(), 'lic');
if (file_put_contents($temp_file, $data, LOCK_EX) === false) {
    error_log("Failed to write license key to temporary file: $temp_file");
    header('Location: ../error.php?error=write_failed');
    exit;
}
if (!rename($temp_file, $config_file)) {
    error_log("Failed to replace the license key file with the temporary file: $temp_file");
    header('Location: ../error.php?error=write_failed');
    exit;
}
header('Location: ../index.php?rmsg=s');
exit;
?>
