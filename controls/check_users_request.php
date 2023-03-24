<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->id = $_POST['id'];
$check = $po->check_submitted_po_by_user();

while($row = $check->fetch(PDO::FETCH_ASSOC))
{
    if($row['submitted_by'] == $_SESSION['id'])
    {
        echo 1;
    }
    else
    {
        echo 0;
    }
}

?>