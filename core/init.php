<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

require_once "config/connection.php";
require_once "config/function.php";
require_once "google-auth/lib/GoogleAuthenticator.php";
