<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    //session_start() creates a session or resumes the current one based
    // on a session identifier passed via a GET or POST request, or passed via a cookie.
    session_start();
    // Set the isOnline in SQL Database to "0" when user is logging out.
    $session_id = $_SESSION['id'];
    $querySql = mysqli_query($con, "UPDATE accounts SET isOnline=0 WHERE id = '$session_id'");
    //session_destroy() destroys all data associated with the current session.
    session_destroy();
    //session_unset() destroys all variables
    session_unset();
    header("Location: index.php");
?>