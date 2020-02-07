<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$user->firstname = $_POST['firstname'];
$user->lastname = $_POST['lastname'];
$user->email = $_POST['email'];
$user->username = $_POST['username'];
$user->password = md5($_POST['password']);
$user->logcount = 0;
$user->access = $_POST['department'];
$user->status = 1;

$reg = $user->add_user();

if($reg)
{
    echo 1;
}
else
{
    echo 0;
}

?>