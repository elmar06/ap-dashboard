<?php
use CodexWorld\PhpXlsxGenerator;
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCompany.php';
include '../objects/clsSupplier.php';
include '../objects/clsProject.php';
include '../objects/clsReport.php';
include '../objects/clsCheckDetails.php';
include '../objects/clsBank.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$project = new Project($db);
$supplier = new Supplier($db);
$report = new Reports($db);
$check = new CheckDetails($db);
$bank = new Banks($db);

// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 

//get the Manila time by timezone
date_default_timezone_set('Asia/Manila');
//initialize variable
$from = date('Y-m-d', strtotime($_GET['date_from']));
$to = date('Y-m-d', strtotime($_GET['date_to']));
$action = $_GET['action'];

if($action == 1)//CHECK FOR RELEASE
{
    $comp = $_GET['company'];
    $proj = $_GET['project'];
    $supp = $_GET['supplier'];
    //GENERATE BY COMPANY, DATE SPAN, PROJECT & SUPPLIER
    // Excel file name for download 
    $fileName = 'AP Dashboard Report(For Releasing).xlsx';
    //column REPORT PAGE HEADER
    $excelData[] = array('INNOGROUP OF COMPANIES');   
    $excelData[] = array('LIST OF CHECKS FOR RELEASE');   
    $excelData[] = array('PO #', 'PAYEE', 'COMPANY', 'PROJECT', 'CV NUMBER', 'CHECK NUMBER', 'AMOUNT', 'DATE FOR RELEASE');   

    //CHECK FOR RELEASE
    if($_GET['rep_action'] == 1)
    {   
        //GENERATE REPORT BY PROJECT & DATE SPAN
        $get = $report->get_by_proj_date_fo($proj, $from, $to);
        while($row = $get->fetch(PDO:: FETCH_ASSOC))
        {           
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
            //get the name of project
            $proj_name = '-';
            $project->id = $row['project'];
            $get_proj = $project->get_proj_details();
            while($row2 = $get_proj->fetch(PDO:: FETCH_ASSOC))
            {
                if($row2['id'] == $row['project']){
                    $proj_name = $row2['project'];
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
            $amount = number_format(floatval($row['cv_amount']), 2);
            $date_release = date('m-d-Y', strtotime($row['date_for_release']));
            //initialize data for excel
            $lineData = array($supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount, $date_release);
            $excelData[] = $lineData;
        }  
    }

    //GENERATE REPORT BY COMPANY & DATE SPAN
    if($_GET['rep_action'] == 2)
    {
        $get = $report->get_by_comp_date_fo($comp, $from, $to);
        while($row = $get->fetch(PDO:: FETCH_ASSOC))
        {
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
            //get the name of project
            $proj_name = '-';
            $project->id = $row['project'];
            $get_proj = $project->get_proj_details();
            while($row2 = $get_proj->fetch(PDO:: FETCH_ASSOC))
            {
                if($row2['id'] == $row['project']){
                    $proj_name = $row2['project'];
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
            $amount = number_format(floatval($row['cv_amount']), 2);
            $date_release = date('m-d-Y', strtotime($row['date_for_release']));
            //initialize data for excel
            $lineData = array($row['po_num'], $supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount, $date_release);
            $excelData[] = $lineData;
        }  
    }

    //GENERRATE REPORT BY SUPPLIER & DATE SPAN
    if($_GET['rep_action'] == 3)
    {
        $get = $report->get_by_supp_date_fo($supp, $from, $to);
        while($row = $get->fetch(PDO:: FETCH_ASSOC))
        {
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
            //get the name of project
            $proj_name = '-';
            $project->id = $row['project'];
            $get_proj = $project->get_proj_details();
            while($row2 = $get_proj->fetch(PDO:: FETCH_ASSOC))
            {
                if($row2['id'] == $row['project']){
                    $proj_name = $row2['project'];
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
            $amount = number_format(floatval($row['cv_amount']), 2);
            $date_release = date('m-d-Y', strtotime($row['date_for_release']));
            //initialize data for excel
            $lineData = array($row['po_num'], $supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount, $date_release);
            $excelData[] = $lineData;
        }  
    }

    //GENERATE REPORT BY COMPANY, PROJECT & DATE SPAN
    if($_GET['rep_action'] == 4)
    {
        $get = $report->get_by_comp_proj_date_fo($proj, $comp, $from, $to);
        while($row = $get->fetch(PDO:: FETCH_ASSOC))
        {
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
            //get the name of project
            $proj_name = '-';
            $project->id = $row['project'];
            $get_proj = $project->get_proj_details();
            while($row2 = $get_proj->fetch(PDO:: FETCH_ASSOC))
            {
                if($row2['id'] == $row['project']){
                    $proj_name = $row2['project'];
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
            $amount = number_format(floatval($row['cv_amount']), 2);
            $date_release = date('m-d-Y', strtotime($row['date_for_release']));
            //initialize data for excel
            $lineData = array($row['po_num'], $supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount, $date_release);
            $excelData[] = $lineData;
        }  
    }

    //GENERATE REPORT BY ALL
    if($_GET['rep_action'] == 5)
    {
        $get = $report->get_all_date_fo($proj, $comp, $supp, $from, $to);
        while($row = $get->fetch(PDO:: FETCH_ASSOC))
        {
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
            //get the name of project
            $proj_name = '-';
            $project->id = $row['project'];
            $get_proj = $project->get_proj_details();
            while($row2 = $get_proj->fetch(PDO:: FETCH_ASSOC))
            {
                if($row2['id'] == $row['project']){
                    $proj_name = $row2['project'];
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
            $amount = number_format(floatval($row['cv_amount']), 2);
            $date_release = date('m-d-Y', strtotime($row['date_for_release']));
            //initialize data for excel
            $lineData = array($row['po_num'], $supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount, $date_release);
            $excelData[] = $lineData;
        }
    }

    //GENERATE REPORT BY COMPANY, SUPPLIER & DATE SPAN
    if($_GET['rep_action'] == 6)
    {
        $get = $report->get_by_comp_supp_date_fo($comp, $supp, $from, $to);
        while($row = $get->fetch(PDO:: FETCH_ASSOC))
        {
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
            //get the name of project
            $proj_name = '-';
            $project->id = $row['project'];
            $get_proj = $project->get_proj_details();
            while($row2 = $get_proj->fetch(PDO:: FETCH_ASSOC))
            {
                if($row2['id'] == $row['project']){
                    $proj_name = $row2['project'];
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
            $amount = number_format(floatval($row['cv_amount']), 2);
            $date_release = date('m-d-Y', strtotime($row['date_for_release']));
            //initialize data for excel
            $lineData = array($row['po_num'], $supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount, $date_release);
            $excelData[] = $lineData;
        }
    }

    //GENERATE REPORT BY DATE SPAN
    if($_GET['rep_action'] == 7)
    {
        $get = $report->get_by_date_fo($from, $to);
        while($row = $get->fetch(PDO:: FETCH_ASSOC))
        {
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
            //get the name of project
            $proj_name = '-';
            $project->id = $row['project'];
            $get_proj = $project->get_proj_details();
            while($row2 = $get_proj->fetch(PDO:: FETCH_ASSOC))
            {
                if($row2['id'] == $row['project']){
                    $proj_name = $row2['project'];
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
            $amount = number_format(floatval($row['cv_amount']), 2);
            $date_release = date('m-d-Y', strtotime($row['date_for_release']));
            //initialize data for excel
            $lineData = array($row['po_num'], $supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount, $date_release);
            $excelData[] = $lineData;
        }
    }
}
elseif($action == 2)//DISBURSEMENT REPORT
{
    // Excel file name for download 
    $fileName = 'AP Dashboard Report.xlsx';
    //column REPORT PAGE HEADER
    $excelData[] = array('INNOGROUP OF COMPANIES');   
    $excelData[] = array('DISBURSEMENT REPORT');   
    $excelData[] = array('COMPANY', 'PROJECT', 'VENDOR NAME', 'CV NUMBER', 'CHECK NUMBER', 'AMOUNT', 'DATE RELEASED', 'OR#/CR#');   

    $get = $po->get_disbursement_by_date($from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        //get the name of company
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            $comp_name = $row1['company'];
        }
        //get the name of project
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
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            $supp_name = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\xFF]/u', '', $row3['supplier_name']);
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
}
elseif($_GET['action'] == 3)//PERCENTAGE REPORT
{
    // Excel file name for download 
    $fileName = 'AP Dashboard Percentage Report.xlsx';
    //column REPORT PAGE HEADER
    $excelData[] = array('INNDUCO PERCENTAGE REPORT');   
    $excelData[] = array('LIST OF CHECKS FOR RELEASE');   
    $excelData[] = array('COMPANY', 'PROJECT', 'PO AMOUNT', 'DATE RECEIVED BY FO', 'DATE RECEIVED BY BO', 'CHECK DATE', 'CV NUMBER', 'BANK', 'CHECK NO', 'PO DATE', 'DUE DATE', 'PAYEE', 'MEMO', 'WITHHOLDING', 'CV AMOUNT', 'DATE FROM EA', 'DATE RELEASED', 'OR#/CR#',);      

    $get = $po->get_percentage_by_date($from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        //get the name of company
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            $comp_name = $row1['company'];
        }
        //get the name of project
        $proj_name = '-';
        $project->id = $row['project'];
        $get_proj = $project->get_proj_details();
        while($row2 = $get_proj->fetch(PDO:: FETCH_ASSOC))
        {
            if($row2['id'] == $row['project']){
                $proj_name = $row2['project'];
            }
        }
        //get the name of supplier
        $supplier->id = $row['supplier'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            $supp_name = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\xFF]/u', '', $row3['supplier_name']);
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
        //date format
        $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        $date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));
        $po_date = date('m-d-Y', strtotime($row['po_date']));
        $due_date = date('m-d-Y', strtotime($row['due_date']));
        $date_from_ea = '-';
        if($row['date_from_ea'] != null || $row['date_from_ea'] != ''){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        $date_release = '-';
        if($row['date_release'] != null || $row['date_release'] != ''){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $account = '-';
        $check->po_id = $row['id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = number_format($row4['tax'], 2);
            $cv_amount = number_format($row4['cv_amount'], 2);
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                    $account = $row5['account'];
                }
            }
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, number_format($row['amount'], 2), $date_received_fo, $date_received_bo, $check_date, $cv_no, $account, $check_no, $po_date, $due_date, $supp_name, $row['memo_no'], $tax, $cv_amount, $date_from_ea, $date_release, $row['or_num']);
        $excelData[] = $lineData;    
    }
}
else//STALE CHECK
{
    // Excel file name for download 
    $fileName = 'Stale Check Report('.$from.' - '.$to.').xlsx';
    //column REPORT PAGE HEADER 
    $excelData[] = array('LIST OF STALE CHECKS');   
    $excelData[] = array('COMPANY', 'PAYEE', 'CHECK DATE', 'CHECK NO', 'CV NUMBER', 'BANK', 'TAX', 'CV AMOUNT', 'STALE DATE');

    $get = $check->get_staled_check($from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $comp_name = '-';
        $supp_name = '-';
        //get the name of company
        $company->id = $row['comp-id'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            $comp_name = $row1['company'];
        }
        //get the name of supplier
        $supplier->id = $row['supp-id'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            $supp_name = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\xFF]/u', '', $row3['supplier_name']);
        }
        
        //date format
        $check_date = date('m-d-Y', strtotime($row['check_date']));
        $stale_date = date('m-d-Y', strtotime($row['stale_date']));
        $cv_amount = number_format($row['cv_amount']);
        //get the bank name
        $bankName = '-';
        $bank->id = $row['bank'];
        $getBank = $bank->get_bank_details();
        while($rowBank = $getBank->fetch(PDO:: FETCH_ASSOC))
        {
            $bankName = $rowBank['name'];
        }
        //initialize data for excel
        $lineData = array($comp_name, $supp_name, $check_date, $row['check_no'], $row['cv_no'], $bankName, $row['tax'], $cv_amount, $stale_date);
        $excelData[] = $lineData;    
    }
}
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName);
 
exit;
?>