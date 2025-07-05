<?php
// bot.php

$botToken = "YOUR_TELEGRAM_BOT_TOKEN";
$apiURL = "https://api.telegram.org/bot$botToken/";
$update = json_decode(file_get_contents("php://input"), true);

if (!isset($update["message"])) exit;

$chatId = $update["message"]["chat"]["id"];
$message = trim($update["message"]["text"]);

$commands = [
    '/telcel' => 'Telcel.php',
    '/brades' => 'BradesCard.php',
    '/test' => 'Test.php',
    '/army' => 'army.php',
    '/btc' => 'btc.php',
    '/apodo' => 'apodo.php',
    '/addgateway' => 'addGateway.php',
    '/antiscript' => 'antiscript.php',
    '/binbanned' => 'binbanned.php',
    '/count' => 'count.php',
];

if (array_key_exists($message, $commands)) {
    $script = __DIR__ . "/scripts/" . $commands[$message];
    ob_start();
    include($script);
    $output = ob_get_clean();
    sendMessage($chatId, $output);
} else {
    sendMessage($chatId, "❌ Unknown command.\nUse one of:\n" . implode("\n", array_keys($commands)));
}

function sendMessage($chatId, $text) {
    global $apiURL;
    $url = $apiURL . "sendMessage?chat_id=$chatId&text=" . urlencode($text);
    file_get_contents($url);
}
?>
