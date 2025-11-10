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
$excelData = [];
// Excel file name for download 
$fileName = 'AP Dashboard - Manager'."'".'s Report.xlsx';
//1st row REPORT PAGE HEADER
// $header1 = array('', '', 'REQUEST DETAILS', '', '', '', 'REQUEST OTHER DETAILS', '', '', 'REQUEST CHECK DETAILS', '', '', '', '', '', '', '');
// $excelData[] = implode("\t", array_values($header1)) . "\n"; 
// //2nd row REPORT PAGE HEADER
// $header2 = array('COMPANY', 'PROJECT', 'VENDOR', 'PO/JO #', 'SI NO', 'SI/BILLING DATE', 'AMOUNT', 'RECEIVED BY', 'DATE RETURNED', 'RETURN REMARKS', 'DATE RESUBMITTED', 'DATE RECEIVED ACCT', 'DATE RECEIVED BO', 'CHECK DATE', 'CV NO.', 'CHECK NO', 'BANK', 'DUE DATE', 'MEMO NO.', 'TAX', 'CV AMOUNT', 'FORWARDED TO EA', 'RETURNED FROM EA', 'DATE TO MANILA', 'DATE MARKED FOR RELEASING', 'DATE RELEASED', 'DATE SUBMITTED', 'STATUS');
// $excelData[] = implode("\t", array_values($header2)) . "\n"; 

//GENERATE REPORT BY DATE SPAN
if($_GET['action'] == 8)
{
    $get = $report->get_by_date_manager($from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        $date_received_bo = '-';
        $date_received_fo = '-';
        $date_return = '-'; 
        $date_resubmit = '-';
        $date_for_release = '-';
        $date_to_manila = '-';
        //get the other_po_details
        $date_to_ea = '';
        $date_from_ea = '';
        $date_release = '';
        $bill_date = '';
        $due_date = '';
        $date_submit = '';
        $date_received_bo = '';
        $date_received_fo = '';
        $date_return = ''; 
        $date_resubmit = '';
        $date_for_release = '';
        $date_to_manila = '';
        $received_by_fo = 0;
        $remarks = '-';
        $report->po_id = $row['po-id'];        
        $get_data = $report->get_other_po_details();
        while($row1 = $get_data->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['2nd_date_received'] != null || $row1['2nd_date_received'] != '1970-01-01'){
            $date_received_fo = date('m-d-Y', strtotime($row1['2nd_date_received']));
            }else{
                $date_received_fo = date('m-d-Y', strtotime($row1['date_received_fo']));
            }
            if($row1['date_to_ea'] == null || $row1['date_to_ea'] == '1970-01-01'){$date_to_ea = '-';}else{$date_to_ea = date('m-d-Y', strtotime($row1['date_to_ea']));}
            if($row1['date_from_ea'] == null || $row1['date_from_ea'] == '1970-01-01'){$date_from_ea = '-';}else{$date_from_ea = date('m-d-Y', strtotime($row1['date_from_ea']));}
            if($row1['date_release'] == null || $row1['date_release'] == '1970-01-01'){$date_release = '-';}else{$date_release = date('m-d-Y', strtotime($row1['date_release']));}
            if($row['bill_date'] == null || $row['bill_date'] == '1970-01-01'){$bill_date = '-';}else{$bill_date = date('m-d-Y', strtotime($row['bill_date']));}
            if($row['due_date'] == null || $row['due_date'] == '1970-01-01'){$due_date = '-';}else{$due_date = date('m-d-Y', strtotime($row['due_date']));}
            if($row['date_submit'] == null || $row['date_submit'] == '1970-01-01'){$date_submit = '-';}else{$date_submit = date('m-d-Y', strtotime($row['date_submit']));}
            if($row1['date_received_bo'] == null || $row1['date_received_bo'] == '1970-01-01'){$date_received_bo = '-';}else{$date_received_bo = date('m-d-Y', strtotime($row1['date_received_bo']));}
            if($row1['date_received_fo'] == null || $row1['date_received_fo'] == '1970-01-01'){$date_received_fo = '-';}else{$date_received_fo = date('m-d-Y', strtotime($row1['date_received_fo']));}
            if($row1['date_returned_req'] == null || $row1['date_returned_req'] == '1970-01-01'){$date_return = '-';}else{$date_return = date('m-d-Y', strtotime($row1['date_returned_req']));}
            if($row1['date_resubmit'] == null || $row1['date_resubmit'] == '1970-01-01'){$date_resubmit = '-';}else{$date_resubmit = date('m-d-Y', strtotime($row1['date_resubmit']));}
            if($row1['date_for_release'] == null || $row1['date_for_release'] == '1970-01-01'){$date_for_release = '-';}else{$date_for_release = date('m-d-Y', strtotime($row1['date_for_release']));}
            if($row1['date_to_manila'] == null || $row1['date_to_manila'] == '1970-01-01'){$date_to_manila = '-';}else{$date_to_manila = date('m-d-Y', strtotime($row1['date_to_manila']));}
            $received_by_fo = $row1['received_by_fo'];
            $remarks = $row1['remarks'];
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['company'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['company']){
                $comp_name = $row1['company'];
            }else{
                $comp_name = '-';
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
            }else{
                $proj_name = '-';
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
            }else{
                $supp_name = '-';
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
                }else{
                    $bank_name = '-'; 
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
        $user->id = $received_by_fo;
        $get_user = $user->get_user_detail_byid();
        while($row5 = $get_user->fetch(PDO:: FETCH_ASSOC))
        {
            $received_by_fo = $row5['firstname'].' '.$row5['lastname'];
        }
        
        //initialize data for excel
        $lineData = [$comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['amount'], $received_by_fo, $date_return, $row['remark'], $date_resubmit, $date_received_fo, $date_received_bo, $check_date, $cv_no, $check_no, $bank_name, $due_date, $row['memo_no'], $tax, $cv_amount, $date_to_ea, $date_from_ea, $date_to_manila, $date_for_release, $date_release, $date_submit, $status];
        $excelData[] = $lineData;
    }
    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName);
}
?>