<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

//get the Manila time by timezone
date_default_timezone_set('Asia/Manila');
//covert the date format for db
$bill_date = date('Y-m-d', strtotime($_POST['bill_date']));
$due_date = date('Y-m-d', strtotime($_POST['due_date']));

$po->id = $_POST['id'];
$po->bill_date = $bill_date;
$po->terms = $_POST['terms'];
$po->due_date = $due_date;
$po->days_due = $_POST['days_due'];
$po->bill_no = $_POST['bill_no'];
$po->po_num = $_POST['po_num'];
$po->company = $_POST['company'];
$po->supplier = $_POST['supplier'];

$upd = $po->upd_details();
if($upd)
{
    echo 1;
}else{
    echo 0;
}
?>