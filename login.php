<?php
require_once "core/init.php";
$content = trim(file_get_contents("php://input"));
$obj = json_decode($content, true);

if (isset($obj['username']) && isset($obj['password'])) {
    $g = new GoogleAuthenticator();

    $nama = $obj['username'];
    $pass = $obj['password'];

    $user = checkUserData($nama, $pass);

    if ($user != false) {
        $response["username"] = $user["username"];
        $response["secret"] = $user["secret"];
        if ($user['secret'] != '') {
            $response["barcode"] = getBase64Barcode($g->getURL($user['username'], 'brentag', $user["secret"]));
        }
        echo json_encode($response);
    } else {
        $response["error"] = true;
        $response["error_msg"] = "wrong username/password.";
        echo json_encode('wrong username/password.');
    }

} else {
    $response["error"] = true;
    $response["error_msg"] = "username or password cannot be empty.";
    echo json_encode('username or password cannot be empty.');
}
