<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCompany.php';
include '../objects/clsSupplier.php';
include '../objects/clsProject.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$project = new Project($db);
$supplier = new Supplier($db);

function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}

//initialize variable
$date_from = date('Y-m-d', strtotime($_GET['date_from']));
$date_to = date('Y-m-d', strtotime($_GET['date_to']));
$action = $_GET['action'];

if($action == 1)//CHECK FOR RELEASE
{
    //other details initialize
    $proj = $_GET['project'];
    $comp = $_GET['company'];
    $supp = $_GET['supplier'];
    $status = $_GET['status'];
    $requestor = $_GET['requestor'];    
    //generate report by COMPANY
    if($comp != null || $comp != '')
    {
        //check if date is null/empty
        if($date_from != null && $date_to != null)
        {
            //check if project is null/empty
            if($proj != null || $proj != '')
            {
                //check if supplier is null/empty
                if($supp != null || $supp != '')
                {
                    //GENERATE BY COMPANY, DATE SPAN, PROJECT & SUPPLIER
                    // Excel file name for download 
                    $fileName = 'AP Dashboard Report.xls';
                    //1st column REPORT PAGE HEADER
                    $header1 = array('INNOGROUP OF COMPANIES');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header1)) . "\n"; 
                    $header2 = array('LIST OF CHECKS FOR RELEASE');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header2)) . "\n";
                    //3rd column
                    $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header3)) . "\n";

                    $get = $po->get_check_for_release_by_comp_proj_sup_date($comp, $proj, $supp, $date_from, $date_to);
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
                        //initialize data for excel
                        $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
                        array_walk($lineData, 'filterData'); 
                        $excelData .= implode("\t", array_values($lineData)) . "\n";                
                    } 
                }   
                else
                {
                    //GENERATE BY COMPANY, DATE SPAN & PROJECT
                    // Excel file name for download 
                    $fileName = 'AP Dashboard Report.xls';
                    //1st column REPORT PAGE HEADER
                    $header1 = array('INNOGROUP OF COMPANIES');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header1)) . "\n"; 
                    $header2 = array('LIST OF CHECKS FOR RELEASE');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header2)) . "\n";
                    //3rd column
                    $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header3)) . "\n";

                    $get = $po->get_check_for_release_by_comp_proj_date($comp, $proj, $date_from, $date_to);
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
                        //initialize data for excel
                        $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
                        array_walk($lineData, 'filterData'); 
                        $excelData .= implode("\t", array_values($lineData)) . "\n";                
                    } 
                }
            }
            else
            {
                //GENERATE BY COMPANY & DATE
                // Excel file name for download 
                $fileName = 'AP Dashboard Report.xls';
                //1st column REPORT PAGE HEADER
                $header1 = array('INNOGROUP OF COMPANIES');   
                //Display column names as first row 
                $excelData = implode("\t", array_values($header1)) . "\n"; 
                $header2 = array('LIST OF CHECKS FOR RELEASE');   
                //Display column names as first row 
                $excelData = implode("\t", array_values($header2)) . "\n";
                //3rd column
                $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
                //Display column names as first row 
                $excelData = implode("\t", array_values($header3)) . "\n";

                $get = $po->get_check_for_release_by_comp_date($comp, $date_from, $date_to);
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
                    //initialize data for excel
                    $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
                    array_walk($lineData, 'filterData'); 
                    $excelData .= implode("\t", array_values($lineData)) . "\n";                
                }
            }
        }
        else
        {
            //GENERATE BY COMPANY ONLY
            // Excel file name for download 
            $fileName = 'AP Dashboard Report.xls';
            //1st column REPORT PAGE HEADER
            $header1 = array('INNOGROUP OF COMPANIES');   
            //Display column names as first row 
            $excelData = implode("\t", array_values($header1)) . "\n"; 
            $header2 = array('LIST OF CHECKS FOR RELEASE');   
            //Display column names as first row 
            $excelData = implode("\t", array_values($header2)) . "\n";
            //3rd column
            $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
            //Display column names as first row 
            $excelData = implode("\t", array_values($header3)) . "\n";

            $company->company = $comp;
            $get = $po->get_check_for_release_by_comp();
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
                //initialize data for excel
                $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
                array_walk($lineData, 'filterData'); 
                $excelData .= implode("\t", array_values($lineData)) . "\n";                
            }
        }
    }
    //generate report by PROJECT
    if($project != null || $project != '')
    {
        //check if date is null/empty
        if($date_from != null && $date_to != null)
        {
            //check if company is null/empty
            if($comp != null || $comp != '')
            {
                //check if supplier is null/empty
                if($supp != null || $supp != '')
                {
                    //GENERATE BY COMPANY, DATE SPAN, PROJECT & SUPPLIER
                    // Excel file name for download 
                    $fileName = 'AP Dashboard Report.xls';
                    //1st column REPORT PAGE HEADER
                    $header1 = array('INNOGROUP OF COMPANIES');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header1)) . "\n"; 
                    $header2 = array('LIST OF CHECKS FOR RELEASE');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header2)) . "\n";
                    //3rd column
                    $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header3)) . "\n";

                    $get = $po->get_check_for_release_by_comp_proj_sup_date($comp, $proj, $supp, $date_from, $date_to);
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
                        //initialize data for excel
                        $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
                        array_walk($lineData, 'filterData'); 
                        $excelData .= implode("\t", array_values($lineData)) . "\n";                
                    } 
                }
                else
                {
                    //GENERATE BY COMPANY, DATE SPAN & PROJECT
                    // Excel file name for download 
                    $fileName = 'AP Dashboard Report.xls';
                    //1st column REPORT PAGE HEADER
                    $header1 = array('INNOGROUP OF COMPANIES');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header1)) . "\n"; 
                    $header2 = array('LIST OF CHECKS FOR RELEASE');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header2)) . "\n";
                    //3rd column
                    $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header3)) . "\n";

                    $get = $po->get_check_for_release_by_comp_proj_date($comp, $proj, $date_from, $date_to);
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
                        //initialize data for excel
                        $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
                        array_walk($lineData, 'filterData'); 
                        $excelData .= implode("\t", array_values($lineData)) . "\n";                
                    } 
                }
            }
            else
            {
                // Excel file name for download 
                $fileName = 'AP Dashboard Report.xls';
                //1st column REPORT PAGE HEADER
                $header1 = array('INNOGROUP OF COMPANIES');   
                //Display column names as first row 
                $excelData = implode("\t", array_values($header1)) . "\n"; 
                $header2 = array('LIST OF CHECKS FOR RELEASE');   
                //Display column names as first row 
                $excelData = implode("\t", array_values($header2)) . "\n";
                //3rd column
                $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
                //Display column names as first row 
                $excelData = implode("\t", array_values($header3)) . "\n";

                $get = $po->get_check_for_release_by_comp_proj_date($comp, $proj, $date_from, $date_to);
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
                    //initialize data for excel
                    $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
                    array_walk($lineData, 'filterData'); 
                    $excelData .= implode("\t", array_values($lineData)) . "\n";                
                }
            }
        }
        else
        {
            //GENERATE BY PROJECT ONLY
            // Excel file name for download 
            $fileName = 'AP Dashboard Report.xls';
            //1st column REPORT PAGE HEADER
            $header1 = array('INNOGROUP OF COMPANIES');   
            //Display column names as first row 
            $excelData = implode("\t", array_values($header1)) . "\n"; 
            $header2 = array('LIST OF CHECKS FOR RELEASE');   
            //Display column names as first row 
            $excelData = implode("\t", array_values($header2)) . "\n";
            //3rd column
            $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
            //Display column names as first row 
            $excelData = implode("\t", array_values($header3)) . "\n";

            $company->project = $project;
            $get = $po->get_check_for_release_by_proj();
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
                //initialize data for excel
                $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
                array_walk($lineData, 'filterData'); 
                $excelData .= implode("\t", array_values($lineData)) . "\n";                
            }
        }
    }
    //generate report by SUPPLIER
    if($supp != null || $supp != '')
    {
        //check if date is null/empty
        if($date_from != null && $date_to != null)
        {
            if($comp != null || $comp != '')
            {
                if($project != null || $project != '')
                {
                    //GENERATE BY SUPPLIER, DATE SPAN, COMPANY & PROJECT
                    // Excel file name for download 
                    $fileName = 'AP Dashboard Report.xls';
                    //1st column REPORT PAGE HEADER
                    $header1 = array('INNOGROUP OF COMPANIES');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header1)) . "\n"; 
                    $header2 = array('LIST OF CHECKS FOR RELEASE');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header2)) . "\n";
                    //3rd column
                    $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header3)) . "\n";

                    $get = $po->get_check_for_release_by_comp_proj_sup_date($comp, $proj, $supp, $date_from, $date_to);
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
                        //initialize data for excel
                        $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
                        array_walk($lineData, 'filterData'); 
                        $excelData .= implode("\t", array_values($lineData)) . "\n";                
                    }
                }
                else
                {
                    //GENERATE BY SUPPLIER, DATE SPAN & COMPANY
                    // Excel file name for download 
                    $fileName = 'AP Dashboard Report.xls';
                    //1st column REPORT PAGE HEADER
                    $header1 = array('INNOGROUP OF COMPANIES');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header1)) . "\n"; 
                    $header2 = array('LIST OF CHECKS FOR RELEASE');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header2)) . "\n";
                    //3rd column
                    $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
                    //Display column names as first row 
                    $excelData = implode("\t", array_values($header3)) . "\n";

                    $get = $po->get_check_for_release_by_sup_comp_date($supp, $comp, $date_from, $date_to);
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
                        //initialize data for excel
                        $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
                        array_walk($lineData, 'filterData'); 
                        $excelData .= implode("\t", array_values($lineData)) . "\n";                
                    }
                }
            }
            else
            {
                //GENERATE BY SUPPLIER & DATE SPAN
                // Excel file name for download 
                $fileName = 'AP Dashboard Report.xls';
                //1st column REPORT PAGE HEADER
                $header1 = array('INNOGROUP OF COMPANIES');   
                //Display column names as first row 
                $excelData = implode("\t", array_values($header1)) . "\n"; 
                $header2 = array('LIST OF CHECKS FOR RELEASE');   
                //Display column names as first row 
                $excelData = implode("\t", array_values($header2)) . "\n";
                //3rd column
                $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
                //Display column names as first row 
                $excelData = implode("\t", array_values($header3)) . "\n";

                $get = $po->get_check_for_release_by_sup_date($supp, $date_from, $date_to);
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
                    //initialize data for excel
                    $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
                    array_walk($lineData, 'filterData'); 
                    $excelData .= implode("\t", array_values($lineData)) . "\n";                
                }
            }
        }
        else
        {
            //GENERATE BY SUPPLIER ONLY
            // Excel file name for download 
            $fileName = 'AP Dashboard Report.xls';
            //1st column REPORT PAGE HEADER
            $header1 = array('INNOGROUP OF COMPANIES');   
            //Display column names as first row 
            $excelData = implode("\t", array_values($header1)) . "\n"; 
            $header2 = array('LIST OF CHECKS FOR RELEASE');   
            //Display column names as first row 
            $excelData = implode("\t", array_values($header2)) . "\n";
            $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
            //Display column names as first row 
            $excelData = implode("\t", array_values($header3)) . "\n";

            $supplier->supplier = $supplier;
            $get = $po->get_check_for_release_by_sup();
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
                //initialize data for excel
                $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
                array_walk($lineData, 'filterData'); 
                $excelData .= implode("\t", array_values($lineData)) . "\n";                
            }
        }
    }
    //generate report by DATE SPAN
    if($date_from != null && $date_to != null)
    {
        // Excel file name for download 
        $fileName = 'AP Dashboard Report.xls';
        //1st column REPORT PAGE HEADER
        $header1 = array('INNOGROUP OF COMPANIES');   
        //Display column names as first row 
        $excelData = implode("\t", array_values($header1)) . "\n"; 
        $header2 = array('LIST OF CHECKS FOR RELEASE');   
        //Display column names as first row 
        $excelData = implode("\t", array_values($header2)) . "\n";
        //3rd column
        $header3 = array('COMPANY', 'PROJECT', 'VENDOR', 'CHECK NUMBER', 'AMOUNT');   
        //Display column names as first row 
        $excelData = implode("\t", array_values($header3)) . "\n";

        $get = $po->get_check_for_release_by_date($date_from, $date_to);
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
            //initialize data for excel
            $lineData = array($comp_name, $proj_name, $supp_name, $row['check_no'], $row['amount']);
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n";                
        }
    }
}
else//DISBURSEMENT REPORT
{
    // Excel file name for download 
    $fileName = 'AP Dashboard Report.xls';
    //1st column REPORT PAGE HEADER
    $header1 = array('INNOGROUP OF COMPANIES');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header1)) . "\n"; 
    //2nd column
    $header2 = array('LIST OF CHECKS FOR RELEASE');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header2)) . "\n";
    //3rd column
    $header3 = array('COMPANY', 'PROJECT', 'VENDOR NAME', 'CV NUMBER', 'CHECK NUMBER', 'AMOUNT', 'OR#/CR#');   
    //Display column names as first row 
    $excelData = implode("\t", array_values($header3)) . "\n";

    $get = $po->get_disbursement_by_date($date_from, $date_to);
    while($row = $get->fetch(PDO:: FETCH_ASSOC))
    {
        $date_release = date('m-d-Y', strtotime($_POST['date_release']));
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
        //initialize data for excel
        $lineData = array($comp_name, $proj_name, $supp_name, $row['cv_no'], $row['check_no'], $row['amount'], $date_release, $row['or_num']);
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