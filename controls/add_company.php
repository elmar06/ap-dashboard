<?php
include '../config/clsConnection.php';
include '../objects/clsCompany.php';

$database = new clsConnection();
$db = $database->connect();

$company = new Company($db);

$company->company = $_POST['company'];
$save = $company->add_company();

if($save)
{
    echo 1;
}else{
    echo 0;
}

?>