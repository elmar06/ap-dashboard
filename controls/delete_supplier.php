<?php
include '../config/clsConnection.php';
include '../objects/clsSupplier.php';

$database = new clsConnection();
$db = $database->connect();

$sup = new Supplier($db);

$sup->id = $_POST['id'];
$del = $sup->del_supplier();

if($del)
{
    echo 1;
}else{
    echo 0;
}

?>