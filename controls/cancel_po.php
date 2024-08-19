<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCheckDetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$check = new CheckDetails($db);

$id = $_POST['id'];
//mark the check as cancel
$check->po_id = $id;
$check->date_cancel = date('Y-m-d');
$cancel = $check->cancel_check();
//return the status as FOR CV CREATION
$po->id = $id;
$upd_po = $po->cancel_po();

if($cancel && $upd_po){
    echo 1;
}else{
    echo 0;
}
?>