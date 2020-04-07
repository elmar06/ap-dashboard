<?php
include '../config/clsConnection.php';
include '../objects/clsAccess.php';

$database = new clsConnection();
$db = $database->connect();

$access = new Access($db);

$access->user_id = $_POST['id'];
$access->company = $_POST['company'];

$save = $access->add_user_access();
if($save)
{
    echo 1;
}else{
    echo 0;
}

?>