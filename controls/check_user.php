<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$user->firstname = $_POST['firstname'];
$user->lastname = $_POST['lastname'];
$user->email = $_POST['email'];

$check = $user->check_user();
while($row = $check->fetch(PDO::FETCH_ASSOC))
{
    if($row > 0)
    {
        echo 1;
    }
    else
    {
        echo 0;
    }
}
?>