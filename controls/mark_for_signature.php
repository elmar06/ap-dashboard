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
    $id = $po_id;
    $array_id = explode(',', $id);
    foreach($array_id as $value)
    {
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
    }

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
elseif($_POST['action'] == 2)//MULTI CV FORWARD REQUEST FROM MANILA TO CEBU
{
    //check details    
    $id = $po_id;
    $array_id = explode(',', $id);
    foreach($array_id as $value)
    {
        $po->id = $value;
        $mark = $po->forward_to_cebu();
    }
    //save check details in db
    if($_POST['checkdate'] != '' || $_POST['checkdate'] != null){
        $check_date = date('Y-m-d', strtotime($_POST['checkdate']));
    }else{
        $check_date = date('Y-m-d');
    }
    $check->po_id = $id;
    $check->cv_no = $_POST['cv_no'];
    $check->bank = $_POST['bank'];
    $check->check_no = $_POST['check_no'];
    $check->check_date = $check_date;
    $check->amount = $_POST['amount'];
    $check->tax = str_replace(',','',$_POST['tax']);
    $check->cv_amount = str_replace(',','',$_POST['cv_amount']);
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
else//UPDATE CHECK DETAILS(FORWARDED REQUEST FROM CEBU TO MANILA)
{
    //po_details id
    $id = $_POST['check_po_id'];
    $array_id = explode(',', $id);
    foreach($array_id as $value)
    {
        $po->id = $value;
        $mark = $po->mark_bo_process();
    }
    $check->id = $_POST['check_id'];
    $check_date = date('Y-m-d', strtotime($_POST['checkdate']));
    $check->cv_no = $_POST['cv_no'];
    $check->bank = $_POST['bank'];
    $check->check_no = $_POST['check_no'];
    $check->check_date = $check_date;
    $check->amount = $_POST['amount'];
    $check->tax = str_replace(',','',$_POST['tax']);
    $check->cv_amount = str_replace(',','',$_POST['cv_amount']);

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