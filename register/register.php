<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '..\vendor\phpmailer\phpmailer\src\Exception.php';
require '..\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require '..\vendor\phpmailer\phpmailer\src\SMTP.php';

// (true) enables exceptions
$mail = new PHPMailer(true);

// Test mail for test purposes

// Currently sends 2 emails MUST FIX -- FIXED, was calling $mail->send() twice
try {
    // Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "PHPMailer::ENCRYPTION_SMTPS";
    $mail->Port = 2525;
    $mail->mailer = "smtp";
    $mail->Username = '73bc2a1c40a76e';
    $mail->Password = 'ed73412715647f';

    // Recipient settings
    $mail->SetFrom('test_email_ignore@gmail.com', 'Ignore This Email');
    $mail->addAddress('falseemailshouldntreceivedit@gmail.com', 'NO');
    //$mail->addReplyTo('ADD-REPLY-TO-EMAIL', 'ADD-REPLY-TO-NAME');

    // Content settings
    $mail->IsHTML(true);
    // Title of the email (Subject)
    $mail->Subject = "Ignore";
    // Body of the mail
    $mail->Body = 'Test email for testing purposes, if you got this email then something went wrong. Please email this address to help us improve our site.';

    $mail->send();
}
catch (Exception $e) {
    echo "ERROR: {$mail->ErrorInfo}";
}

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

//Currently, registering a user is completed without checking if the said user is valid or not. This
//makes way for the attackers using bots to create tons of accounts and add them to our database, which
//is dangerous. We need to put our signed-up users into hold and add them to database after they completed
//the required email verification.
// Must be fixed but how?

$messageInvalidUsername = "Username already in use! Please use a different Username.";
$messageInvalidEmail = "Email already in use! Please use a different Email.";

// Connect to database return error if not possible. In our case if the apache server is not running
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']); //Store the username variable as parameter
    $stmt->execute(); //Execute the prepared statements
    $stmt->store_result(); //Store the result in an internal buffer for future reference

    if ($stmt->num_rows() > 0) { //If there is a match in the base, tell it
        //Pop-Up would be much better, can't figure it out how to do it tho
        echo "<script type='text/javascript'>alert('$messageInvalidUsername');</script>";
        //echo 'Username exists please use a different Username';
        header('Location: /authenticate.php/register/registerpage.html');
        $stmt->close();
    }
    else {
        // Like I said above, putting the created accounts into the database this way comes with problems such as being open to bot attacks
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?,?,?)')) {
            //Return
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //Choosing DEFAULT hash is a good choice
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();

            //$userEmail =  'email';
            //Email user email if registration is successful

            try {
                // Recipient settings
                $mail->SetFrom('yilisaperfumes_noreply@mailtrap.io', 'Yilisa Colognes No Reply');
                $mail->addAddress('SomeEmail@mailtrap.io', 'Welcome to YILISA');

                // Content settings
                $mail->IsHTML(true);
                // Title of the email (Subject)
                $mail->Subject = "Welcome to the world of cologne!";
                // Body of the mail
                $mail->Body = 'Hello World!';

                $mail->send();
            }
            catch (Exception $e) {
                echo "ERROR: {$mail->ErrorInfo}";
            }
            }

            /*
            $to = 'sandbox.smtp.mailtrap.io';
            $subject = 'THANK FOR REGISTERING TO YILISA PERFUMES!';
            $txt = 'Welcome to the world of perfumes where the best fragnances of our world meets your nose!';
            $headers = 'From: sandbox.smtp.mailtrap.io';
            mail($to, $subject, $txt, $headers);


        }*/
        else {
            echo 'There was an error!';
            header('Refresh: 3');
        }
        echo 'You account has been created! Please check your email for confirmation!';
    }
    $stmt->close(); //Close the prepared statements
    header('Location: ../index.php');
}
else if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE email = ?')) {
    $stmt->bind_param('s', $_POST['email']); //Store the email variable as parameter
    $stmt->execute(); //Execute the prepared statements
    $stmt->store_result(); //Store the result in an internal buffer for future reference

    if ($stmt->num_rows() > 0) { //If there is a match in the base, tell it
        //Pop-Up would be much better
        echo "<script type='text/javascript'>alert('$messageInvalidEmail');</script>";
        //echo 'Email exists please use a different Email';
        $stmt->close();
    }
    else {
        // Email the user if the registration is possible
        $emailstmt = "SELECT email FROM accounts WHERE username = $_POST";
        $con->query("SELECT email FROM accounts WHERE username = $_POST");

        $mail->SetFrom('sandbox.smtp.mailtrap.io', 'SET-SENDER_NAME');
        $mail->addAddress('sandbox.smtp.mailtrap.io', 'ADD-RECIPIENT-NAME');
        $mail->addReplyTo('ADD-REPLY-TO-EMAIL', 'ADD-REPLY-TO-NAME');

        $mail->IsHTML(true);
        $mail->Subject = "Send email from localhost using PHP";
        $mail->Body = 'Hello World!';

        if ($mail->send()) {
            echo "Email is sent";
        }
        else {
            echo "Error";
        }


        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?,?,?)')) {
            $password  = password_hash($_POST['password'], PASSWORD_DEFAULT); //Choosing DEFAULT hash is a good choice
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
            echo 'You account has been created!';

        }
        else {
            echo 'There was an error!';
            header('Refresh:3');
        }
    }
    $stmt->close(); //Close the prepared statements

}
else {
    echo 'There was an error!';
}
header('Location: ../index.php');
$con->close();
