<?php
include '../config/clsConnection.php';
include '../objects/clsAccess.php';

$database = new clsConnection();
$db = $database->connect();

$access = new Access($db);

//check if user is exist
$access->user_id = $_POST['id'];
$check = $access->check_access();
while($row = $check->fetch(PDO:: FETCH_ASSOC))
{
    if($row['count'] > 0){
        //update access details
        $access->user_id = $_POST['id'];
        $access->company = $_POST['company'];
        $upd = $access->upd_user_access();
        if($upd)
        {
            echo 1;
        }else{
            echo 0;
        }
    }else{
        //add access details
        $access->user_id = $_POST['id'];
        $access->company = $_POST['company'];
        $save = $access->add_access();
        if($save)
        {
            echo 1;
        }else{
            echo 0;
        }
    }
}
?>