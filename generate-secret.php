<?php
require_once "core/init.php";
$content = trim(file_get_contents("php://input"));
$obj = json_decode($content, true);

if (isset($obj['username'])) {
    $g = new GoogleAuthenticator();

    $username = $obj['username'];

    $user = generateUserSecret($username);

    if ($user) {
        $response["secret"] = $user["secret"];
        $response["barcode"] = getBase64Barcode($g->getURL($user['username'], 'brentag', $user["secret"]));
        print json_encode($response);
    } else {
        print 'username does not match';
    }
}
