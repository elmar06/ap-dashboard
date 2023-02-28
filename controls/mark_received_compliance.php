<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->date_received_comp = date('Y-m-d');
$po->received_by_comp = $_SESSION['id'];
$po->id = $_POST['id'];
$po->po_id = $_POST['id'];

$upd = $po->mark_received_compliance();
if($upd){
    echo 1;
}else{
    echo 0;
}
?>