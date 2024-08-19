<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';
include '../objects/clsProject.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);
$supplier = new Supplier($db);
$company = new Company($db);
$project = new Project($db);

$poID = $_POST['id'];
//check if multicv id's
$po_id = explode(',', $poID);
foreach($po_id as $value)
{
    //check the status of the PO
    $status = '';
    $po->id = $value;
    $check = $po->get_po_by_id();
    while($row = $check->fetch(PDO:: FETCH_ASSOC))
    {
        $status = $row['status'];
    }
    if($status == 8 || $status == 9 || $status == 10){
        //if status is FOR VERIFICATION (8) 
        $po->status = 10;
        $po->date_for_release = date('Y-m-d', strtotime($_POST['date']));
        $po->treasury_id = $_SESSION['id'];
        $po->po_id = $value;
        $po->id = $value;        
        $upd = $po->mark_for_release();

        if($upd)
        {
            echo 1;
        }else{
            echo 0;
        }
    }else{
        //add the for releasing date in po_other_details
        $po->date_for_release = date('Y-m-d', strtotime($_POST['date']));
        $po->treasury_id = $_SESSION['id'];
        $po->po_id = $value;  
        $upd = $po->add_releasing_details();   
        
        if($upd)
        {
            echo 2;
        }else{
            echo 0;
        }
    }
}


?>