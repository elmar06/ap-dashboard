<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);
$supplier = new Supplier($db);
$company = new Company($db);

$poID = $_POST['id'];

//check if multicv id's
$po_id = explode(',', $poID);
foreach($po_id as $value)
{
  $po->id = $value;
  $po->po_id = $value;
  $po->date_from_ea = date('Y-m-d');
  $po->status = 8;

  $upd = $po->mark_return_from_ea();
}

if($upd)
{
  echo 1;
}else{
  echo 0;
}
?>