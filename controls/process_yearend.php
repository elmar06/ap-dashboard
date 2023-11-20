<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$id = $_POST['id'];
if($_POST['action'] == 1){
    //received request
    $po->id = $id;
    //$po->yearEnd_date_rec = date('Y-m-d');
    $upd = $po->accept_yearEnd();
    echo ($upd) ? 1 : 0;
}elseif($_POST['action'] == 2){
    //returned request
    $po->id = $id;
    $upd = $po->return_yearEnd();
    echo ($upd) ? 2 : 0;
}else{
     //resubmit request
     $po->id = $id;
     $upd = $po->resubmit_yearEnd();
     echo ($upd) ? 3 : 0;
}

?>