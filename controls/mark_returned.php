<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
if($_POST['remarks'] != null || $_POST['remarks'] != '')
{
    $remarks = $_POST['remarks'];
}else{
    $remarks = null;
}

//po details
$po->status = 2;
$po->id = $_POST['id'];
//other details
$po->date_returned_req = date('Y-m-d');
$po->remarks = $remarks;
$po->po_id = $_POST['id'];

$mark = $po->mark_as_returned();
$update = $po->upd_date_returned();

if($mark)
{
    if($update)
    {
        echo 1;
    }else{
        echo 0;
    }
}else{
    echo 0;
}
?>