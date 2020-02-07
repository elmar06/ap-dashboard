<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$user->username = $_POST['username'];
$user->password = md5($_POST['password']);

$login = $user->login();

if($row = $login->fetch(PDO::FETCH_ASSOC))
{
    $_SESSION['id'] = $row['id'];
    $_SESSION['fullname'] = $row['fullname'];
    $_SESSION['firstname'] = $row['firstname'];
    $_SESSION['log_count'] = $row['logcount'];
    $_SESSION['access'] = $row['access'];
    
    echo 1;
}
else
{
    echo 0;
}

?>