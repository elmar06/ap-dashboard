<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->id = $_POST['id'];//po_details
$upd = $po->mark_for_reprocess();

echo ($upd) ? 1 : 0;
?>