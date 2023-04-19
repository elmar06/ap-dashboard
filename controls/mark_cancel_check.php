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

$id = $_POST['id'];

$array_id = explode(',', $id);
foreach($array_id as $value)
{
  $po->status = 16;
  $po->po_id = $id;//check_details
  $po->id = $value;//po_details

  $upd = $po->mark_cancel_check();

  if($upd)
  {
    echo 1;
  }else{
    echo 0;
  }
}
?>