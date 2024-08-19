<?php
include '../../config/clsConnection.php';
include '../../objects/clsPODetails.php';
include '../../objects/clsCheckDetails.php';

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
//clear the check data in po_other_details table
$po->po_id = $id;
$upd_data = $po->clear_check_data();

if($cancel && $upd_po && $upd_data){
    echo 1;
}else{
    echo 0;
}
?>