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
$po->id = $po_id;

//PROCESS REQUEST
if($_POST['action'] == 1)
{
    //check details
    $check_date = date('Y-m-d', strtotime($_POST['checkdate']));
    $check->po_id = $po_id;
    $check->cv_no = $_POST['cv_no'];
    $check->bank = $_POST['bank'];
    $check->check_no = $_POST['check_no'];
    $check->check_date = $check_date;
    $check->amount = $_POST['amount'];
    $check->tax = str_replace(',','',$_POST['tax']);
    $check->cv_amount = str_replace(',','',$_POST['cv_amount']);

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
}
elseif($_POST['action'] == 2)//FORWARD REQUEST FROM MANILA TO CEBU
{
    //check details
    $check_date = date('Y-m-d', strtotime($_POST['checkdate']));
    $check->po_id = $po_id;
    $check->cv_no = $_POST['cv_no'];
    $check->bank = $_POST['bank'];
    $check->check_no = $_POST['check_no'];
    $check->check_date = $check_date;
    $check->amount = $_POST['amount'];
    $check->tax = str_replace(',','',$_POST['tax']);
    $check->cv_amount = str_replace(',','',$_POST['cv_amount']);

    $mark = $po->forward_to_cebu();
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
}
else
{
    //check details
    $check_date = date('Y-m-d', strtotime($_POST['checkdate']));
    $check->po_id = $po_id;
    $check->cv_no = $_POST['cv_no'];
    $check->bank = $_POST['bank'];
    $check->check_no = $_POST['check_no'];
    $check->check_date = $check_date;
    $check->amount = $_POST['amount'];
    $check->tax = str_replace(',','',$_POST['tax']);
    $check->cv_amount = str_replace(',','',$_POST['cv_amount']);

    $mark = $po->mark_bo_process();
    $save = $check->upd_details();

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
}
?>