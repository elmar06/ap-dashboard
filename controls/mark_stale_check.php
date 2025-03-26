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

$array_id = explode(',', $id);
foreach($array_id as $value)
{
    $po->stale_date = date('Y-m-d');
    $po->po_id = $id;//check_details
    $po->id = $value;//po_details

    $upd = $po->mark_stale_check();
    if($upd){
        //save activity in audit trail
        $report->user_id = $_SESSION['id'];
        $report->po_id = $value;
        $report->action = 2;
        $report->remark = 'PO/JO has been marked as stale check.';
        $report->date_added = date('Y-m-d');
        $save = $report->save_audit_trail();
        echo ($save) ? 1 : 0;
    }else{
        echo 0;
    }
}
?>