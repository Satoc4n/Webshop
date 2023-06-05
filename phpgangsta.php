<?php
require 'PHPGangsta/GoogleAuthenticator.php';

$ga = new PHPGangsta_GoogleAuthenticator();
$secret =$ga->createSecret();

echo 'Secet is: ' .$secret.'\n\n';

$qrCodeUrl =  $ga->getQRCodeGoogleUrl('Blog', $secret);
echo "Google Charts Url for the RQ Code: " .$qrCodeUrl. "\n\n";

$oneCode = $ga->getCode($secret);
echo "Checking code '$oneCode' and Secret is: '$secret': \n";

$checkResult = $ga->verifyCode($secret, $oneCode)