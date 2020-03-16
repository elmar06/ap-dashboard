<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po_id = $_POST['id'];//po-id

$user_id = $_SESSION['id'];//user id
//po details
$po->status = 3;
$po->id = $po_id;
$po->reports = $_POST['reports'];
//other details
$po->date_received_fo = date('Y-m-d');
$po->received_by_fo = $user_id;
$po->po_id = $po_id;//po id

$mark = $po->mark_for_processing();

if($mark)
{
    echo 1; 
}else{
    echo 0;
}
?>