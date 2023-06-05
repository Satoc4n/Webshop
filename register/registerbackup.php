<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

//Currently, registering a user is completed without checking if the said user is valid or not. This
//makes way for the attackers using bots to create tons of accounts and add them to our database, which
//is dangerous. We need to put our signed-up users into hold and add them to database after they completed
//the required email verification.

$messageInvalidUsername = "Username already in use! Please use a different Username.";
$messageInvalidEmail = "Email already in use! Please use a different Email.";

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
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?,?,?)')) {
            //Return
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //Choosing DEFAULT hash is a good choice
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
            echo 'You account has been created!';

            //Email user email if registration is successful
            //$tmpEmail = 'SELECT email FROM accounts WHERE username = ';

            $to = 'EMAILFORSOMEONE';
            $subject = 'THANK FOR REGISTERING TO YILISA PERFUMES!';
            $txt = 'Welcome to the world of perfumes where the best fragnances of our world meets your nose!';
            $headers = 'From: emailAddressWhichWeSendEmailsFrom@something.com';
            mail($to, $subject, $txt, $headers);

        }
        else {
            echo 'There was an error!';
            header('Refresh: 3');
        }
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
