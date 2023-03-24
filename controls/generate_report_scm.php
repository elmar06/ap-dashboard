<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCompany.php';
include '../objects/clsSupplier.php';
include '../objects/clsProject.php';
include '../objects/clsBank.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$project = new Project($db);
$supplier = new Supplier($db);
$bank = new Banks($db);

function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}
//initialize data
$from = date('Y-m-d', strtotime($_GET['date_from']));
$to = date('Y-m-d', strtotime($_GET['date_to']));
// Excel file name for download 
$fileName = 'Disbursement Report(SCM/PMC).xls';
//1st row REPORT PAGE HEADER
$header1 = array('VENDOR NAME', 'PO/JO #', 'MEMO #', 'SI #', 'AMOUNT', 'CHECK #', 'CV AMOUNT', 'TAX', 'DATE RELEASE');
$excelData = implode("\t", array_values($header1)) . "\n"; 

//GENERATE REPORT BY DATE SPAN
if($_GET['action'] == 1)
{
    $get = $po->get_disbursement_scm($from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_release = '-';
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
        //initialize data for excel
        $lineData = array($supp_name, $row['po_num'], $row['memo_no'], $row['si_num'], $row['amount'], $row['check_no'], $row['cv_amount'], $row['tax'], $date_release);
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