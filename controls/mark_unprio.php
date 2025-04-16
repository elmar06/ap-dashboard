<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';
include '../objects/clsReport.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);
$supplier = new Supplier($db);
$company = new Company($db);
$report = new Reports($db);

$id = $_POST['id'];

$po->id = $_POST['id'];
$set = $po->mark_unprio();

echo ($set) ? 1 : 0;

?>