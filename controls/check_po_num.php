<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->si_num = $_POST['si_num'];
$po->company = $_POST['company'];
$po->po_num = $_POST['po_num'];
$po->supplier = $_POST['supplier'];

if($_POST['si_num'] != null || $_POST['si_num'] != '')
{
    $check = $po->check_po_num();
    while($row = $check->fetch(PDO::FETCH_ASSOC))
    {
        if($row['check-count'] > 0)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
}
else
{
    echo 0;
}

?>