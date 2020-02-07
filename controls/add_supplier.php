<?php
include '../config/clsConnection.php';
include '../objects/clsSupplier.php';

$database = new clsConnection();
$db = $database->connect();

$sup = new Supplier($db);

$sup->supplier_name = $_POST['supplier'];
$add = $sup->add_supplier();

if($add)
{
    echo 1;
}else{
    echo 0;
}

?>