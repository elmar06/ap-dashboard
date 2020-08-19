<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->po_num = $_POST['po_num'];

$check = $po->check_po_num();
while($row = $check->fetch(PDO::FETCH_ASSOC))
{
    if($row > 0)
    {
        echo 1;
    }
    else
    {
        echo 0;
    }
}
?>