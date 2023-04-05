<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCompany.php';
include '../objects/clsSupplier.php';
include '../objects/clsProject.php';
include '../objects/clsReport.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$project = new Project($db);
$supplier = new Supplier($db);
$report = new Reports($db);

function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}

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
    $fileName = 'AP Dashboard Report(FO-For Releasing).xls';
    //1st column REPORT PAGE HEADER
    $header1 = array('INNOGROUP OF COMPANIES');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header1)) . "\n"; 
    $header2 = array('LIST OF CHECKS FOR RELEASE');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header2)) . "\n";
    //3rd column
    $header3 = array('PAYEE', 'COMPANY', 'PROJECT', 'CV NUMBER', 'CHECK NUMBER', 'AMOUNT');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header3)) . "\n";

    //GENERATE REPORT BY PROJECT & DATE SPAN
    if($_GET['rep_action'] == 1)
    {   
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
                    $supp_name = $row3['supplier_name'];
                }
            }
            $amount = number_format(floatval($row['cv_amount']), 2);
            //initialize data for excel
            $lineData = array($supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount);
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
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
                    $supp_name = $row3['supplier_name'];
                }
            }
            $amount = number_format(floatval($row['cv_amount']), 2);
            //initialize data for excel
            $lineData = array($supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount);
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
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
                    $supp_name = $row3['supplier_name'];
                }
            }
            $amount = number_format(floatval($row['cv_amount']), 2);
            //initialize data for excel
            $lineData = array($supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount);
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
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
                    $supp_name = $row3['supplier_name'];
                }
            }
            $amount = number_format(floatval($row['cv_amount']), 2);
            //initialize data for excel
            $lineData = array($supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount);
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
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
                    $supp_name = $row3['supplier_name'];
                }
            }
            $amount = number_format(floatval($row['cv_amount']), 2);
            //initialize data for excel
            $lineData = array($supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount);
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        }
    }

    //GENERATE REPORT BY PROJECT, COMPANY, SUPPLIER & DATE SPAN
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
                    $supp_name = $row3['supplier_name'];
                }
            }
            $amount = number_format(floatval($row['cv_amount']), 2);
            //initialize data for excel
            $lineData = array($supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount);
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
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
                    $supp_name = $row3['supplier_name'];
                }
            }
            $amount = number_format(floatval($row['cv_amount']), 2);
            //initialize data for excel
            $lineData = array($supp_name, $comp_name, $proj_name, $row['cv_no'], $row['check_no'], $amount);
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        }
    }
}
elseif($action == 2)//DISBURSEMENT REPORT
{
    // Excel file name for download 
    $fileName = 'AP Dashboard Report.xls';
    //1st column REPORT PAGE HEADER
    $header1 = array('INNOGROUP OF COMPANIES');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header1)) . "\n"; 
    //2nd column
    $header2 = array('DISBURSEMENT REPORT');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header2)) . "\n";
    //3rd column
    $header3 = array('COMPANY', 'PROJECT', 'VENDOR NAME', 'CV NUMBER', 'CHECK NUMBER', 'AMOUNT', 'DATE RELEASED', 'OR#/CR#');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header3)) . "\n";

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
else//PERCENTAGE REPORT
{
    // Excel file name for download 
    $fileName = 'AP Dashboard Percentage Report.xls';
    //1st column REPORT PAGE HEADER
    $header1 = array('INNDUCO PERCENTAGE REPORT');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header1)) . "\n"; 
    //2nd column
    $header2 = array('LIST OF CHECKS FOR RELEASE');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header2)) . "\n";
    //3rd column
    $header3 = array('COMPANY', 'PROJECT', 'PO AMOUNT', 'DATE RECEIVED BY ACCTG', 'CHECK DATE', 'CV NUMBER', 'BANK', 'CHECK NO', 'PO DATE', 'DUE DATE', 'PAYEE', 'MEMO', 'WITHHOLDING', 'CV AMOUNT', 'DATE FROM EA', 'DATE RELEASED', 'OR#/CR#',);   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header3)) . "\n";

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
        //date format
        $date_received_fo = date('m/d/Y', strtotime($row['date_received_fo']));
        $check_date = date('m/d/Y', strtotime($row['check_date']));
        $po_date = date('m/d/Y', strtotime($row['po_date']));
        $due_date = date('m/d/Y', strtotime($row['due_date']));
        $date_from_ea = '-';
        if($row['date_from_ea'] != null || $row['date_from_ea'] != ''){
            $date_from_ea = date('m/d/Y', strtotime($row['date_from_ea']));
        }
        $date_release = '-';
        if($row['date_release'] != null || $row['date_release'] != ''){
            $date_release = date('m/d/Y', strtotime($row['date_release']));
        }

        //initialize data for excel
        $lineData = array($comp_name, $proj_name, number_format($row['amount'], 2), $date_received_fo, $check_date, $row['cv_no'], $row['account'], $row['check_no'], $po_date, $due_date, $supp_name, $row['memo_no'], number_format($row['tax'], 2), number_format($row['cv_amount'], 2), $date_from_ea, $date_release, $row['or_num']);
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