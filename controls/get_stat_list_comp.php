<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';
include '../objects/clsProject.php';

$database = new clsConnection();
$db = $database->connect();

$supplier = new Supplier($db);
$company = new Company($db);
$po = new PO_Details($db);
$project = new Project($db);

$status = $_POST['status'];

if($status == 12)//for receiving
{
    $view = $po->get_list_compliance();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {
        //get the COMPANY name if exist
        $comp_name = '-';
        $company->id = $row['comp-id'];
        $get2 = $company->get_company_detail();
        while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
        {
            if($row['comp-id'] == $rowComp['id']){
            $comp_name = $rowComp['company'];
            }
        }
        //get the SUPPLIER name if exist
        $sup_name = '-';
        $supplier->id = $row['supp-id'];
        $get3 = $supplier->get_supplier_details();
        while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
        {
            if($row['supp-id'] == $rowSupp['id']){
            $sup_name = $rowSupp['supplier_name'];
            }
        }
        $proj_name = '';
        //get the PROJECT name if exist
        $project->id = $row['proj-id'];
        $get1 = $project->get_proj_details();
        while($rowProj = $get1->fetch(PDO::FETCH_ASSOC))
        {
            if($row['proj-id'] == $rowProj['id']){
            $proj_name = $rowProj['project'];
            }
        }
        //date format
        $date_release = date('m/d/Y', strtotime($row['date_release']));                              
        $due = date('m/d/Y', strtotime($row['due_date']));                              
        $action = '<button class="btn-sm btn-success received" value="'.$row['po-id'].'" disabled><i class="fas fa-check"></i></button>
        <button class="btn-sm btn-danger return" value="'.$row['po-id'].'" disabled><i class="fas fa-times-circle"></i></button>';
        echo '
        <tr>
            <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
            <td>'.$action.'</td>
            <td>'.$date_release.'</td>
            <td>'.$row['cv_no'].'</td>
            <td>'.$row['check_no'].'</td>
            <td>'.number_format(floatval($row['cv_amount']), 2).'</td>
            <td>'.$comp_name.'</td>
            <td>'.$row['po_num'].'</td>
            <td style="width: 180px">'.$sup_name.'</td>
            <td>'.$due.'</td>
            <td>'.$proj_name.'</td>
        </tr>';
    }
}
else//returned
{
    $view = $po->get_returned_comp();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {
        //get the COMPANY name if exist
        $comp_name = '-';
        $company->id = $row['comp-id'];
        $get2 = $company->get_company_detail();
        while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
        {
            if($row['comp-id'] == $rowComp['id']){
            $comp_name = $rowComp['company'];
            }
        }
        //get the SUPPLIER name if exist
        $sup_name = '-';
        $supplier->id = $row['supp-id'];
        $get3 = $supplier->get_supplier_details();
        while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
        {
            if($row['supp-id'] == $rowSupp['id']){
            $sup_name = $rowSupp['supplier_name'];
            }
        }
        $proj_name = '';
        //get the PROJECT name if exist
        $project->id = $row['proj-id'];
        $get1 = $project->get_proj_details();
        while($rowProj = $get1->fetch(PDO::FETCH_ASSOC))
        {
            if($row['proj-id'] == $rowProj['id']){
            $proj_name = $rowProj['project'];
            }
        }
        //date format
        $date_release = date('m/d/Y', strtotime($row['date_release']));                              
        $due = date('m/d/Y', strtotime($row['due_date']));                              
        $action = '<button class="btn-sm btn-success received" value="'.$row['po-id'].'"><i class="fas fa-check"></i></button>
        <button class="btn-sm btn-danger return" value="'.$row['po-id'].'"><i class="fas fa-times-circle"></i></button>';
        echo '
        <tr>
            <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
            <td>'.$action.'</td>
            <td>'.$date_release.'</td>
            <td>'.$row['cv_no'].'</td>
            <td>'.$row['check_no'].'</td>
            <td>'.number_format(floatval($row['cv_amount']), 2).'</td>
            <td>'.$comp_name.'</td>
            <td>'.$row['po_num'].'</td>
            <td style="width: 180px">'.$sup_name.'</td>
            <td>'.$due.'</td>
            <td>'.$proj_name.'</td>
        </tr>';
    }
}
?>