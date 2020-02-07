<?php
include '../config/clsConnection.php';
include '../objects/clsSupplier.php';

$database = new clsConnection();
$db = $database->connect();

$sup = new Supplier($db);

$sup->id = $_POST['id'];
$sup->supplier_name = $_POST['name'];
$add = $sup->upd_supplier();

if($add)
{
    echo 1;
}else{
    echo 0;
}

?>