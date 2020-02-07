<?php
include '../config/clsConnection.php';
include '../objects/clsDepartment.php';

$database = new clsConnection();
$db = $database->connect();

$dept = new Department($db);

$dept->department = $_POST['department'];
$save = $dept->add_department();

if($save)
{
    echo 1;
}else{
    echo 0;
}

?>