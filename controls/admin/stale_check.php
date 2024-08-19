<?php
session_start();
include '../../config/clsConnection.php';
include '../../objects/clsPODetails.php';
include '../../objects/clsCheckDetails.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$check = new CheckDetails($db);

$poID = $_POST['id'];
//check if multicv id's
$po_id = explode(',', $poID);
foreach($po_id as $value)
{
    //update the check status and set into stale
    $check->po_id = $value; 
    $check->stale_date = date('Y-m-d');
    $upd_check = $check->mark_as_stale_check();
    //change the status into FOR CV CREATION (status = 20)
    $po->id = $value;
    $upd_PODetails = $po->mark_stale();
    //clear-up some data in po_other_details
    $po->po_id = $value;
    $upd = $po->clear_details_stale();
}

if($upd){
  echo 1;
}else{
  echo 0;
}
?>