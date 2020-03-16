<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);

$po->status = 7;
$po->date_from_ea = date('Y-m-d');
$po->po_id = $_POST['id'];
$po->id = $_POST['id'];

$mark = $po->mark_return_from_ea();

if($mark)
{
   echo 1;
}else{
    echo 0;
}

?>