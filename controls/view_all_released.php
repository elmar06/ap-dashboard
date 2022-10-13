<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);
$supplier = new Supplier($db);
$company = new Company($db);

$po->submitted_by = $_SESSION['id'];
$view = $po->get_released_fo();
while($row = $view->fetch(PDO::FETCH_ASSOC))
{
    //get the COMPANY name if exist
    $company->id = $row['comp-id'];
    $get2 = $company->get_company_detail();
    while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
    {
        if($row['comp-id'] == $rowComp['id']){
        $comp_name = $rowComp['company'];
        }else{
        $comp_name = '-';
        }
    }
    //get the SUPPLIER name if exist
    $supplier->id = $row['supp-id'];
    $get3 = $supplier->get_supplier_details();
    while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
    {
        if($row['supp-id'] == $rowSupp['id']){
        $sup_name = $rowSupp['supplier_name'];
        }else{
        $sup_name = '-';
        }
    }  
    //date format
    $release = date('m/d/Y', strtotime($row['date_release']));
    $amount = number_format($row['cv_amount'], 2);
    //check if OR No is null/empty
    if($row['or_num'] == '' || $row['or_num'] == null){
        $or_num = '<button class="btn btn-info btn-sm btnAdd" value="'.$row['po-id'].'"><i class="fas fa-plus-circle"></i> Add OR</button>';
    }else{
        $or_num = $row['or_num'];
    }
    echo '
    <tr>
        <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
        <td>'.$or_num.'</td>
        <td>'.$row['check_no'].'</td>
        <td>'.$comp_name.'</td>
        <td>'.$row['po_num'].'</td>
        <td style="width: 150px">'.$sup_name.'</td>
        <td>'.$amount.'</td>
        <td><center>'.$release.'</center></td>
    </tr>';
}
?>