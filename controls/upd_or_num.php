<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);

$po->or_num = $_POST['or_num'];
$po->id = $_POST['id'];

$upd = $po->upd_or_num();
if($upd){
    echo 1;
}else{
    echo 0;
}
?>