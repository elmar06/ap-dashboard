<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';
include '../objects/clsReport.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);
$supplier = new Supplier($db);
$company = new Company($db);
$report = new Reports($db);

$id = $_POST['id'];

$po->status = 16;
  $po->date_cancel = date('Y-m-d');
  $po->po_id = $id;//check_details
  $po->id = $id;//po_details
  $po->po_id = $id;//po_other_details

  $upd = $po->mark_cancel_check();

  if($upd)
  {
    //save details to audit trail
    $report->user_id = $_SESSION['id'];
    $report->po_id = $id;
    $report->action = 1;
    $report->remark = 'PO/JO Mark as Cancelled';
    $report->date_added = date('Y-m-d');
    $mark = $report->save_audit_trail();
    echo ($mark) ? 1 : 0;
  }else{
    echo 0;
  }
?>