<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->id = $_POST['id'];
$po->comp_remark = $_POST['remark'];

$upd = $po->mark_return_compliance();
if($upd){
    echo 1;
}else{
    echo 0;
}
?>