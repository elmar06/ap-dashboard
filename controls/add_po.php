<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

//get the new id
$id = '';
$get = $po->get_po_id();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
    $id = $row['po-id'];
    if($id == null || $id == '0'){
        $id = 1;
    }
}

//get the Manila time by timezone
date_default_timezone_set('Asia/Manila');
//covert the date format for db
$bill_date = date('Y-m-d', strtotime($_POST['bill_date']));
$due_date = date('Y-m-d', strtotime($_POST['due_date']));

//save details to po_details table
$po->bill_no = $_POST['bill_no'];
$po->po_num = $_POST['po_num'];
$po->company = $_POST['company'];
$po->supplier = $_POST['supplier'];
$po->project = $_POST['project'];
$po->department = $_POST['department'];
$po->bill_date = $bill_date;
$po->terms = $_POST['terms'];
$po->due_date = $due_date;
$po->days_due = null;
$po->amount = $_POST['amount'];
$po->date_submit = date('Y-m-d');
$po->reports = $_POST['reports'];
$po->si_num = $_POST['si_num'];
$po->submitted_by = $_POST['submitted_by'];

$save = $po->add_po();

//save other details
$po->po_id = $id;
$details = $po->save_other_details();

if($details)
{
    if($save)
    {
        echo 1;
    }else{
        echo 0;
    }  
}else{
    echo 0;
}
?>