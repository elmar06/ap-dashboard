<?php
include '../config/clsConnection.php';
include '../objects/clsCheckDetails.php';

$database = new clsConnection();
$db = $database->connect();

$check = new CheckDetails($db);

$check->po_id = $_POST['id'];
$check->cv_no = $_POST['cv-no'];
$check->bank = $_POST['bank'];
$check->check_no = $_POST['check_no'];
$check->check_date = $_POST['checkdate'];
$check->amount = $_POST['amount'];

$save = $check->add_details();

if($save)
{
    echo 1;
}
else
{
    echo 0;
}



?>