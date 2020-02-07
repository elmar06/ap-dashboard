<?php
include '../config/clsConnection.php';
include '../objects/clsCompany.php';

$database = new clsConnection();
$db = $database->connect();

$company = new Company($db);

$company->id = $_POST['id'];
$del = $company->remove_company();

if($del)
{
    echo 1;
}else{
    echo 0;
}

?>