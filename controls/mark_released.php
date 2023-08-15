<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);

$poID = $_POST['id'];
//check if multicv id's
$po_id = explode(',', $poID);
foreach($po_id as $value)
{
  $po->id = $value;//po_details
  $po->po_id = $value;//po_other_details
  $po->date_release = date('Y-m-d', strtotime($_POST['release_date']));
  $po->or_num = $_POST['or_num'];
  $po->receipt = $_POST['receipt'];
  $po->released_by = $_SESSION['id'];

  $upd = $po->mark_released();
}

if($upd)
{
  echo 1;
}else{
  echo 0;
}
?>