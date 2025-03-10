<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!defined('IS_AJAX') || !IS_AJAX) {
    http_response_code(403);
    exit('Direct access not permitted');
}
header("Content-Type: application/json");
header("X-Content-Type-Options: nosniff");
require_once('../../includes/sqldb.inc.php');
$query_ps = $file_db->prepare("SELECT proc_str_1, proc_str_2, proc_str_3, proc_str_4, proc_str_5, proc_str_title_1, proc_str_title_2 FROM proccessing_strings LIMIT 1");
$query_ps->execute();
$data_ps = $query_ps->fetch(PDO::FETCH_ASSOC);
$console_msg_string_1 = htmlspecialchars($data_ps['proc_str_1'] ?? '', ENT_QUOTES, 'UTF-8');
$console_msg_string_2 = htmlspecialchars($data_ps['proc_str_2'] ?? '', ENT_QUOTES, 'UTF-8');
$console_msg_string_3 = htmlspecialchars($data_ps['proc_str_3'] ?? '', ENT_QUOTES, 'UTF-8');
$console_msg_string_4 = htmlspecialchars($data_ps['proc_str_4'] ?? '', ENT_QUOTES, 'UTF-8');
$console_msg_string_5 = htmlspecialchars($data_ps['proc_str_5'] ?? '', ENT_QUOTES, 'UTF-8');
$console_title_string_1 = htmlspecialchars($data_ps['proc_str_title_1'] ?? '', ENT_QUOTES, 'UTF-8');
$console_title_string_2 = htmlspecialchars($data_ps['proc_str_title_2'] ?? '', ENT_QUOTES, 'UTF-8');
$html = <<<HTML
<div class="proccessing-wrapper">
    <div class="proccessing-content">
        <div class="proccessing-loader"><span class="material-icons-two-tone fa-spin">settings</span></div>
        <h3 class="proccessing-title animated pulse infinite"></h3>
        <div class="proccessing-msg"></div>
        <div id="progressBarConsole" class="proccessing-loadbar"><div></div></div>  
    </div>
</div>
HTML;
$response = [
    'html' => $html,
    'console_msg_string_1' => $console_msg_string_1,
    'console_msg_string_2' => $console_msg_string_2,
    'console_msg_string_3' => $console_msg_string_3,
    'console_msg_string_4' => $console_msg_string_4,
    'console_msg_string_5' => $console_msg_string_5,
    'console_title_string_1' => $console_title_string_1,
    'console_title_string_2' => $console_title_string_2
];
echo json_encode($response);