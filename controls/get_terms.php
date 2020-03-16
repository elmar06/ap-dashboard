<?php
include '../config/clsConnection.php';
include '../objects/clsSupplier.php';

$database = new clsConnection();
$db = $database->connect();

$sup = new Supplier($db);

$sup->id = $_POST['id'];

$get = $sup->get_term();
if(!$get)
{
    echo json_encode(0);
}
else
{
    $array = '';
    while($row = $get->fetch(PDO::FETCH_ASSOC))
    {
        $array = array($row['terms']);
    }
    echo json_encode($array);
}

?>