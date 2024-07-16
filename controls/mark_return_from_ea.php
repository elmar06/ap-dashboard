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
  //check if it is already marked by Treasury Team in advance
  $onHold = '';
  $forRelease = '';
  $id = '';
  $po->po_id = $value;
  $check = $po->check_mark_treasury();
  while($row = $check->fetch(PDO:: FETCH_ASSOC))
  {
    $onHold = $row['date_on_hold'];
    $forRelease = $row['date_for_release'];
    $id = $row['treasury_id'];
  }
  //check & counter
  if($forRelease == null && $onHold == null && $id == null){
    //go to the normal process
    $po->id = $value;
    $po->po_id = $value;
    $po->date_from_ea = date('Y-m-d');
    $po->status = 8;
    $upd = $po->mark_return_from_ea();

    if($upd)
    {
      echo 1;
    }else{
      echo 0;
    }
  }else{
    //auto assign of status (ON HOLD OR FOR RELEASING)
    if($onHold != null && $id != null){
      $status = 9;
    }elseif($forRelease != null && $id != null){
      $status = 10;
    }else{
      $status = 8;
    }
    $po->id = $value;
    $po->po_id = $value;
    $po->date_from_ea = date('Y-m-d');
    $po->status = $status;
    $upd = $po->mark_return_from_ea();

    if($upd)
    {
      echo 2;
    }else{
      echo 0;
    }
  }
}
?>