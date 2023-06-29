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
$po_date = date('Y-m-d', strtotime($_POST['po_date']));
//remove the currency format
$amount = str_replace(',','', $_POST['amount']);
$po_amount = str_replace(',','', $_POST['po_amount']);
//UPDATE details
$po->id = $_POST['po_id'];
$po->po_num = $_POST['po_num'];
$po->po_amount = $po_amount;
$po->po_date = $po_date;
$po->si_num = $_POST['si_num'];
$po->company = $_POST['company'];
$po->project = $_POST['project'];
$po->department =$_POST['department'];
$po->supplier = $_POST['supplier'];
$po->bill_date = $bill_date;
$po->terms = $_POST['terms'];
$po->amount = $amount;
$po->due_date = $due_date;
$po->days_due = null;
$po->date_submit = date('Y-m-d');
$po->reports = null;
$po->remark = $_POST['remark'];
$po->memo_no = $_POST['memo_no'];
$po->debit_memo = $_POST['debit_memo'];
$po->memo_amount = $_POST['memo_amount'];
$po->status = 1;

$upd = $po->upd_details();
if($upd)
{
    echo 1;
}else{
    echo 0;
}
?>