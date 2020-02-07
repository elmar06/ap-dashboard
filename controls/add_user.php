<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';
$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$user->firstname = $_POST['firstname'];
$user->lastname = $_POST['lastname'];
$user->email = $_POST['email'];
$user->access = $_POST['department'];
$user->username = $_POST['username'];
$user->password = md5('123456');
$user->logcount = 0;
$user->status = 1;

$save = $user->add_user();
    if($save)
    {
        echo 1;
    }
    else
    {
        echo 0;
    }

?>