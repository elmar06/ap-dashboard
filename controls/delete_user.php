<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$user->id = $_POST['id'];
$del = $user->remove_user();

if($del)
{
    echo 1;
}
else
{
    echo 0;
}
?>