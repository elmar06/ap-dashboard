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

//initialize data
$comp = $_GET['company'];
$supp = $_GET['supplier'];
$stat = $_GET['status'];
$from = date('Y-m-d', strtotime($_GET['date_from']));
$to = date('Y-m-d', strtotime($_GET['date_to']));
// Excel file name for download 
$fileName = 'AP Dashboard - Manager'."'".'s Report.xlsx';
//1st row REPORT PAGE HEADER
// $header1 = array('', '', 'REQUEST DETAILS', '', '', '', 'REQUEST OTHER DETAILS', '', '', 'REQUEST CHECK DETAILS', '', '', '', '', '', '', '');
// $excelData = implode("\t", array_values($header1)) . "\n"; 
//2nd row REPORT PAGE HEADER
$excelData[] = array('COMPANY', 'PAYEE', 'DATE FORWARDED', 'DATE RECEIVED', 'CV #', 'CHECK #', 'CV AMOUNT', 'PO/JO #', 'STATUS');


//GENERATE REPORT BY COMPANY & DATE SPAN
if($_GET['action'] == 1)
{
    $get = $report->get_by_comp_date_ea($comp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received = '-';
        $date_forwarded = '-';
        
        if($row['date_received_ea'] != null){
            $date_received = date('m-d-Y', strtotime($row['date_received_ea']));
        }
        if($row['date_to_ea'] != null){
            $date_forwarded = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['company']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supplier']){
               $supp_name = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\xFF]/u', '', $row3['supplier_name']);
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $cv_amount = '-';
        $check_date = '-';
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
        }
        //format of status
        if($row['status'] == 6){
            $status = 'For Receiving';
        }else if($row['status'] == 7){
            $status = 'For Signature';
        }else{
            $status = 'Returned to Accounting';
        }

        //initialize data for excel
        $lineData = array($comp_name, $supp_name, $date_forwarded, $date_received, $cv_no, $check_no, $cv_amount, $row['po_num'], $status);
        $excelData[] = $lineData;
    }  
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERRATE REPORT BY SUPPLIER & DATE SPAN
if($_GET['action'] == 2)
{
    $get = $report->get_by_supp_date_ea($supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received = '-';
        $date_forwarded = '-';
        
        if($row['date_received_ea'] != null){
            $date_received = date('m-d-Y', strtotime($row['date_received_ea']));
        }
        if($row['date_to_ea'] != null){
            $date_forwarded = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['company']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supplier']){
               $supp_name = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\xFF]/u', '', $row3['supplier_name']);
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $cv_amount = '-';
        $check_date = '-';
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
        }
        //format of status
        if($row['status'] == 6){
            $status = 'For Receiving';
        }else if($row['status'] == 7){
            $status = 'For Signature';
        }else{
            $status = 'Returned to Accounting';
        }

        //initialize data for excel
        $lineData = array($comp_name, $supp_name, $date_forwarded, $date_received, $cv_no, $check_no, $cv_amount, $row['po_num'], $status);
        $excelData[] = $lineData; 
    }  
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY STATUS & DATE SPAN
if($_GET['action'] == 3)
{
    //check if status is in proces
    if($stat == 3){
        $get = $report->get_by_stat3_date_ea($from, $to);
    }else{
        $get = $report->get_by_stat_date_ea($stat, $from, $to);
    }
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received = '-';
        $date_forwarded = '-';
        
        if($row['date_received_ea'] != null){
            $date_received = date('m-d-Y', strtotime($row['date_received_ea']));
        }
        if($row['date_to_ea'] != null){
            $date_forwarded = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['company']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supplier']){
               $supp_name = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\xFF]/u', '', $row3['supplier_name']);
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $cv_amount = '-';
        $check_date = '-';
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
        }
        //format of status
        if($row['status'] == 6){
            $status = 'For Receiving';
        }else if($row['status'] == 7){
            $status = 'For Signature';
        }else{
            $status = 'Returned to Accounting';
        }

        //initialize data for excel
        $lineData = array($comp_name, $supp_name, $date_forwarded, $date_received, $cv_no, $check_no, $cv_amount, $row['po_num'], $status);
        $excelData[] = $lineData;
    }   
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY COMPANY, SUPPLIER & DATE SPAN
if($_GET['action'] == 4)
{
    $get = $report->get_by_comp_supp_date_manager($comp, $supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received = '-';
        $date_forwarded = '-';
        
        if($row['date_received_ea'] != null){
            $date_received = date('m-d-Y', strtotime($row['date_received_ea']));
        }
        if($row['date_to_ea'] != null){
            $date_forwarded = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['company']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supplier']){
               $supp_name = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\xFF]/u', '', $row3['supplier_name']);
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $cv_amount = '-';
        $check_date = '-';
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
        }
        //format of status
        if($row['status'] == 6){
            $status = 'For Receiving';
        }else if($row['status'] == 7){
            $status = 'For Signature';
        }else{
            $status = 'Returned to Accounting';
        }

        //initialize data for excel
        $lineData = array($comp_name, $supp_name, $date_forwarded, $date_received, $cv_no, $check_no, $cv_amount, $row['po_num'], $status);
        $excelData[] = $lineData;
    }  
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY PROJECT, COMPANY, SUPPLIER & DATE SPAN
if($_GET['action'] == 5)
{
    //check the status
    if($stat == 6){
        $get = $report->get_all_report_ea($comp, $supp, $stat, $from, $to);
    }else{
        $get = $report->get_all3_report_ea($comp, $supp, $from, $to);
    }
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received = '-';
        $date_forwarded = '-';
        
        if($row['date_received_ea'] != null){
            $date_received = date('m-d-Y', strtotime($row['date_received_ea']));
        }
        if($row['date_to_ea'] != null){
            $date_forwarded = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['company']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supplier']){
               $supp_name = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\xFF]/u', '', $row3['supplier_name']);
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $cv_amount = '-';
        $check_date = '-';
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
        }
        //format of status
        if($row['status'] == 6){
            $status = 'For Receiving';
        }else if($row['status'] == 7){
            $status = 'For Signature';
        }else{
            $status = 'Returned to Accounting';
        }

        //initialize data for excel
        $lineData = array($comp_name, $supp_name, $date_forwarded, $date_received, $cv_no, $check_no, $cv_amount, $row['po_num'], $status);
        $excelData[] = $lineData;
    }  
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY PROJECT, COMPANY, SUPPLIER, STATUS & DATE SPAN
if($_GET['action'] == 6)
{
    $get = $report->get_by_comp_supp_ea($comp, $supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received = '-';
        $date_forwarded = '-';
        
        if($row['date_received_ea'] != null){
            $date_received = date('m-d-Y', strtotime($row['date_received_ea']));
        }
        if($row['date_to_ea'] != null){
            $date_forwarded = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['company']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supplier']){
               $supp_name = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\xFF]/u', '', $row3['supplier_name']);
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $cv_amount = '-';
        $check_date = '-';
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
        }
        //format of status
        if($row['status'] == 6){
            $status = 'For Receiving';
        }else if($row['status'] == 7){
            $status = 'For Signature';
        }else{
            $status = 'Returned to Accounting';
        }

        //initialize data for excel
        $lineData = array($comp_name, $supp_name, $date_forwarded, $date_received, $cv_no, $check_no, $cv_amount, $row['po_num'], $status);
        $excelData[] = $lineData;
    }  
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY DATE SPAN
if($_GET['action'] == 7)
{
    //check status
    if($stat == 6){
        $get = $report->get_by_comp_stat_ea($comp, $stat, $from, $to);
    }else{
        $get = $report->get_by_comp_stat3_ea($comp, $from, $to);
    }
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received = '-';
        $date_forwarded = '-';
        
        if($row['date_received_ea'] != null){
            $date_received = date('m-d-Y', strtotime($row['date_received_ea']));
        }
        if($row['date_to_ea'] != null){
            $date_forwarded = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['company']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supplier']){
               $supp_name = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\xFF]/u', '', $row3['supplier_name']);
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $cv_amount = '-';
        $check_date = '-';
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
        }
        //format of status
        if($row['status'] == 6){
            $status = 'For Receiving';
        }else if($row['status'] == 7){
            $status = 'For Signature';
        }else{
            $status = 'Returned to Accounting';
        }

        //initialize data for excel
        $lineData = array($comp_name, $supp_name, $date_forwarded, $date_received, $cv_no, $check_no, $cv_amount, $row['po_num'], $status);
        $excelData[] = $lineData;
    }  
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY SUPPLIER, STATUS & DATE SPAN
if($_GET['action'] == 8)
{
    //check status
    if($stat == 6){
        $get = $report->get_by_supp_stat_ea($comp, $stat, $from, $to);
    }else{
        $get = $report->get_by_supp_stat3_ea($comp, $from, $to);
    }
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received = '-';
        $date_forwarded = '-';
        
        if($row['date_received_ea'] != null){
            $date_received = date('m-d-Y', strtotime($row['date_received_ea']));
        }
        if($row['date_to_ea'] != null){
            $date_forwarded = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['company']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supplier']){
               $supp_name = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\xFF]/u', '', $row3['supplier_name']);
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $cv_amount = '-';
        $check_date = '-';
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
        }
        //format of status
        if($row['status'] == 6){
            $status = 'For Receiving';
        }else if($row['status'] == 7){
            $status = 'For Signature';
        }else{
            $status = 'Returned to Accounting';
        }

        //initialize data for excel
        $lineData = array($comp_name, $supp_name, $date_forwarded, $date_received, $cv_no, $check_no, $cv_amount, $row['po_num'], $status);
        $excelData[] = $lineData;
    }  
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY PROJECT, STATUS & DATE SPAN
if($_GET['action'] == 9)
{
    $get = $report->get_by_date_ea($from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received = '-';
        $date_forwarded = '-';
        
        if($row['date_received_ea'] != null){
            $date_received = date('m-d-Y', strtotime($row['date_received_ea']));
        }
        if($row['date_to_ea'] != null){
            $date_forwarded = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['company']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supplier']){
               $supp_name = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\xFF]/u', '', $row3['supplier_name']);
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $cv_amount = '-';
        $check_date = '-';
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
        }
        //format of status
        if($row['status'] == 6){
            $status = 'For Receiving';
        }else if($row['status'] == 7){
            $status = 'For Signature';
        }else{
            $status = 'Returned to Accounting';
        }

        //initialize data for excel
        $lineData = array($comp_name, $supp_name, $date_forwarded, $date_received, $cv_no, $check_no, $cv_amount, $row['po_num'], $status);
        $excelData[] = $lineData;
    }  
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}
 
exit;

?>