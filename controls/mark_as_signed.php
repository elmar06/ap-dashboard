<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

//po details
$po->status = 6;
$po->id = $_POST['id'];

$mark = $po->mark_as_signed();

if($mark)
{
    echo 1;
}else{
    echo 0;
}
?>