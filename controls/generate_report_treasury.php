<?php
use CodexWorld\PhpXlsxGenerator;
include '../config/clsConnection.php';
include '../objects/clsReport.php';
include '../objects/clsCompany.php';
include '../objects/clsSupplier.php';

$database = new clsConnection();
$db = $database->connect();

$report = new Reports($db);
$supplier = new Supplier($db);
$company = new Company($db);

// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 

//initialize data
$comp_id  = $_GET['company'];
$supplier_id = $_GET['supplier'];
$stat_id = $_GET['status'];
$from = date('Y-m-d', strtotime($_GET['date_from']));
$to = date('Y-m-d', strtotime($_GET['date_to']));
$action = $_GET['action'];

// Excel file name for download 
$fileName = 'Treasury Report('.date('m-d-Y', strtotime($from)).' - '.date('m-d-Y', strtotime($to)).').xls';
// 1st Column names 
$excelData[] = array('CHECK DATE', 'CV NUMBER', 'DATE RECEIVED', 'DUE DATE', 'CHECK NUMBER', 'SUPPLIER', 'COMPANY', 'CV AMOUNT', 'DATE ONHOLD', 'DATE RELEASE', 'STATUS');

//GENERATE REPORT BY COMPANY & DATE SPAN
if($action == 1)
{
    $get_data = $report->generate_by_comp_treasury($from, $to, $comp_id);
    while($row = $get_data->fetch(PDO::FETCH_ASSOC))
    {
        $check_date = date('m/d/y', strtotime($row['check_date'])); 
        $cv_num = $row['cv_no'];
        $received_date = date('m/d/y', strtotime($row['date_received_fo']));
        $due_date = date('m/d/y', strtotime($row['due_date']));
        $check_num = $row['check_no'];
        $amount = number_format(floatval($row['cv_amount']), 2);
        //date from other details
        $date_onhold = '-';
        $releasing_date = '-';
        if($row['date_on_hold'] != null || $row['date_on_hold'] != ''){
            $date_onhold = date('m/d/y', strtotime($row['date_on_hold']));
        }
        if($row['date_for_release'] != null || $row['date_for_release'] != ''){
            $releasing_date = date('m/d/y', strtotime($row['date_for_release']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['comp-id'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['comp-id']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supp-id'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supp-id']){
                $supp_name = $row3['supplier_name'];
            }
        }
        //status
        if($row['status'] == 3){
            $status = 'In Process';
        }elseif($row['status'] == 4){
            $status = 'Process by Back Office';
        }elseif($row['status'] == 5){
            $status = 'For Signature';
        }elseif($row['status'] == 6){
            $status = 'Sent To EA';
        }elseif($row['status'] == 7){
            $status = 'Signed by EXECOM';
        }elseif($row['status'] == 8){
            $status = 'Returned from EA';
        }elseif($row['status'] == 9){
            $status = 'On Hold/For Funding';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'For Releasing';
        }

        $lineData = array($check_date, $cv_num, $received_date, $due_date, $check_num, $supp_name, $comp_name, $amount, $date_onhold, $releasing_date, $status);
        $excelData[] = $lineData;
    } 
}

//GENERATE REPORT BY SUPPLIER AND DATE SPAN
if($action == 2)
{
    $get_data = $report->generate_by_supp_treasury($from, $to, $supplier_id);
    while($row = $get_data->fetch(PDO::FETCH_ASSOC))
    {
        $check_date = date('m/d/y', strtotime($row['check_date'])); 
        $cv_num = $row['cv_no'];
        $received_date = date('m/d/y', strtotime($row['date_received_fo']));
        $due_date = date('m/d/y', strtotime($row['due_date']));
        $check_num = $row['check_no'];
        $amount = number_format(floatval($row['cv_amount']), 2);
        //date from other details
        $date_onhold = '-';
        $releasing_date = '-';
        if($row['date_on_hold'] != null || $row['date_on_hold'] != ''){
            $date_onhold = date('m/d/y', strtotime($row['date_on_hold']));
        }
        if($row['date_for_release'] != null || $row['date_for_release'] != ''){
            $releasing_date = date('m/d/y', strtotime($row['date_for_release']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['comp-id'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['comp-id']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supp-id'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supp-id']){
                $supp_name = $row3['supplier_name'];
            }
        }
        //status
        if($row['status'] == 3){
            $status = 'In Process';
        }elseif($row['status'] == 4){
            $status = 'Process by Back Office';
        }elseif($row['status'] == 5){
            $status = 'For Signature';
        }elseif($row['status'] == 6){
            $status = 'Sent To EA';
        }elseif($row['status'] == 7){
            $status = 'Signed by EXECOM';
        }elseif($row['status'] == 8){
            $status = 'Returned from EA';
        }elseif($row['status'] == 9){
            $status = 'On Hold/For Funding';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'For Releasing';
        }

        $lineData = array($check_date, $cv_num, $received_date, $due_date, $check_num, $supp_name, $comp_name, $amount, $date_onhold, $releasing_date, $status);
        $excelData[] = $lineData;     
    } 
}

//GENERATE REPORT BY SUPPLIER, COMPANY & DATE SPAN
if($action == 3)
{
    $get_data = $report->generate_all_treasury($from, $to, $comp_id, $supplier_id);
    while($row = $get_data->fetch(PDO::FETCH_ASSOC))
    {
        $check_date = date('m/d/y', strtotime($row['check_date'])); 
        $cv_num = $row['cv_no'];
        $received_date = date('m/d/y', strtotime($row['date_received_fo']));
        $due_date = date('m/d/y', strtotime($row['due_date']));
        $check_num = $row['check_no'];
        $amount = number_format(floatval($row['cv_amount']), 2);
        //date from other details
        $date_onhold = '-';
        $releasing_date = '-';
        if($row['date_on_hold'] != null || $row['date_on_hold'] != ''){
            $date_onhold = date('m/d/y', strtotime($row['date_on_hold']));
        }
        if($row['date_for_release'] != null || $row['date_for_release'] != ''){
            $releasing_date = date('m/d/y', strtotime($row['date_for_release']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['comp-id'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['comp-id']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supp-id'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supp-id']){
                $supp_name = $row3['supplier_name'];
            }
        }
        //status
        if($row['status'] == 3){
            $status = 'In Process';
        }elseif($row['status'] == 4){
            $status = 'Process by Back Office';
        }elseif($row['status'] == 5){
            $status = 'For Signature';
        }elseif($row['status'] == 6){
            $status = 'Sent To EA';
        }elseif($row['status'] == 7){
            $status = 'Signed by EXECOM';
        }elseif($row['status'] == 8){
            $status = 'Returned from EA';
        }elseif($row['status'] == 9){
            $status = 'On Hold/For Funding';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'For Releasing';
        }

        $lineData = array($check_date, $cv_num, $received_date, $due_date, $check_num, $supp_name, $comp_name, $amount, $date_onhold, $releasing_date, $status);
        $excelData[] = $lineData;    
    } 
}

//GENERATE BY DATE SPAN ONLY
if($action == 4)
{
    $get_data = $report->generate_by_date_treasury($from, $to);
    while($row = $get_data->fetch(PDO::FETCH_ASSOC))
    {
        $check_date = date('m/d/y', strtotime($row['check_date'])); 
        $cv_num = $row['cv_no'];
        $received_date = date('m/d/y', strtotime($row['date_received_fo']));
        $due_date = date('m/d/y', strtotime($row['due_date']));
        $check_num = $row['check_no'];
        $amount = number_format(floatval($row['cv_amount']), 2);
        //date from other details
        $date_onhold = '-';
        $releasing_date = '-';
        if($row['date_on_hold'] != null || $row['date_on_hold'] != ''){
            $date_onhold = date('m/d/y', strtotime($row['date_on_hold']));
        }
        if($row['date_for_release'] != null || $row['date_for_release'] != ''){
            $releasing_date = date('m/d/y', strtotime($row['date_for_release']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['comp-id'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['comp-id']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supp-id'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supp-id']){
                $supp_name = $row3['supplier_name'];
            }
        }
        //status
        if($row['status'] == 3){
            $status = 'In Process';
        }elseif($row['status'] == 4){
            $status = 'Process by Back Office';
        }elseif($row['status'] == 5){
            $status = 'For Signature';
        }elseif($row['status'] == 6){
            $status = 'Sent To EA';
        }elseif($row['status'] == 7){
            $status = 'Signed by EXECOM';
        }elseif($row['status'] == 8){
            $status = 'Returned from EA';
        }elseif($row['status'] == 9){
            $status = 'On Hold/For Funding';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'For Releasing';
        }

        $lineData = array($check_date, $cv_num, $received_date, $due_date, $check_num, $supp_name, $comp_name, $amount, $date_onhold, $releasing_date, $status);
        $excelData[] = $lineData;
    } 
}

//GENERATE BY COMPANY, STATUS AND DATE SPAN ONLY
if($action == 5)
{
    $get_data = $report->generate_report_treasury_5($comp_id, $stat_id, $from, $to);
    while($row = $get_data->fetch(PDO::FETCH_ASSOC))
    {
        $check_date = date('m/d/y', strtotime($row['check_date'])); 
        $cv_num = $row['cv_no'];
        $received_date = date('m/d/y', strtotime($row['date_received_fo']));
        $due_date = date('m/d/y', strtotime($row['due_date']));
        $check_num = $row['check_no'];
        $amount = number_format(floatval($row['cv_amount']), 2);
        //date from other details
        $date_onhold = '-';
        $releasing_date = '-';
        if($row['date_on_hold'] != null || $row['date_on_hold'] != ''){
            $date_onhold = date('m/d/y', strtotime($row['date_on_hold']));
        }
        if($row['date_for_release'] != null || $row['date_for_release'] != ''){
            $releasing_date = date('m/d/y', strtotime($row['date_for_release']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['comp-id'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['comp-id']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supp-id'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supp-id']){
                $supp_name = $row3['supplier_name'];
            }
        }
        //status
        if($row['status'] == 3){
            $status = 'In Process';
        }elseif($row['status'] == 4){
            $status = 'Process by Back Office';
        }elseif($row['status'] == 5){
            $status = 'For Signature';
        }elseif($row['status'] == 6){
            $status = 'Sent To EA';
        }elseif($row['status'] == 7){
            $status = 'Signed by EXECOM';
        }elseif($row['status'] == 8){
            $status = 'Returned from EA';
        }elseif($row['status'] == 9){
            $status = 'On Hold/For Funding';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'For Releasing';
        }

        $lineData = array($check_date, $cv_num, $received_date, $due_date, $check_num, $supp_name, $comp_name, $amount, $date_onhold, $releasing_date, $status);
        $excelData[] = $lineData;
    } 
}

//GENERATE BY SUPPLIER, STATUS AND DATE SPAN ONLY
if($action == 6)
{
    $get_data = $report->generate_report_treasury_6($supplier_id, $stat_id, $from, $to);
    while($row = $get_data->fetch(PDO::FETCH_ASSOC))
    {
        $check_date = date('m/d/y', strtotime($row['check_date'])); 
        $cv_num = $row['cv_no'];
        $received_date = date('m/d/y', strtotime($row['date_received_fo']));
        $due_date = date('m/d/y', strtotime($row['due_date']));
        $check_num = $row['check_no'];
        $amount = number_format(floatval($row['cv_amount']), 2);
        //date from other details
        $date_onhold = '-';
        $releasing_date = '-';
        if($row['date_on_hold'] != null || $row['date_on_hold'] != ''){
            $date_onhold = date('m/d/y', strtotime($row['date_on_hold']));
        }
        if($row['date_for_release'] != null || $row['date_for_release'] != ''){
            $releasing_date = date('m/d/y', strtotime($row['date_for_release']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['comp-id'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['comp-id']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supp-id'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supp-id']){
                $supp_name = $row3['supplier_name'];
            }
        }
        //status
        if($row['status'] == 3){
            $status = 'In Process';
        }elseif($row['status'] == 4){
            $status = 'Process by Back Office';
        }elseif($row['status'] == 5){
            $status = 'For Signature';
        }elseif($row['status'] == 6){
            $status = 'Sent To EA';
        }elseif($row['status'] == 7){
            $status = 'Signed by EXECOM';
        }elseif($row['status'] == 8){
            $status = 'Returned from EA';
        }elseif($row['status'] == 9){
            $status = 'On Hold/For Funding';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'For Releasing';
        }

        $lineData = array($check_date, $cv_num, $received_date, $due_date, $check_num, $supp_name, $comp_name, $amount, $date_onhold, $releasing_date, $status);
        $excelData[] = $lineData;
    } 
}

//GENERATE BY COMPANY, SUPPLIER, STATUS AND DATE SPAN
if($action == 7)
{
    $get_data = $report->generate_report_treasury_7($comp_id, $supplier_id, $stat_id, $from, $to);
    while($row = $get_data->fetch(PDO::FETCH_ASSOC))
    {
        $check_date = date('m/d/y', strtotime($row['check_date'])); 
        $cv_num = $row['cv_no'];
        $received_date = date('m/d/y', strtotime($row['date_received_fo']));
        $due_date = date('m/d/y', strtotime($row['due_date']));
        $check_num = $row['check_no'];
        $amount = number_format(floatval($row['cv_amount']), 2);
        //date from other details
        $date_onhold = '-';
        $releasing_date = '-';
        if($row['date_on_hold'] != null || $row['date_on_hold'] != ''){
            $date_onhold = date('m/d/y', strtotime($row['date_on_hold']));
        }
        if($row['date_for_release'] != null || $row['date_for_release'] != ''){
            $releasing_date = date('m/d/y', strtotime($row['date_for_release']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['comp-id'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['comp-id']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supp-id'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supp-id']){
                $supp_name = $row3['supplier_name'];
            }
        }
        //status
        if($row['status'] == 3){
            $status = 'In Process';
        }elseif($row['status'] == 4){
            $status = 'Process by Back Office';
        }elseif($row['status'] == 5){
            $status = 'For Signature';
        }elseif($row['status'] == 6){
            $status = 'Sent To EA';
        }elseif($row['status'] == 7){
            $status = 'Signed by EXECOM';
        }elseif($row['status'] == 8){
            $status = 'Returned from EA';
        }elseif($row['status'] == 9){
            $status = 'On Hold/For Funding';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'For Releasing';
        }

        $lineData = array($check_date, $cv_num, $received_date, $due_date, $check_num, $supp_name, $comp_name, $amount, $date_onhold, $releasing_date, $status);
        $excelData[] = $lineData;
    } 
}
//GENERATE BY STATUS AND DATE SPAN
if($action == 8)
{
    $get_data = $report->generate_report_treasury_8($stat_id, $from, $to);
    while($row = $get_data->fetch(PDO::FETCH_ASSOC))
    {
        $check_date = date('m/d/y', strtotime($row['check_date'])); 
        $cv_num = $row['cv_no'];
        $received_date = date('m/d/y', strtotime($row['date_received_fo']));
        $due_date = date('m/d/y', strtotime($row['due_date']));
        $check_num = $row['check_no'];
        $amount = number_format(floatval($row['cv_amount']), 2);
        //date from other details
        $date_onhold = '-';
        $releasing_date = '-';
        if($row['date_on_hold'] != null || $row['date_on_hold'] != ''){
            $date_onhold = date('m/d/y', strtotime($row['date_on_hold']));
        }
        if($row['date_for_release'] != null || $row['date_for_release'] != ''){
            $releasing_date = date('m/d/y', strtotime($row['date_for_release']));
        }
        //get the name of company
        $comp_name = '-';
        $company->id = $row['comp-id'];
        $get_comp = $company->get_company_detail();
        while($row1 = $get_comp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row1['id'] == $row['comp-id']){
                $comp_name = $row1['company'];
            }
        }
        //get the name of supplier
        $supp_name = '-';
        $supplier->id = $row['supp-id'];
        $get_supp = $supplier->get_supplier_details();
        while($row3 = $get_supp->fetch(PDO:: FETCH_ASSOC))
        {
            if($row3['id'] == $row['supp-id']){
                $supp_name = $row3['supplier_name'];
            }
        }
        //status
        if($row['status'] == 3){
            $status = 'In Process';
        }elseif($row['status'] == 4){
            $status = 'Process by Back Office';
        }elseif($row['status'] == 5){
            $status = 'For Signature';
        }elseif($row['status'] == 6){
            $status = 'Sent To EA';
        }elseif($row['status'] == 7){
            $status = 'Signed by EXECOM';
        }elseif($row['status'] == 8){
            $status = 'Returned from EA';
        }elseif($row['status'] == 9){
            $status = 'On Hold/For Funding';
        }else if($row['status'] == 15){
            $status = 'Forwarded to BO Cebu';
        }else if($row['status'] == 20){
            $status = 'Stale Check';
        }else{
            $status = 'For Releasing';
        }

        $lineData = array($check_date, $cv_num, $received_date, $due_date, $check_num, $supp_name, $comp_name, $amount, $date_onhold, $releasing_date, $status);
        $excelData[] = $lineData;
    } 
}
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName);
 
exit;

?>