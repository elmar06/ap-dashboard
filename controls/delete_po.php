<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->id = $_POST['id'];
$remove = $po->remove_po();

if($remove)
{
    echo 1;
}
else
{
    echo 0;
}

?>