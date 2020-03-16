<?php
include '../config/clsConnection.php';
include '../objects/clsProject.php';

$database = new clsConnection();
$db = $database->connect();

$proj = new Project($db);

$proj->id = $_POST['id'];
$proj->project = $_POST['name'];
$add = $proj->upd_project();

if($add)
{
    echo 1;
}else{
    echo 0;
}

?>