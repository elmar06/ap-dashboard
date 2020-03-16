<?php
include '../config/clsConnection.php';
include '../objects/clsProject.php';

$database = new clsConnection();
$db = $database->connect();

$proj = new Project($db);

$proj->project = $_POST['project'];
$add = $proj->add_project();

if($add)
{
    echo 1;
}else{
    echo 0;
}
?>