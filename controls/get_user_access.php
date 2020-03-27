<?php
include '../config/clsConnection.php';
include '../objects/clsAccess.php';
include '../objects/clsCompany.php';

$database = new clsConnection();
$db = $database->connect();

$access = new Access($db);
$company = new Company($db);

$access->user_id = $_POST['id'];
$get = $access->get_company();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
    $comp = $row['comp-access'];
    $array_id = explode(',', $comp);
    foreach($array_id as $value)
    {
        //get the list of company
        $id = $value;
        $company->id = $id;
        $view = $company->get_company_detail();
        while($row1 = $view->fetch(PDO::FETCH_ASSOC))
        {
            echo '
            <tr>
                <td>'.$row1['company'].'</td>
                <td><center><button class="btn-sm btn-danger remove" value="'.$row['id'].'"><i class="fas fa-times-circle"></i></button></center></td>
            <tr>
            ';
        }
    }
}

?>