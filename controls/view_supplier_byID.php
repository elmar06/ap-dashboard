<?php
include '../config/clsConnection.php';
include '../objects/clsSupplier.php';

$database = new clsConnection();
$db = $database->connect();

$sup = new Supplier($db);

$sup->id = $_POST['id'];
$get = $sup->get_supplier_details();
while($row = $get->fetch(PDO:: FETCH_ASSOC))
{
    echo '
        <div class="form-group">
            <input type="text" class="form-control" style="display: none" id="upd-id" placeholder="Supplier Name" value="'.$row['id'].'">
            <input type="text" class="form-control" id="upd-name" placeholder="Supplier Name" value="'.$row['supplier_name'].'"><br>
            <input type="text" class="form-control" id="upd-terms" placeholder="Terms" value="'.$row['terms'].'">
        </div>
        <div id="upd-success" class="alert alert-success" role="alert" style="display: none"></div>
        <div id="upd-warning" class="alert alert-danger" role="alert" style="display: none"></div>';
}

?>