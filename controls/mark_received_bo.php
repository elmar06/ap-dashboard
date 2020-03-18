<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->date_received_bo = date('Y-m-d');
$po->received_by_bo = $_SESSION['id'];
$po->po_id = $_POST['id'];
$po->id = $_POST['id'];

$mark = $po->mark_received_bo();

if($mark)
{
    echo 1;
}else{
    echo 0;
}
?>