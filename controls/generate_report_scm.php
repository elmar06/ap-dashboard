<?php
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

function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}
//initialize data
$comp = $_GET['company'];
$proj = $_GET['project'];
$supp = $_GET['supplier'];
$stat = $_GET['status'];
$from = date('Y-m-d', strtotime($_GET['date_from']));
$to = date('Y-m-d', strtotime($_GET['date_to']));
// Excel file name for download 
$fileName = 'AP Dashboard - Manager'."'".'s Report.xls';
//1st row REPORT PAGE HEADER
// $header1 = array('', '', 'REQUEST DETAILS', '', '', '', 'REQUEST OTHER DETAILS', '', '', 'REQUEST CHECK DETAILS', '', '', '', '', '', '', '');
// $excelData = implode("\t", array_values($header1)) . "\n"; 
//2nd row REPORT PAGE HEADER
$header1 = array('COMPANY', 'PROJECT', 'VENDOR', 'PO/JO #', 'SI NO', 'SI/BILLING DATE', 'PO AMOUNT', 'AMOUNT', 'RECEIVED BY', 'DATE RECEIVED ACCT', 'DUE DATE', 'MEMO NO.', 'FORWARD TO EA', 'RETURNED FROM EA', 'DATE RELEASED', 'SUBMITTED BY', 'DATE SUBMIT', 'STATUS');
//Display column names in a row 
$excelData = implode("\t", array_values($header1)) . "\n"; 

//GENERATE REPORT BY PROJECT & DATE SPAN
if($_GET['action'] == 1)
{   
    $get = $report->get_by_proj_date_manager($proj, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }  
}

//GENERATE REPORT BY COMPANY & DATE SPAN
if($_GET['action'] == 2)
{
    $get = $report->get_by_comp_date_manager($comp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }  
}

//GENERRATE REPORT BY SUPPLIER & DATE SPAN
if($_GET['action'] == 3)
{
    $get = $report->get_by_supp_date_manager($supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }  
}

//GENERATE REPORT BY STATUS & DATE SPAN
if($_GET['action'] == 4)
{
    //check if status is in proces
    if($stat == 3){
        $get = $report->get_by_stat3_date_manager($from, $to);
    }else{
        $get = $report->get_by_stat_date_manager($stat, $from, $to);
    }
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n";
    }  
}

//GENERATE REPORT BY PROJECT, COMPANY & DATE SPAN
if($_GET['action'] == 5)
{
    $get = $report->get_by_comp_proj_date_manager($proj, $comp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n";  
    }
}

//GENERATE REPORT BY PROJECT, COMPANY, SUPPLIER & DATE SPAN
if($_GET['action'] == 6)
{
    $get = $report->get_by_proj_comp_supp_date_manager($proj, $comp, $supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
}

//GENERATE REPORT BY PROJECT, COMPANY, SUPPLIER, STATUS & DATE SPAN
if($_GET['action'] == 7)
{
    $get = $report->get_all_date_manager($proj, $comp, $supp, $stat, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
}

//GENERATE REPORT BY DATE SPAN
if($_GET['action'] == 8)
{
    $get = $report->get_by_date_manager($from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n";
    }
}

//GENERATE REPORT BY PROJECT, SUPPLIER & DATE SPAN
if($_GET['action'] == 9)
{
    $get = $report->get_by_proj_supp_date_manager($proj, $supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n";
    }
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
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }  
}

//GENERATE REPORT BY COMPANY, SUPPLIER & DATE SPAN
if($_GET['action'] == 11)
{
    $get = $report->get_by_comp_supp_date_manager($comp, $supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
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
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
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
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
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
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
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
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $date_release = '-';
        $bill_date = '-';
        $due_date = '-';
        $date_submit = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
        }
        if($row['bill_date'] != null){
            $bill_date = date('m-d-Y', strtotime($row['bill_date']));
        }
        if($row['due_date'] != null){
            $due_date = date('m-d-Y', strtotime($row['due_date']));
        }
        if($row['date_submit'] != null){
            $date_submit = date('m-d-Y', strtotime($row['date_submit']));
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
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else{
            $status = 'Released';
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
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $bill_date, $row['po_amount'], $row['amount'], $received_by_fo, $date_received_fo, $due_date, $row['memo_no'], $date_to_ea, $date_from_ea, $date_release, $row['fullname'], $date_submit, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
}

if($_GET['action'] == 16)
{
    // Excel file name for download 
    $fileName = 'AP Dashboard Disbursement Report.xls';
    //1st column REPORT PAGE HEADER
    $header1 = array('INNOGROUP OF COMPANIES');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header1)) . "\n"; 
    //2nd column
    $header2 = array('DISBURSEMENT REPORT');   
    //Display column names as first row 
    $excelData .= implode("\t", array_values($header2)) . "\n";
    //3rd column
    $header3 = array('COMPANY', 'PROJECT', 'VENDOR NAME', 'CV NUMBER', 'CHECK NUMBER', 'AMOUNT', 'DATE RELEASED', 'OR#/CR#');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header3)) . "\n";

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
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n";                
    }
}

//GENERATE YEAREND REPORT
if($_GET['action'] == 17)
{
    // Excel file name for download 
    $fileName = 'AP Dashboard YearEnd Report.xls';
    //1st column REPORT PAGE HEADER
    $header1 = array('INNOGROUP OF COMPANIES');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header1)) . "\n"; 
    //2nd column
    $header2 = array('YEAR END REPORT');   
    //Display column names as first row 
    $excelData .= implode("\t", array_values($header2)) . "\n";
    //3rd column
    $header3 = array('SI #', 'COMPANY', 'VENDOR NAME', 'AMOUNT', 'PO/JO #', 'PROJECT', 'DUE DATE', 'DOC SUBMITTED', 'STATUS');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header3)) . "\n";

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
        }else{
            $status = 'Released';
        } 
        //amount format
        $amount = number_format(intval($row['amount']), 2); 
        $due_date = date('m/d/Y', strtotime($row['due_date']));        

        //initialize data for excel
        $lineData = array($row['si_num'], $comp_name, $supp_name, $amount, $row['po_num'], $proj_name, $due_date, $docs, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n";                
    }
}

// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;

?>