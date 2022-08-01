<?php
require_once "core/init.php";
$content = trim(file_get_contents("php://input"));
$obj = json_decode($content, true);

if (isset($obj['username']) && isset($obj['password'])) {
    $g = new GoogleAuthenticator();

    $username = $obj['username'];
    $password = $obj['password'];

    if (checkUsername($username) == 0) {
        $user = registerUser($username, $password);
        if ($user) {
            $response["username"] = $user["username"];
            $response["secret"] = $user["secret"];
            $response["barcode"] = getBase64Barcode($g->getURL($user['username'], 'brentag', $user["secret"]));
            echo json_encode($response);

        } else {
            echo json_encode('failed');
        }
    } else {
        // user telah ada
        $response["error"] = true;
        $response["error_msg"] = "username already exists.";
        echo json_encode('username already exists');
    }
}
