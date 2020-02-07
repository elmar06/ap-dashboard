<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);
$logout = $user->logout();

if($logout)
{
    header('Location: ../index.php');
}

?>