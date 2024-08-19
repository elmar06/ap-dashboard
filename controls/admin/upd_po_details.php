<?php
include '../../config/clsConnection.php';
include '../../objects/clsPODetails.php';
include '../../objects/clsCheckDetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$check = new CheckDetails($db);
//get the Manila time by timezone
date_default_timezone_set('Asia/Manila');
//covert the date format for db
$bill_date = date('Y-m-d', strtotime($_POST['bill_date']));
$due_date = date('Y-m-d', strtotime($_POST['due_date']));
$po_date = date('Y-m-d', strtotime($_POST['po_date']));
$check_date = date('Y-m-d', strtotime($_POST['check_date']));
$counter_date = date('Y-m-d', strtotime($_POST['counter_date']));
//check date release if null
if($_POST['date_release'] == ''){
    $date_release = null;
}
//remove the currency format
$si_amount = str_replace(',','', $_POST['si_amount']);
$po_amount = str_replace(',','', $_POST['po_amount']);
//check memo amount if null
$memo_amount = 0;
if($_POST['memo_amount'] != 0 || $_POST['memo_amount'] != null){
    $memo_amount = str_replace(',', '', $_POST['memo_amount']);
}
//check remark if null
if($_POST['remarks'] == ''){
    $remark = 0;
}
//check remark if null
$department = $_POST['department'];
if($department == 'null' || $department == null){
    $department = 0;
}
//UPDATE details
$po->id = $_POST['id'];
$po->po_num = $_POST['po_num'];
$po->ir_rr_no = $_POST['ir_num'];
$po->po_amount = $po_amount;
$po->po_date = $po_date;
$po->si_num = $_POST['si_num'];
$po->amount = $si_amount;
$po->company = $_POST['company'];
$po->project = $_POST['project'];
$po->department = $department;
$po->supplier = $_POST['supplier'];
$po->bill_date = $bill_date;
$po->counter_date = $counter_date;
$po->due_date = $due_date;
$po->terms = $_POST['terms'];
$po->remark = $remark;
$po->scm_remark = $_POST['scm_remark'];
$po->memo_no = $_POST['memo_no'];
$po->debit_memo = $_POST['debit_memo'];
$po->memo_amount = $memo_amount;
$po->receipt = $_POST['receipt_num'];
$po->or_num = $_POST['or_num'];
$po->status = $_POST['status'];
$upd = $po->upd_details_admin();
//po other details table
$po->po_id = $_POST['id'];
$po->date_release = $date_release;
$po->released_by = $_POST['released_by'];
$upd_data = $po->upd_other_details_admin();
//check details 
$check->id = $_POST['check_id'];
$check->cv_no = $_POST['cv_no'];
$check->bank = $_POST['bank'];
$check->check_no = $_POST['check_no'];
$check->check_date = $check_date;
$upd_check = $check->upd_details_admin();

if($upd && $upd_data && $upd_check)
{
    echo 1;
}else{
    echo 0;
}
?>