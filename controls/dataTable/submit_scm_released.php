<?php
session_start();
if(!(isset($_SESSION['fullname'])))
{
  header('Location: ../../index.php');
}

include '../../config/clsConnection.php';
include '../../objects/clsSupplier.php';
include '../../objects/clsCompany.php';
include '../../objects/clsPODetails.php';
include '../../objects/clsDepartment.php';
include '../../objects/clsProject.php';
include '../../objects/clsUser.php';
include '../../objects/clsCheckDetails.php';

$database = new clsConnection();
$db = $database->connect();

$supplier = new Supplier($db);
$company = new Company($db);
$po = new PO_Details($db);
$dept = new Department($db);
$project = new Project($db);
$user = new Users($db);
$check_details = new CheckDetails($db);

//create column like in db
$columns = array(
    0 => 'po_details.id',
    1 => "CONCAT(users.firstname, ' ', users.lastname)",
    2 => 'project.project',
    3 => 'company.company',
    4 => 'po_details.si_no',
    5 => 'po_details.po_num',
    6 => 'supplier.supplier_name',
    7 => 'po_details.bill_date',
    8 => 'check_details.check_date',
    9 => 'check_details.check_no',
    10 => 'check_details.cv_amount',
    11 => 'check_details.tax',
    12 => 'po_other_details.date_to_ea'
);
$dept_id = $_SESSION['dept'];

//SEARCH
$sql = 'SELECT 
        po_details.id as "po-id", 
        po_details.po_num, 
        po_details.si_num, 
        po_details.bill_no, 
        po_details.bill_date, 
        po_details.amount, 
        po_details.status, 
        po_details.submitted_by, 
        project.project, 
        company.company, 
        supplier.supplier_name, 
        CONCAT(users.firstname, " ", users.lastname) as "fullname", 
        po_other_details.date_to_ea, 
        check_details.check_date, 
        check_details.check_no, 
        check_details.cv_amount, 
        check_details.tax 
        
        FROM po_details, po_other_details, check_details, project, company, supplier, users 
        
        WHERE po_details.submitted_by = users.id 
        AND users.dept = '.$dept_id.' AND po_details.project = project.id 
        AND po_details.company = company.id 
        AND po_details.supplier = supplier.id 
        AND po_details.id = po_other_details.po_id 
        AND check_details.po_id 
        
        LIKE po_details.id 
        AND po_details.status = 11 
        AND check_details.status != 0';

if(isset($_POST['search']['value'])){
    $search_val = $_POST['search']['value'];
    $sql .= " AND (po_details.status LIKE '%".$search_val."%'";
    $sql .= " OR CONCAT(users.firstname, ' ', users.lastname) LIKE '%".$search_val."%'";
    $sql .= " OR project.project LIKE '%".$search_val."%'";
    $sql .= " OR company.company LIKE '%".$search_val."%'";
    $sql .= " OR po_details.si_num LIKE '%".$search_val."%'";
    $sql .= " OR po_details.po_num LIKE '%".$search_val."%'";
    $sql .= " OR supplier.supplier_name LIKE '%".$search_val."%'";
    $sql .= " OR po_details.bill_date LIKE '%".$search_val."%'";
    $sql .= " OR check_details.check_date LIKE '%".$search_val."%'";
    $sql .= " OR check_details.check_no LIKE '%".$search_val."%'";
    $sql .= " OR check_details.cv_amount LIKE '%".$search_val."%'";
    $sql .= " OR check_details.tax LIKE '%".$search_val."%'";
    $sql .= " OR po_other_details.date_to_ea LIKE '%".$search_val."%')";
}
else
{
    $sql.= " AND po_details.id LIKE '%%'";
}
//rerun the sql query for search
$get_Total = $po->get_pending_po_details($sql);
$recordsFiltered = $get_Total->rowCount();

//ORDER
if(isset($_POST['order'])) {
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY ".$columns[$column_name]." ".$order." ";
} else {
    $sql .= " ORDER BY date_submit DESC";
}
//LIMIT
if (isset($_POST['length']) != '') {
    $start = $_POST['start'];
    $length = $_POST['length'];
    $sql .= " LIMIT " . $start . ", " . $length . " ";
}
//run again the sql for order
$get_Total = $po->get_pending_po_details($sql);

$output = array();
$data = array();
while($row = $get_Total->fetch(PDO:: FETCH_ASSOC))
{
    $proj_name = $row['project'];
    $comp_name = $row['company'];
    $sup_name = $row['supplier_name'];

    //date format
    $bill_date = date('m/d/y', strtotime($row['bill_date']));
    $check_date = date('m/d/y', strtotime($row['check_date']));
    $date_to_ea = date('m/d/y', strtotime($row['date_to_ea']));
    //get the date sent to EA
    $po->po_id = $row['po-id'];
    $get_date = $po->get_other_details();
    while($row2 = $get_date->fetch(PDO:: FETCH_ASSOC))
    {
        if($row2['date_to_ea'] != null){
            $date_ea = date('m/d/y', strtotime($row2['date_to_ea']));
        }else{
            $date_ea = '-';
        }
    }
    //get the check details
    $cv_amount = number_format($row['cv_amount'], 2);
    $tax = number_format($row['tax'], 2);
    //subdata for data
    $subdata = array();

    $subdata[] = '<input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'">';
    $subdata[] = $row['fullname'];
    $subdata[] = $proj_name;
    $subdata[] = $comp_name;
    $subdata[] = $row['si_num'];
    $subdata[] = $row['po_num'];
    $subdata[] = $sup_name;
    $subdata[] = $bill_date;
    $subdata[] = $check_date;
    $subdata[] = $row['check_no'];
    $subdata[] = $cv_amount;
    $subdata[] = $tax;
    $subdata[] = $date_ea;
    
    //data for output
    $data[] = $subdata;
}
$recordsTotal = $get_Total->rowCount();

//output
$output = array(
    'draw'              => $_POST['draw'],
    'recordsTotal'      => $recordsTotal,
    'recordsFiltered'   => $recordsFiltered,
    'data'              => $data
);
 //print_r($sql);
 //print_r($output);

echo json_encode($output);// JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE);
?>