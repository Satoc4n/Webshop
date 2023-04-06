<?php
require_once(__DIR__ . '/vendor/autoload.php');

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS);
if ($con->connect_error) {
    die("Connection Error: " .$con->connect_errno);
}

$sql = "SELECT 2fa FROM phplogin.accounts";

//Always returns TRUE, but I leave it in just in case
if (!$con->connect_error) {
    echo "SUCCESSFUL";
}
else {
    echo "CANT CONNECT TO DATABASE " . $con->connect_errno;
}

//Implementation of GoogleTwoFA by antonioribeiro
$google2fa = new PragmaRX\Google2FA\Google2FA();
$secret = $google2fa->generateSecretKey();

//$sql = "INSERT INTO accounts (secret) VALUES ('$secret')";
$sql = "UPDATE accounts SET 2fa='$secret' WHERE id=USER_ID";

$con->close();

