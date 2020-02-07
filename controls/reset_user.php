<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$user->id = $_POST['id'];
$user->password = md5('123456');

$reset = $user->reset_user_password();
if($reset)
{
    echo 1;
}
else
{
    echo 0;
}
?>