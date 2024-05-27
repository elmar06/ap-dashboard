<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCheckDetails.php';
include '../objects/clsSupplier.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$check = new CheckDetails($db);
$supplier = new Supplier($db);
$user = new Users($db);

$get = $po->get_for_resubmit();
while($row = $get->fetch(PDO:: FETCH_ASSOC))
{
    if($row['count_days'] >= 170){
        //mark as stale check & set the date
        $po->id = $row['id'];
        $po->stale_date = date('Y-m-d');
        $mark = $po->mark_stale_check();
        if($mark){
            //set po_details into for cv creation
            $array_id = explode(',', $row['po_id']);
            foreach($array_id as $value)
            {
                $po->id = $value;
                $sel = $po->mark_stale();
                if($sel){
                    echo 1;
                }
            }
        }else{
            echo -1;
        }
    }else{
        //mark as active 
        $po->id = $row['id'];
        $active = $po->mark_active();
        if($active){
            //set po_details into for verification
            $array_id = explode(',', $row['po_id']);
            foreach($array_id as $value)
            {
                $po->id = $value;
                $upd = $po->set_for_verification();
                if($upd){
                    echo 2;
                }
            }
        }else{
            echo -2;
        }
    }
}

?>