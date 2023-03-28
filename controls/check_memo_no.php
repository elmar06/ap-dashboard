<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->memo_no = $_POST['memo_no'];
$po->company = $_POST['company'];
$po->po_num = $_POST['po_num'];
$po->supplier = $_POST['supplier'];

if($_POST['memo_no'] != null || $_POST['memo_no'] != '')
{
    $check = $po->check_memo_no();
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