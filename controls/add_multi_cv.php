<?php
include '../config/clsConnection.php';
include '../objects/clsCheckDetails.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$check = new CheckDetails($db);
$po = new PO_Details($db);
//format date
$check_date = date('Y-m-d', strtotime($_POST['checkdate']));

$check->po_id = $_POST['id'];
$check->cv_no = $_POST['cv_no'];
$check->bank = $_POST['bank'];
$check->check_no = $_POST['check_no'];
$check->check_date = $check_date;
$check->amount = str_replace(',', '', $_POST['amount']);
$check->tax = $_POST['tax'];
$check->cv_amount = str_replace(',', '', $_POST['amount']);

$save = $check->add_details();

if($save)
{
    //mark request per ID
    $id = $_POST['id'];
    $array_id = explode(',', $id);
    foreach($array_id as $value)
    {
        $req_id = $value;
        $po->id = $req_id;
        $po->status = 5;
        $mark = $po->mark_bo_process();
    }

    if($mark)
    {
        echo 1;
    }
    else
    {
        echo 0;
    }
}
else
{
    echo 0;
}
?>