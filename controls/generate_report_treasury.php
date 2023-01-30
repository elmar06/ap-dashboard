<?php
include '../config/clsConnection.php';
include '../objects/clsReport.php';

$database = new clsConnection();
$db = $database->connect();

$report = new Reports($db);

function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}

//initialize data
$comp_id  = $_GET['company'];
$supplier_id = $_GET['supplier'];
$from = date('Y-m-d', strtotime($_GET['date_from']));
$to = date('Y-m-d', strtotime($_GET['date_to']));
$action = $_GET['action'];

// Excel file name for download 
$fileName = 'Treasury Report('.date('m-d-Y', strtotime($from)).' - '.date('m-d-Y', strtotime($to)).').xls';
// 1st Column names 
$header = array('CHECK DATE', 'CV NUMBER', 'DATE RECEIVED', 'DUE DATE', 'CHECK NUMBER', 'SUPPLIER', 'AMOUNT');
// Display column names as first row 
$excelData = implode("\t", array_values($header)) . "\n"; 

//GENERATE REPORT BY DATE AND COMPANY
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
        $payee = $row['supplier_name'];
        $amount = number_format(floatval($row['cv_amount']), 2);

        $lineData = array($check_date, $cv_num, $received_date, $due_date, $check_num, $payee, $amount);
        //encode data in excel
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}

//GENERATE REPORT BY SUPPLIER
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
        $payee = $row['supplier_name'];
        $amount = number_format(floatval($row['cv_amount']), 2);

        $lineData = array($check_date, $cv_num, $received_date, $due_date, $check_num, $payee, $amount);
        //encode data in excel
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n";       
    } 
}

//GENERATE REPORT BY SUPPLIER & COMPANY
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
        $payee = $row['supplier_name'];
        $amount = number_format(floatval($row['cv_amount']), 2);

        $lineData = array($check_date, $cv_num, $received_date, $due_date, $check_num, $payee, $amount);
        //encode data in excel
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n";        
    } 
   
}

//GENERATE BY DATE ONLY
if($action == 4)
{
    $get_data = $report->generate_by_date_treasury($from, $to);
    while($row = $get_data->fetch(PDO::FETCH_ASSOC))
    {
        $check_date = date('m/d/Y', strtotime($row['check_date'])); 
        $cv_num = $row['cv_no'];
        $received_date = date('m/d/Y', strtotime($row['date_received_fo']));
        $due_date = date('m/d/Y', strtotime($row['due_date']));
        $check_num = $row['check_no'];
        $payee = $row['supplier_name'];
        $amount = number_format(floatval($row['cv_amount']), 2);

        $lineData = array($check_date, $cv_num, $received_date, $due_date, $check_num, $payee, $amount);
        //encode data in excel
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