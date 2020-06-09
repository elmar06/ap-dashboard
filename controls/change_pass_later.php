<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$user->id = $_POST['id'];

$upd = $user->change_pass_later();

if($upd)
{
    echo 1;
}else{
    echo 0;
}
?>