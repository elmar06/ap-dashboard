<?php
include '../config/clsConnection.php';
include '../objects/clsSupplier.php';

$database = new clsConnection();
$db = $database->connect();

$sup = new Supplier($db);

$sup->id = $_POST['id'];
$act = $sup->activate_supplier();

if($act)
{
    echo 1;
}else{
    echo 0;
}

?>