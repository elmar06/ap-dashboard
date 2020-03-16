<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCheckDetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$check = new CheckDetails($db);

$po_id = $_POST['id'];//po-id
$user_id = $_SESSION['id'];//user id
//po details
$po->status = 4;
$po->id = $po_id;
//other details
$po->date_received_bo = date('Y-m-d');
$po->received_by_bo = $user_id;
$po->po_id = $po_id;
//check details
$check_date = date('Y-m-d', strtotime($_POST['checkdate']));
$check->po_id = $po_id;
$check->cv_no = $_POST['cv_no'];
$check->bank = $_POST['bank'];
$check->check_no = $_POST['check_no'];
$check->check_date = $check_date;

$mark = $po->mark_bo_process();
$save = $check->add_details();

if($mark)
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