<?php
include '../config/clsConnection.php';
include '../objects/clsDepartment.php';

$database = new clsConnection();
$db = $database->connect();

$dept = new Department($db);

$dept->id = $_POST['id'];
$dept->department = $_POST['department'];

$upd = $dept->upd_department();

if($upd)
{
    echo 1;
}else{
    echo 0;
}
?>