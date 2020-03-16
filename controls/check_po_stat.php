<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->id = $_POST['id'];
$check = $po->get_po_status();

while($row = $check->fetch(PDO::FETCH_ASSOC))
{
    echo $row['status'];
}

?>