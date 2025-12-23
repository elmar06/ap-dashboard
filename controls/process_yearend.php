<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$id = $_POST['id'];
if($_POST['action'] == 1){
    $yr_req = implode(',', $_POST['req']);
    // check if the request is came from Vendor portal or RCP System
    $status = '';
    $po->id = $id;
    $get = $po->get_po_by_id();
    while($row = $get->fetch(PDO::FETCH_ASSOC)){
        if($row['submitted_by'] == 101){
            $status = 3; //send directly to BO from Vendor Portal
        }else if($row['rcp_stat'] == 1){
            $status = 1; //send to FO from RCP System
        }else{
            $status = 19; //send to SCM from AP-Dashboard System
        }
    }
    //received request and wait for SCM to forward the request
    $po->id = $id;
    $po->status = $status;
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