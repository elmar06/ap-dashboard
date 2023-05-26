<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';
include '../objects/clsProject.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);
$supplier = new Supplier($db);
$company = new Company($db);
$project = new Project($db);

$poID = $_POST['id'];

//check if multicv id's
$po_id = explode(',', $poID);
foreach($po_id as $value)
{
  $po->status = 9;
  $po->date_on_hold = date('Y-m-d');
  $po->treasury_id = $_SESSION['id'];
  $po->po_id = $value;
  $po->id = $value;

  $upd = $po->mark_on_hold();
}

if($upd)
{
  echo 1;
}else{
  echo 0;
}
?>