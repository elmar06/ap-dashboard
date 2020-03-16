<?php
include '../config/clsConnection.php';
include '../objects/clsProject.php';

$database = new clsConnection();
$db = $database->connect();

$proj = new Project($db);

$proj->id = $_POST['id'];
$del = $proj->remove_project();

if($del)
{
    echo 1;
}else{
    echo 0;
}

?>