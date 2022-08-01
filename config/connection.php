<?php
$host = 'localhost';
$user = 'newuser';
$password = 'password';
$db = 'google2fa';

$link = mysqli_connect($host, $user, $password, $db) or die(mysqli_connect_error());
