<?php
include '../config/clsConnection.php';
include '../objects/clsDepartment.php';

$database = new clsConnection();
$db = $database->connect();

$dept = new Department($db);

$dept->id = $_POST['id'];
$del = $dept->del_department();

if($del)
{
    echo 1;
}else{
    echo 0;
}

?>