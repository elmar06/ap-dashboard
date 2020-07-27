<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

//get the amount per request id
$id = $_POST['id'];
$array_id = explode(',', $id);
$total_array = array();
foreach($array_id as $value)
{
    $req_id = $value;
    $po->id = $req_id;
    $get = $po->get_req_amount();
    while($row = $get->fetch(PDO::FETCH_ASSOC))
    {
       $total_array[] = $row['amount'];
    }
}

//add all the amount
$total = 0;
foreach($total_array as $key=>$amount_value)
{
    $total+= $amount_value;
}
echo number_format($total, 2);
?>