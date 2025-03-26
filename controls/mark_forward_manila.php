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
  $po->date_to_manila = date('Y-m-d', strtotime($_POST['date_manila']));
  $po->po_id = $value;//po_other_details
  $upd = $po->forward_to_manila();
}

echo ($upd) ? 1 : 0;
?>