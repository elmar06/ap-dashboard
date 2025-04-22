<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsUser.php';
include '../objects/clsAccess.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);
$access = new Access($db);

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
    $_SESSION['dept'] = $row['dept'];

    $access->user_id = $row['id'];
    $get = $access->get_company();
    while ($row1 = $get->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['company'] = $row1['comp-access'];
    }
    
    echo 1;
}
else
{
    echo 0;
}

?>