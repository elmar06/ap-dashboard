<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';
include '../objects/clsAccess.php';
$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);
$access = new Access($db);

$user->firstname = $_POST['firstname'];
$user->lastname = $_POST['lastname'];
$user->email = $_POST['email'];
$user->access = $_POST['department'];
$user->username = $_POST['username'];
$user->password = md5('123456');
$user->logcount = 0;
$user->status = 1;

//get the user id to be saved in access
$get = $user->get_next_user_id();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
    $user_id = $row['id'];
}
//add user into access list
$access->user_id = $user_id;
$save_access = $access->add_access();
//save user details
$save = $user->add_user();
    if($save && $save_access)
    {
        echo 1;
    }
    else
    {
        echo 0;
    }

?>