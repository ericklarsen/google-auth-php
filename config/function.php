<?php
include_once "google-auth/lib/GoogleAuthenticator.php";

function registerUser($name, $password)
{
    global $link;

    $username = escape($name);
    $pass = escape($password);

    $g = new GoogleAuthenticator();
    $secret = $g->generateSecret();
    $query = "INSERT INTO login (username, password, secret) VALUES('$username', '$pass','$secret')";
    $user_new = mysqli_query($link, $query);

    if ($user_new) {
        $usr = "SELECT * FROM login WHERE username = '$username'";
        $result = mysqli_query($link, $usr);
        $user = mysqli_fetch_assoc($result);
        return $user;
    } else {
        return null;
    }
}

function escape($data)
{
    global $link;
    return mysqli_real_escape_string($link, $data);
}

function checkUsername($name)
{
    global $link;
    $query = "SELECT * FROM login WHERE username = '$name'";
    if ($result = mysqli_query($link, $query)) {
        return mysqli_num_rows($result);
    }
}

function getBase64Barcode($url)
{
    $image = file_get_contents($url);
    if ($image !== false) {
        return 'data:image/jpg;base64,' . base64_encode($image);
    }

}

function generateUserSecret($username)
{
    $g = new GoogleAuthenticator();
    global $link;

    $username = escape($username);
    // $password = escape($password);

    $query = "SELECT * FROM login WHERE username = '$username'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        // if ($data['password'] == $password) {
        if ($data['secret'] == '') {
            $secret = $g->generateSecret();
            $query2 = "UPDATE login SET secret='$secret' WHERE username='$username'";
            mysqli_query($link, $query2);

            $result = mysqli_query($link, $query);
            $data = mysqli_fetch_assoc($result);
        }
        return $data;
        // } else {
        //     return false;
        // }
    } else {
        return false;
    }

}

function checkUserData($name, $pass)
{
    $g = new GoogleAuthenticator();
    global $link;

    $name = escape($name);
    $password = escape($pass);

    $query = "SELECT * FROM login WHERE username = '$name' and password = '$password'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        if ($data['password'] == $password) {
            // if ($data['secret'] == '') {
            //     $secret = $g->generateSecret();
            //     $query2 = "UPDATE login SET secret='$secret' WHERE username='$name'";
            //     mysqli_query($link, $query2);

            //     $result = mysqli_query($link, $query);
            //     $data = mysqli_fetch_assoc($result);
            // }

            return $data;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function checkDoesUsernameMatchWithSecret($name, $sec)
{
    global $link;
    $name = escape($name);
    $secret = escape($sec);

    $query = "SELECT * FROM login WHERE username = '$name' and secret = '$secret'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        return $data;
    } else {
        return false;
    }
}
