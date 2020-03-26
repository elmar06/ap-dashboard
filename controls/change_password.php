<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$user->id = $_POST['id'];
$user->password = md5($_POST['password']);

$upd = $user->change_password();

if($upd)
{
    echo 1;
}else{
    echo 0;
}
?>