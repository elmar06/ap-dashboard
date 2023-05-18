<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);
$dept = '';
if($_POST['department'] == 5){
    //PMC
    $access = 4;
    $dept = 1;
}else{
    //SCM
    $access = 4;
    $dept = 2;
}
$user->firstname = $_POST['firstname'];
$user->lastname = $_POST['lastname'];
$user->email = $_POST['email'];
$user->username = $_POST['username'];
$user->password = md5($_POST['password']);
$user->logcount = 0;
$user->dept = $dept;
$user->access = $access;
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