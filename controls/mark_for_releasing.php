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

$po->status = 10;
$po->date_for_release = date('Y-m-d', strtotime($_POST['date']));
$po->po_id = $_POST['id'];
$po->id = $_POST['id'];

$upd = $po->mark_for_release();

if($upd)
{
    echo 1;
}else{
    echo 0;
}
?>