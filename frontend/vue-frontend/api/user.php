<?php
$rp = json_decode(file_get_contents('php://input'), true);
$user = $rp['params']["username"];
$pass = $rp['params']["password"];


if ($user == 'Sergio' && $pass == '123456') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(
        [
            'userName' => 'Sergio López',
            'userEmail' => 'sergio@gmail.com',
            'userId' => 56,
            'userIsLoggedIn' => true,
        ]
    );
} else {
    http_response_code(403);
    echo "USER NOT FOUND";
}

exit;