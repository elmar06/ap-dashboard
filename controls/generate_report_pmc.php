<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCompany.php';
include '../objects/clsSupplier.php';
include '../objects/clsProject.php';
include '../objects/clsBank.php';
include '../objects/clsReport.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$project = new Project($db);
$supplier = new Supplier($db);
$bank = new Banks($db);
$report = new Reports($db);

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
$fileName = 'AP Dashboard - PMC Report'."'".'s Report.xls';
//1st row REPORT PAGE HEADER
$header1 = array('COMPANY', 'PROJECT', 'VENDOR', 'PO/JO #', 'SI NO', 'AMOUNT', 'DATE RECEIVED ACCT', 'FORWARD TO EA', 'RETURNED FROM EA', 'CV NO.', 'CHECK NO', 'CHECK DATE', 'TAX', 'CV AMOUNT', 'DATE RELEASE', 'STATUS');
//Display column names in a row 
$excelData = implode("\t", array_values($header1)) . "\n"; 

//GENERATE REPORT BY PROJECT & DATE SPAN
if($_GET['action'] == 1)
{   
    $get = $report->get_by_proj_date_pmc($proj, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $check_date = '-';
        $date_release = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['check_date'] != null){
            $check_date = date('m-d-Y', strtotime($row['check_date']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
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
        //get the bank name
        $bank_name = '-'; 
        $bank->id = $row['bank'];
        $get_bank = $bank->get_bank_details();
        while($row4 = $get_bank->fetch(PDO:: FETCH_ASSOC))
        {
            if($row4['id'] == $row['bank']){
                $bank_name = $row4['name'];
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
        }else{
            $status = 'Released';
        }
        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $row['amount'], $date_received_fo, $date_to_ea, $date_from_ea, $row['cv_no'], $row['check_no'], $check_date, $row['tax'], $row['cv_amount'], $date_release, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }  
}

//GENERATE REPORT BY COMPANY & DATE SPAN
if($_GET['action'] == 2)
{
    $get = $report->get_by_comp_date_pmc($comp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $check_date = '-';
        $date_release = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['check_date'] != null){
            $check_date = date('m-d-Y', strtotime($row['check_date']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
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
        //get the bank name
        $bank_name = '-'; 
        $bank->id = $row['bank'];
        $get_bank = $bank->get_bank_details();
        while($row4 = $get_bank->fetch(PDO:: FETCH_ASSOC))
        {
            if($row4['id'] == $row['bank']){
                $bank_name = $row4['name'];
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
        }else{
            $status = 'Released';
        }
        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $row['amount'], $date_received_fo, $date_to_ea, $date_from_ea, $row['cv_no'], $row['check_no'], $check_date, $row['tax'], $row['cv_amount'], $date_release, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }  
}

//GENERRATE REPORT BY SUPPLIER & DATE SPAN
if($_GET['action'] == 3)
{
    $get = $report->get_by_supp_date_pmc($supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $check_date = '-';
        $date_release = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['check_date'] != null){
            $check_date = date('m-d-Y', strtotime($row['check_date']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
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
        //get the bank name
        $bank_name = '-'; 
        $bank->id = $row['bank'];
        $get_bank = $bank->get_bank_details();
        while($row4 = $get_bank->fetch(PDO:: FETCH_ASSOC))
        {
            if($row4['id'] == $row['bank']){
                $bank_name = $row4['name'];
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
        }else{
            $status = 'Released';
        }
        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $row['amount'], $date_received_fo, $date_to_ea, $date_from_ea, $row['cv_no'], $row['check_no'], $check_date, $row['tax'], $row['cv_amount'], $date_release, $status);
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
        }else{
            $status = 'Released';
        }
        //get check details 
        $cv_no = '-';
        $bank_name = '-';
        $check_no = '-';
        $check_date = '-';
        $tax = '-';
        $cv_amount = '-';
        $check->id = $row['po-id'];
        $get_check = $check->get_details();
        while($row4 = $get_check->fetch(PDO:: FETCH_ASSOC))
        {
            $cv_no = $row4['cv_no'];
            $check_no = $row4['check_no'];
            $check_date = date('m-d-Y', strtotime($row4['check_date']));
            $tax = $row4['tax'];
            $cv_amount = $row4['cv_amount'];
            //get the bank name
            $bank->id = $row4['bank'];
            $get_bank = $bank->get_bank_details();
            while($row5 = $get_bank->fetch(PDO:: FETCH_ASSOC))
            {
                if($row5['id'] == $row4['bank']){
                    $bank_name = $row5['account'];
                }
            }
        }
        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $row['amount'], $date_received_fo, $date_to_ea, $date_from_ea, $cv_no, $bank_name, $check_no, $check_date, $tax, $cv_amount, $date_release, $row['fullname'], $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
}

//GENERATE REPORT BY PROJECT, COMPANY & DATE SPAN
if($_GET['action'] == 5)
{
    $get = $report->get_by_comp_proj_date_pmc($proj, $comp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $check_date = '-';
        $date_release = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['check_date'] != null){
            $check_date = date('m-d-Y', strtotime($row['check_date']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
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
        //get the bank name
        $bank_name = '-'; 
        $bank->id = $row['bank'];
        $get_bank = $bank->get_bank_details();
        while($row4 = $get_bank->fetch(PDO:: FETCH_ASSOC))
        {
            if($row4['id'] == $row['bank']){
                $bank_name = $row4['name'];
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
        }else{
            $status = 'Released';
        }
        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $row['amount'], $date_received_fo, $date_to_ea, $date_from_ea, $row['cv_no'], $row['check_no'], $check_date, $row['tax'], $row['cv_amount'], $date_release, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
}

//GENERATE REPORT BY PROJECT, COMPANY, SUPPLIER & DATE SPAN
if($_GET['action'] == 6)
{
    $get = $report->get_by_proj_comp_supp_date_pmc($proj, $comp, $supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $check_date = '-';
        $date_release = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['check_date'] != null){
            $check_date = date('m-d-Y', strtotime($row['check_date']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
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
        //get the bank name
        $bank_name = '-'; 
        $bank->id = $row['bank'];
        $get_bank = $bank->get_bank_details();
        while($row4 = $get_bank->fetch(PDO:: FETCH_ASSOC))
        {
            if($row4['id'] == $row['bank']){
                $bank_name = $row4['name'];
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
        }else{
            $status = 'Released';
        }
        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $row['amount'], $date_received_fo, $date_to_ea, $date_from_ea, $row['cv_no'], $bank_name, $row['check_no'], $check_date, $row['tax'], $row['cv_amount'], $date_release, $status);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
}

//GENERATE REPORT BY PROJECT, COMPANY, SUPPLIER, STATUS & DATE SPAN
if($_GET['action'] == 7)
{
    //check if status is in proces
    if($stat == 3){
        $get = $report->get_all_stat_date_pmc($proj, $comp, $supp, $stat, $from, $to);
    }else{
        $get = $report->get_all_date_pmc($proj, $comp, $supp, $stat, $from, $to);
    }    
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_received_fo = '-';
        $date_to_ea = '-';
        $date_from_ea = '-';
        $check_date = '-';
        $date_release = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['check_date'] != null){
            $check_date = date('m-d-Y', strtotime($row['check_date']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
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
        //get the bank name
        $bank_name = '-'; 
        $bank->id = $row['bank'];
        $get_bank = $bank->get_bank_details();
        while($row4 = $get_bank->fetch(PDO:: FETCH_ASSOC))
        {
            if($row4['id'] == $row['bank']){
                $bank_name = $row4['name'];
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
        }else{
            $status = 'Released';
        }
        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $row['amount'], $date_received_fo, $date_to_ea, $date_from_ea, $row['cv_no'], $row['check_no'], $check_date, $row['tax'], $row['cv_amount'], $date_release, $status);
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
        $check_date = '-';
        $date_release = '-';
        if($row['date_received_fo'] != null){
            $date_received_fo = date('m-d-Y', strtotime($row['date_received_fo']));
        }
        if($row['date_to_ea'] != null){
            $date_to_ea = date('m-d-Y', strtotime($row['date_to_ea']));
        }
        if($row['date_from_ea'] != null){
            $date_from_ea = date('m-d-Y', strtotime($row['date_from_ea']));
        }
        if($row['check_date'] != null){
            $check_date = date('m-d-Y', strtotime($row['check_date']));
        }
        if($row['date_release'] != null){
            $date_release = date('m-d-Y', strtotime($row['date_release']));
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
        //get the bank name
        $bank_name = '-'; 
        $bank->id = $row['bank'];
        $get_bank = $bank->get_bank_details();
        while($row4 = $get_bank->fetch(PDO:: FETCH_ASSOC))
        {
            if($row4['id'] == $row['bank']){
                $bank_name = $row4['name'];
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
        }else{
            $status = 'Released';
        }
        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['po_num'], $row['si_num'], $row['amount'], $date_received_fo, $date_to_ea, $date_from_ea, $row['cv_no'], $row['check_no'], $check_date, $row['tax'], $row['cv_amount'], $date_release, $status);
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