<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';
include '../objects/clsDepartment.php';
include '../objects/clsProject.php';
include '../objects/clsCheckDetails.php';

$database = new clsConnection();
$db = $database->connect();

$supplier = new Supplier($db);
$company = new Company($db);
$po = new PO_Details($db);
$dept = new Department($db);
$project = new Project($db);
$check_details = new CheckDetails($db);

$po->submitted_by = $_SESSION['id'];
$view = $po->get_submitted_po_by_user();
while($row = $view->fetch(PDO::FETCH_ASSOC))
{
    //get the PROJECT name is exist
    $project->id = $row['proj-id'];
    $get1 = $project->get_proj_details();
    while($rowProj = $get1->fetch(PDO::FETCH_ASSOC))
    {
    if($row['proj-id'] == $rowProj['id']){
        $proj_name = $rowProj['project'];
    }else{
        $proj_name = '-';
    }
    }
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
    //format of status
    if($row['status'] == 1){
    $status = '<label style="color: red"><b> Pending</b></label>';
    }else if($row['status'] == 2){
    $status = '<label style="color: orange"><b> Returned</b></label>';
    }elseif($row['status'] == 5){
    $status = '<label style="color: blue"><b> For Signature</b></label>';
    }elseif($row['status'] == 6){
    $status = '<label style="color: blue"><b> Sent to EA</b></label>';
    }elseif($row['status'] == 8){
    $status = '<label style="color: blue"><b> For Verification</b></label>';
    }elseif($row['status'] == 9){
    $status = '<label style="color: red"><b> On Hold</b></label>';
    }else if($row['status'] == 10){
    $status = '<label style="color: green"><b> For Releasing</b></label>';
    }else if($row['status'] == 11){
    $status = '<label style="color: green"><b> Released</b></label>';
    }else{
    $status = '<label style="color: blue"><b> On Process</b></label>';
    }
    //date format
    $bill_date = date('m/d/y', strtotime($row['bill_date']));
    //get the PO check details
    $check_date = '-';
    $check_no = '-';
    $check_details->po_id = $row['po-id'];
    $get = $check_details->get_details_byID();
    while($row1 = $get->fetch(PDO::FETCH_ASSOC))
    {
        $check_date = date('m/d/y', strtotime($row1['check_date']));
        $check_no = $row1['check_no'];
    }
    //get the date sent to EA
    $po->po_id = $row['po-id'];
    $get_date = $po->get_other_details();
    while($row2 = $get_date->fetch(PDO:: FETCH_ASSOC))
    {
    if($row2['date_to_ea'] != null){
        $date_ea = date('m/d/y', strtotime($row2['date_to_ea']));
    }else{
        $date_ea = '-';
    }
    }
    echo '
    <tr>
    <td hidden><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
    <td align="center">'.$proj_name.'</td>
    <td>'.$comp_name.'</td>
    <td>'.$row['po_num'].'</td>
    <td style="max-width: 150px">'.$sup_name.'</td>
    <td align="center">'.$bill_date.'</td>
    <td align="center">'.$check_date.'</td>
    <td align="center">'.$check_no.'</td>
    <td align="center">'.$date_ea.'</td>
    <td><center>'.$status.'</center></td>
    </tr>';
}

?>