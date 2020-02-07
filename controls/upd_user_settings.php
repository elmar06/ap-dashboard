<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$user->id = $_POST['id'];
$user->firstname = $_POST['firstname'];
$user->lastname = $_POST['lastname'];
$user->email = $_POST['email'];
$user->access = $_POST['department'];
$user->username = $_POST['username'];
$user->password = md5($_POST['password']);

$upd = $user->update_user_settings();

if($upd)
{
    echo 1;
}
else
{
    echo 0;
}
?>