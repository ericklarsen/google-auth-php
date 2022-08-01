<?php
require_once "core/init.php";
$content = trim(file_get_contents("php://input"));
$obj = json_decode($content, true);

if (isset($obj['username']) && isset($obj['secret']) && isset($obj['code'])) {
    $g = new GoogleAuthenticator();

    $username = $obj['username'];
    $secret = $obj['secret'];
    $code = $obj['code'];

    $user = checkDoesUsernameMatchWithSecret($username, $secret);

    if ($user) {
        $check = $g->checkCode($secret, $code);
        if ($check) {
            print json_encode('success');
        } else {
            print json_encode('code does not match, try again');
        }
    } else {
        print json_encode('username and secret do not match');
    }
}
