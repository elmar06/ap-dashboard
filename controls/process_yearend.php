<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$id = $_POST['id'];
if($_POST['action'] == 1){
    $yr_req = implode(',', $_POST['req']);
    //received request and wait for SCM to forward the request
    $po->id = $id;
    $po->yr_req = $yr_req;
    $upd = $po->accept_yearEnd();
    echo ($upd) ? 1 : 0;
}elseif($_POST['action'] == 2){
    //returned request
    $po->id = $id;
    $po->yearEnd_remark = $_POST['remark'];
    $upd = $po->return_yearEnd();
    echo ($upd) ? 2 : 0;
}elseif($_POST['action'] == 3){
     //resubmit request
     $po->id = $id;
     $upd = $po->resubmit_yearEnd();
     echo ($upd) ? 3 : 0;
}else{
    //forward to AP
    $po->id = $id;
    $upd = $po->submit_yearEnd_toAP();
    echo ($upd) ? 4 : 0;
}

?>