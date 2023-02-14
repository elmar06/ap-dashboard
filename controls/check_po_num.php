<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->si_num = $_POST['si_num'];

$check = $po->check_po_num();
while($row = $check->fetch(PDO::FETCH_ASSOC))
{
    extract($row);
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