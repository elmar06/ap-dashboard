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

//get all the staled check
$get = $check->get_all_check_details();
while($row = $get->fetch(PDO:: FETCH_ASSOC))
{
     //po_details id
     $id = $row['po_id'];
     $array_id = explode(',', $id);
     foreach($array_id as $value)
     {
        //update the po details into status = 20
        $po->po_id = $value;
        
     }
}
?>