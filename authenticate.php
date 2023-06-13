<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ( !isset($_POST['username'], $_POST['password']) ) {
    exit('Please fill both the username and password fields!');
}
// Prepare our SQL to prevent SQL Injection
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    // Bind parameters (s = string, i = int etc)
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result, so we can check if the account exists in the database.
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.

        //If I need to delete hash encryption
        //if(password_verify($_POST['password], $password)) {
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            // Set session name to username
            $_SESSION['name'] = $_POST['username'];
            // Set session id to user id
            $_SESSION['id'] = $id;
            // Save user login time for counting how many users are online and display since how many minutes and seconds the user is online for
            $_SESSION['login_time'] = time();
            $diffTime = time() - $_SESSION['login_time'];
            $minutesLoggedIn = floor($diffTime / 60);
            $secondsLoggedIn = $diffTime % 60;
            $displaySessionTime = "Logged in for {$minutesLoggedIn} minutes and {$secondsLoggedIn} seconds";
            // Change isOnline value in Database to true when the user logs in
            $query = mysqli_query($con,"UPDATE accounts SET isOnline = '1' WHERE id = {$_SESSION['id']};");

            // Display welcome message
            echo 'Welcome ' . $_SESSION['name'] . '!';
            header("Location: index.php");
        } else {
            // Incorrect password
            echo '<script type="text/javascript">
                    alert("Incorrect username and/or password. Please check your credentials!")
                </script>';
            //Doesn't redirect or doesn't display alert message
            header("Location:login.php");
        }
    } else {
        // Incorrect username
        echo '<script type="text/javascript">
                    alert("Incorrect username and/or password. Please check your credentials!")
                </script>';
    }

    $stmt->close();
}
?>