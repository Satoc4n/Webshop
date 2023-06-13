<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $currentTimestamp = time();

    $dbConnection = mysqli_connect('localhost', 'root', '', 'phplogin');
    $query = "UPDATE users SET last_activity = '$currentTimestamp' WHERE user_id = '$userId'";
    mysqli_query($dbConnection, $query);
}

$fiveMinutesAgo = $currentTimestamp - 300;
$query2 = "SELECT COUNT(*) AS online_users FROM users WHERE last_activity > '$fiveMinutesAgo'";
$result = mysqli_query($dbConnection, $query2);
$row = mysqli_fetch_assoc($result);
$onlineUsersCount = $row['online_users'];

echo $onlineUsersCount;

?>