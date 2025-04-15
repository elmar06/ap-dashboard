<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCheckDetails.php';
include '../objects/clsReport.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$check = new CheckDetails($db);
$report = new Reports($db);

$po_id = $_POST['id'];//po-id
$user_id = $_SESSION['id'];//user id
//po details
$po->id = $po_id;
$po->prio_stat = $_POST['prio_stat'];

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
        //check if satggared payment
        if($_POST['staggared'] == 1){
            $po->status = 4;
            //save audit trail 
            $report->po_id = $po_id;
            $report->user_id = $_SESSION['id'];
            $report->action = 3;
            $report->remark = 'PO/JO Staggared Payment processing as of '.date('Y-m-d');
            $report->date_added = date('Y-m-d');
            $save = $report->save_audit_trail();
            echo ($save) ? 1 : 0;
            //update the staggared & prio stat
            $po->staggared = $_POST['staggared'];
            $po->prio_stat = $_POST['prio_stat'];
            $po->id = $po_id;
            $upd = $po->mark_staggared();
            echo ($upd) ? 1 : 0;
        }else{
            $po->status = 5;
             //update the staggared stat
             $po->staggared = $_POST['staggared'];
             $po->prio_stat = $_POST['prio_stat'];
             $po->id = $po_id;
             $upd = $po->mark_staggared();
             echo ($upd) ? 1 : 0;
        }
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
        $po->po_id = $value;
        $po->date_forwarded_cebu = date('Y-m-d');
        $mark_details = $po->mark_forward_to_cebu();
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

    if($mark && $mark_details)
    {
        if($save)
        {
            echo 2; 
        }else{
            echo 0; 
        }
        
    }else{
        echo 0;
    }
}
elseif($_POST['action'] == 3)//UPDATE CHECK DETAILS(FORWARDED REQUEST FROM CEBU TO MANILA)
{
    //po_details id
    $id = $_POST['check_po_id'];
    $array_id = explode(',', $id);
    foreach($array_id as $value)
    {
        $po->id = $value;
        $mark = $po->forward_to_cebu();
        $po->po_id = $value;
        $po->date_forwarded_cebu = date('Y-m-d');
        $mark_details = $po->mark_forward_to_cebu();
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

    if($mark && $mark_details)
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
else//RECEIVED REQUEST ONLY FROM MANILA
{
    $po->id = $_POST['id'];
    $po->recieved_from_manila = date('Y-m-d');
    $mark = $po->recieved_from_manila();
    $stamp = $po->recieved_from_manila_date();

    if($mark && $stamp){
        echo 1;
    }else{
        echo 0;
    }
}
?>