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
$proj = $_GET['project'];
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
$excelData[] = array('COMPANY', 'PROJECT', 'VENDOR', 'PO/JO #', 'IR #', 'SI NO', 'SI/BILLING DATE', 'AMOUNT', 'RECEIVED BY', 'DATE RETURN', 'RETURN REMARKS', 'DATE RESUBMITTED', 'DATE RECEIVED ACCT', 'DATE RECEIVED BO', 'CHECK DATE', 'CV NO.', 'CHECK NO', 'BANK', 'DUE DATE', 'MEMO NO.', 'TAX', 'CV AMOUNT', 'FORWARDED TO EA', 'RETURNED FROM EA', 'DATE RELEASED', 'SUBMITTED BY', 'DATE SUBMITTED', 'STATUS');

//GENERATE REPORT BY PROJECT & DATE SPAN
if($_GET['action'] == 1)
{   
    $get = $report->get_by_proj_date_manager($proj, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }  
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName); 
}

//GENERATE REPORT BY COMPANY & DATE SPAN
if($_GET['action'] == 2)
{
    $get = $report->get_by_comp_date_manager($comp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERRATE REPORT BY SUPPLIER & DATE SPAN
if($_GET['action'] == 3)
{
    $get = $report->get_by_supp_date_manager($supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY STATUS & DATE SPAN
if($_GET['action'] == 4)
{
    //check if status is in proces
    if($stat == 3){
        $get = $report->get_by_stat3_date_manager($from, $to);
    }elseif($stat == 11){
        $get = $report->get_released_po($from, $to);
    }else{
        $get = $report->get_by_stat_date_manager($stat, $from, $to);
    }
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY PROJECT, COMPANY & DATE SPAN
if($_GET['action'] == 5)
{
    $get = $report->get_by_comp_proj_date_manager($proj, $comp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY PROJECT, COMPANY, SUPPLIER & DATE SPAN
if($_GET['action'] == 6)
{
    $get = $report->get_by_proj_comp_supp_date_manager($proj, $comp, $supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY PROJECT, COMPANY, SUPPLIER, STATUS & DATE SPAN
if($_GET['action'] == 7)
{
    $get = $report->get_all_date_manager($proj, $comp, $supp, $stat, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY DATE SPAN
if($_GET['action'] == 8)
{
    $get = $report->get_by_date_manager($from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY PROJECT, SUPPLIER & DATE SPAN
if($_GET['action'] == 9)
{
    $get = $report->get_by_proj_supp_date_manager($proj, $supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY PROJECT, STATUS & DATE SPAN
if($_GET['action'] == 10)
{
    //check if status is in proces
    if($stat == 3){
        $get = $report->get_by_proj_stat3_date_manager($proj, $from, $to);
    }else{
        $get = $report->get_by_proj_stat_date_manager($proj, $stat, $from, $to);
    }
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY COMPANY, SUPPLIER & DATE SPAN
if($_GET['action'] == 11)
{
    $get = $report->get_by_comp_supp_date_manager($comp, $supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY COMPANY, STATUS & DATE SPAN
if($_GET['action'] == 12)
{
    //check if status is in proces
    if($stat == 3){
        $get = $report->get_by_comp_stat3_date_manager($proj, $from, $to);
    }else{
        $get = $report->get_by_comp_stat_date_manager($comp, $stat, $from, $to);
    }
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY SUPPLIER, STATUS & DATE SPAN
if($_GET['action'] == 13)
{
    //check if status is in proces
    if($stat == 3){
        $get = $report->get_by_supp_stat3_date_manager($supp, $from, $to);
    }else{
        $get = $report->get_by_supp_stat_date_manager($supp, $stat, $from, $to);
    }
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY PROJECT, SUPPLIER, STATUS & DATE SPAN
if($_GET['action'] == 14)
{
    //check if status is in proces
    if($stat == 3){
        $get = $report->get_by_proj_supp_stat3_date_manager($proj, $supp, $from, $to);
    }else{
        $get = $report->get_by_proj_supp_stat_date_manager($proj, $supp, $stat, $from, $to);
    }
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}

//GENERATE REPORT BY PROJECT, COMPANY, STATUS & DATE SPAN
if($_GET['action'] == 15)
{
    //check if status is in proces
    if($stat == 3){
        $get = $report->get_by_proj_supp_stat3_date_manager($proj, $supp, $from, $to);
    }else{
        $get = $report->get_by_proj_supp_stat_date_manager($proj, $supp, $stat, $from, $to);
    }
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        if($row['2nd_date_received'] != null || $row['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row['2nd_date_received']));
        }else{
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] == null || $row['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));}
        if($row['date_from_ea'] == null || $row['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));}
        if($row['date_release'] == null || $row['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row['date_release']));}
        if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
        if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
        if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
        if($row['date_received_bo'] == null || $row['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row['date_received_bo']));}
        if($row['date_received_fo'] == null || $row['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));}
        if($row['date_returned_req'] == null || $row['date_returned_req'] == '1970-01-01'){$date_return = '-'; }else{$date_return = date('m-d-Y', strtotime($row['date_returned_req']));}
        if($row['date_resubmit'] == null || $row['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row['date_resubmit']));}
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
                $supp_name = $row3['supplier_name'];
            }
        }
        //get the check details
        $cv_no = '-';
        $check_no = '-';
        $tax = '-';
        $cv_amount = '-';
        $check_date = '-';
        $bank_name = '-'; 
        $check->po_id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO::FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['name'];
                }
            }
        }
        //format of status
        if($row['status'] == 1){
            $status = 'Pending';
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
        }else if($row['status'] == 11){
            $status = 'Released';
        }else if($row['status'] == 12){
            $status = 'Forwarded to Compliance';
        }else if($row['status'] == 13){
            $status = 'Returned by Compliance';
        }else if($row['status'] == 14){
            $status = 'Accept/Received by Compliance';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'Cancelled';
        }
        //get the name of receiving acct FO
        $received_by_fo = '-';
        $user->id = $row['received_by_fo'];
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['ir_rr_no'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remarks'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}
 
exit;

?>