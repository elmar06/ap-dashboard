<?php
include '../config/clsConnection.php';
include '../objects/clsCompany.php';

$database = new clsConnection();
$db = $database->connect();

$company = new Company($db);

$company->id = $_POST['id'];

$upd = $company->activate_company();

if($upd)
{
    echo 1;
}else{
    echo 0;
}
?>