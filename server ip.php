<?php
header('Content-Type: application/json');

$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

// Check for proxy headers
$proxy_headers = [
    'HTTP_X_FORWARDED_FOR',
    'HTTP_X_REAL_IP',
    'HTTP_CLIENT_IP',
    'HTTP_X_FORWARDED',
    'HTTP_FORWARDED_FOR',
    'HTTP_FORWARDED'
];

$real_ip = $ip;
foreach ($proxy_headers as $header) {
    if (isset($_SERVER[$header])) {
        $ips = explode(',', $_SERVER[$header]);
        $real_ip = trim($ips[0]);
        break;
    }
}

echo json_encode([
    'ip' => $real_ip,
    'remote_addr' => $ip,
    'headers' => [
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'accept_language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '',
        'referer' => $_SERVER['HTTP_REFERER'] ?? '',
    ]
]);
