<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCompany.php';
include '../objects/clsSupplier.php';
include '../objects/clsProject.php';
include '../objects/clsDepartment.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$project = new Project($db);
$supplier = new Supplier($db);
$dept = new Department($db);

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
$fileName = 'AP Dashboard Report.xls';
//1st column REPORT PAGE HEADER
$header1 = array('SUPPLIER', 'PO/JO #', 'PO Date', 'PO/CONTRACT AMOUNT', 'BILLING/SI DATE', 'SI #/TYPE OF BILLING', 'SI/BILLING AMOUNT', 'COMPANY', 'PROJECT', 'DEPARTMENT', 'TERMS', 'DUE DATE');
//Display column names as first row 
$excelData = implode("\t", array_values($header1)) . "\n"; 

if($from != null || $to != null){
    $get = $po->get_by_date_scm($from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $due_date = date('m-d-Y', strtotime($row['due_date']));
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
            if($row3['id'] == $row['supplier']){
                $supp_name = $row3['supplier_name'];
            }else{
                $supp_name = '';
            }
        }
        //get the name of department
        $dept->id = $row['department'];
        $get_dept = $dept->get_department_details();
        while($row4 = $get_dept->fetch(PDO:: FETCH_ASSOC))
        {
            if($row4['id'] == $row['department']){
                $dept_name = $row4['department'];
            }else{
                $dept_name = '';
            }
        }
        //initialize data for excel
        $lineData = array($supp_name, $row['po_num'], $row['si_num'], $row['amount'], $comp_name, $proj_name, $dept_name, $row['terms'], $due_date);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }   
}elseif($proj != null || $proj != ''){//GENERATE REPORT BY PROJECT & DATE SPAN
    $get = $po->get_by_proj_date_scm($proj, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $due_date = date('m-d-Y', strtotime($row['due_date']));
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
            if($row3['id'] == $row['supplier']){
                $supp_name = $row3['supplier_name'];
            }else{
                $supp_name = '';
            }
        }
        //get the name of department
        $dept->id = $row['department'];
        $get_dept = $dept->get_department_details();
        while($row4 = $get_dept->fetch(PDO:: FETCH_ASSOC))
        {
            if($row4['id'] == $row['department']){
                $dept_name = $row4['department'];
            }else{
                $dept_name = '';
            }
        }
        //initialize data for excel
        $lineData = array($supp_name, $row['po_num'], $row['si_num'], $row['amount'], $comp_name, $proj_name, $dept_name, $row['terms'], $due_date);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }  
}elseif($comp != null || $comp != ''){//GENERATE REPORT BY COMPANY & DATE SPAN
    $get = $po->get_by_comp_date_scm($comp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $due_date = date('m-d-Y', strtotime($row['due_date']));
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
            if($row3['id'] == $row['supplier']){
                $supp_name = $row3['supplier_name'];
            }else{
                $supp_name = '';
            }
        }
        //get the name of department
        $dept->id = $row['department'];
        $get_dept = $dept->get_department_details();
        while($row4 = $get_dept->fetch(PDO:: FETCH_ASSOC))
        {
            if($row4['id'] == $row['department']){
                $dept_name = $row4['department'];
            }else{
                $dept_name = '';
            }
        }
        //initialize data for excel
        $lineData = array($supp_name, $row['po_num'], $row['si_num'], $row['amount'], $comp_name, $proj_name, $dept_name, $row['terms'], $due_date);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }  
}elseif($supp != null || $supp != ''){//GENERATE SUPPLIER & DATE SPAN
    $get = $po->get_by_supp_date_scm($supp, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $due_date = date('m-d-Y', strtotime($row['due_date']));
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
            if($row3['id'] == $row['supplier']){
                $supp_name = $row3['supplier_name'];
            }else{
                $supp_name = '';
            }
        }
        //get the name of department
        $dept->id = $row['department'];
        $get_dept = $dept->get_department_details();
        while($row4 = $get_dept->fetch(PDO:: FETCH_ASSOC))
        {
            if($row4['id'] == $row['department']){
                $dept_name = $row4['department'];
            }else{
                $dept_name = '';
            }
        }
        //initialize data for excel
        $lineData = array($supp_name, $row['po_num'], $row['si_num'], $row['amount'], $comp_name, $proj_name, $dept_name, $row['terms'], $due_date);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
}elseif($stat != null || $stat != ''){//GENERATE REPORT BY STATUS & DATE SPAN
    $get = $po->get_by_stat_date_scm($stat, $from, $to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $due_date = date('m-d-Y', strtotime($row['due_date']));
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
            if($row3['id'] == $row['supplier']){
                $supp_name = $row3['supplier_name'];
            }else{
                $supp_name = '';
            }
        }
        //get the name of department
        $dept->id = $row['department'];
        $get_dept = $dept->get_department_details();
        while($row4 = $get_dept->fetch(PDO:: FETCH_ASSOC))
        {
            if($row4['id'] == $row['department']){
                $dept_name = $row4['department'];
            }else{
                $dept_name = '';
            }
        }
        //initialize data for excel
        $lineData = array($supp_name, $row['po_num'], $row['si_num'], $row['amount'], $comp_name, $proj_name, $dept_name, $row['terms'], $due_date);
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
}else{
    //initialize data for excel
    $lineData = array('NO DATA FOUND...');
    array_walk($lineData, 'filterData'); 
    $excelData .= implode("\t", array_values($lineData)) . "\n"; 
}

?>