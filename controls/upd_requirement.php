<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$req = implode(",", $_POST['req']);
$po->id = $_POST['id'];
$po->yr_req = $req;
$upd = $po->upd_yrEnd_req();
echo ($upd) ? 1 : 0;

?>