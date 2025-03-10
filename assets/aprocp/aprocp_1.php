<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!defined('IS_AJAX') || !IS_AJAX) {
    http_response_code(403);
    exit('Direct access not permitted');
}
require_once('../../includes/sqldb.inc.php');
$query_aos = $file_db->prepare("SELECT app_o_title, app_o_content, app_o_button FROM app_o_s LIMIT 1");
$query_aos->execute();
$data_aos = $query_aos->fetch(PDO::FETCH_ASSOC);
$title = htmlspecialchars($data_aos['app_o_title'] ?? '', ENT_QUOTES, 'UTF-8');
$content = htmlspecialchars($data_aos['app_o_content'] ?? '', ENT_QUOTES, 'UTF-8');
$button = htmlspecialchars($data_aos['app_o_button'] ?? '', ENT_QUOTES, 'UTF-8');
header("Content-Type: application/json");
header("X-Content-Type-Options: nosniff");
$html = <<<HTML
<div id="step-container" class="step-container">
    <div id="s-ex" class="step-exit"><span class="material-icons-two-tone">cancel</span></div>
    <div class="step-app-content">
        <div class="step-icon-wrapper">
            <img src="" class="img-fluid app-step-icon" alt="App Icon" />
        </div>
        <div class="step-info-wrapper"></div>
        <div class="step-secondary-info-wrapper"></div>
    </div>
    <div class="step-proccesing-content">
        <div id="s-p-c-title">$title</div>
        <div id="s-p-c-msg">$content</div>
        <div class="s-p-c-btn-wrapper">
            <div id="sp-sb" class="s-p-c-btn animated pulse infinite"><span>$button</span></div>
        </div>
    </div>
    <div class="step-loader">
        <div class="ball-scale-multiple"><div></div><div></div><div></div></div>
    </div>
</div>
HTML;
$response = [
    'html' => $html,
    'title' => $title,
    'content' => $content,
    'button' => $button
];
echo json_encode($response);