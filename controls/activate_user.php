<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$user->id = $_POST['id'];
$act = $user->activate_user();

if($act)
{
    echo 1;
}
else
{
    echo 0;
}
?>