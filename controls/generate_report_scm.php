<?php
use CodexWorld\PhpXlsxGenerator;
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCompany.php';
include '../objects/clsSupplier.php';
include '../objects/clsProject.php';
include '../objects/clsBank.php';
include '../objects/clsReport.php';
include '../objects/clsCheckDetails.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$project = new Project($db);
$supplier = new Supplier($db);
$bank = new Banks($db);
$report = new Reports($db);
$check = new CheckDetails($db);
$user = new Users($db);
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
$from = date('Y-m-d', strtotime($_GET['date_from']));
$to = date('Y-m-d', strtotime($_GET['date_to']));

if($_GET['action'] == 16)
{
    // Excel file name for download 
    $fileName = 'AP Dashboard Disbursement Report.xls';
    $excelData[] = array('COMPANY', 'PROJECT', 'VENDOR NAME', 'CV NUMBER', 'CHECK NUMBER', 'AMOUNT', 'DATE RELEASED', 'OR#/CR#');   

    $get = $po->get_disbursement_by_date($from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        //get the name of company
        $comp_name = '';
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            $comp_name = $row1['company'];
        }
        //get the name of project
        $proj_name = '';
        $project->id = $row['project'];
        $get_proj = $project->get_proj_details();
        while($row2 = $get_proj->fetch(PDO:: FETCH_ASSOC))
        {
            if($row2['id'] == $row['project']){
                $proj_name = $row2['project'];
            }else{
                $proj_name = '';
            }
        }
        //get the name of supplier
        $supp_name = '';
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            $supp_name = $row3['supplier_name'];
        }
        //check if empty
        $date_release = '-';
        if($row['date_release'] != null || $row['date_release'] != ''){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        } 
        $or_num = '-';
        if($row['or_num'] != '' || $row['or_num'] != null){
            $or_num = $row['or_num'];
        }
        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['cv_no'], $row['check_no'], $row['amount'], $date_release, $or_num);
        $excelData[] = $lineData;            
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
    
    exit;
}

//GENERATE YEAREND REPORT
if($_GET['action'] == 17)
{
    $excelData[] = array('SI #', 'COMPANY', 'VENDOR NAME', 'AMOUNT', 'PO/JO #', 'PROJECT', 'DUE DATE', 'DOC SUBMITTED', 'STATUS');   

    $po->date_submit = $_GET['year'];
    $get = $po->get_yearend_by_date();
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        //get the name of company
        $comp_name = '';
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            $comp_name = $row1['company'];
        }
        //get the name of project
        $proj_name = '';
        $project->id = $row['project'];
        $get_proj = $project->get_proj_details();
        while($row2 = $get_proj->fetch(PDO:: FETCH_ASSOC))
        {
            if($row2['id'] == $row['project']){
                $proj_name = $row2['project'];
            }else{
                $proj_name = '';
            }
        }
        //get the name of supplier/vendor name
        $supp_name = '';
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            $supp_name = $row3['supplier_name'];
        }
        //YEAR END REQUIREMENTS
        if($row['yr_req'] == 1){
            $docs = 'Original SI';
        }else if($row['yr_req'] == 2){
            $docs = 'Duplicate SI';
        }else if($row['yr_req'] == 3){
            $docs = 'CTC';
        }else{
            $docs = '--';
        }  
        //format of status
        if($row['status'] == 1){
            $status = 'Pending for AP';
        }else if($row['status'] == 2){
            $status = 'Returned';
        }else if($row['status'] == 3){
            $status = 'Received by FO';
        }else if($row['status'] == 4){
            $status = 'Process by BO';
        }elseif($row['status'] == 5){
            $status = 'For Signature';
        }elseif($row['status'] == 6){
            $status = ' Sent to EA';
        }else if($row['status'] == 7){
            $status = 'Received by EA';
        }elseif($row['status'] == 8){
            $status = 'Returned by EA';
        }elseif($row['status'] == 9){
            $status = 'On Hold';
        }else if($row['status'] == 10){
            $status = 'For Releasing';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 17){
            $status = 'For Receiving by Compliance';
        }else if($row['status'] == 18){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 19){
            $status = 'Received by Compliance';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Released';
        } 
        //amount format
        $amount = number_format(intval($row['amount']), 2); 
        $due_date = date('m-d-Y', strtotime($row['due_date']));        

        //initialize data for excel
        $lineData = array($row['si_num'], $comp_name, $supp_name, $amount, $row['po_num'], $proj_name, $due_date, $docs, $status);
        $excelData[] = $lineData;               
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
    
    exit;
}
?>