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

$upd = $user->update_user();

if($upd)
{
    echo 1;
}
else
{
    echo 0;
}
?>