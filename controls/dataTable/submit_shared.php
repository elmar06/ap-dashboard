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
    0=> 'po_details.id',
    1 => 'project.project',
    2 => 'company.company',
    3 => 'po_details.po_num',    
    4 => 'supplier.supplier_name',
    5 => 'po_details.bill_date',
    6 => 'check_details.check_date',
    7 => 'check_details.check_no',
    8 => 'po_other_details.date_to_ea',
    9 => 'po_details.status'
);
//$dept_id = $_SESSION['dept'];

//SEARCH
$sql = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.bill_date, po_details.status, project.project, company.company, supplier.supplier_name, check_details.check_date, check_details.check_no, po_other_details.date_to_ea FROM po_details, project, company, supplier, check_details, po_other_details, users WHERE po_details.project = project.id AND po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.id = po_other_details.po_id AND check_details.po_id LIKE po_details.id AND po_details.remark = 1';
if(isset($_POST['search']['value'])){
    $search_val = $_POST['search']['value'];
    $sql .= " AND (po_details.po_num LIKE '%".$search_val."%'";
    $sql .= " OR project.project LIKE '%".$search_val."%'";
    $sql .= " OR company.company LIKE '%".$search_val."%'";
    $sql .= " OR supplier.supplier_name LIKE '%".$search_val."%'";
    $sql .= " OR po_details.bill_date LIKE '%".$search_val."%'";
    $sql .= " OR check_details.check_date LIKE '%".$search_val."%'";
    $sql .= " OR check_details.check_no LIKE '%".$search_val."%'";
    $sql .= " OR po_other_details.date_to_ea LIKE '%".$search_val."%'";
    $sql .= " OR po_details.status LIKE '%".$search_val."%')";
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
    $sql .= " ORDER BY po_details.date_submit DESC";
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

    //set the status of PO/JO
    //format of status
    if($row['status'] == 1){
    $status = '<label style="color: red"><b> Pending</b></label>';
    }else if($row['status'] == 2){
    $status = '<label style="color: orange"><b> Returned</b></label>';
    }elseif($row['status'] == 5){
    $status = '<label style="color: blue"><b> For Signature</b></label>';
    }elseif($row['status'] == 6){
    $status = '<label style="color: blue"><b> Sent to EA</b></label>';
    }elseif($row['status'] == 7){
    $status = '<label style="color: blue"><b> Signed</b></label>';
    }elseif($row['status'] == 8){
    $status = '<label style="color: blue"><b> For Verification</b></label>';
    }elseif($row['status'] == 15){
    $status = '<label style="color: blue"><b> Forwarded to Cebu</b></label>';
    }elseif($row['status'] == 20){
    $status = '<label style="color: red"><b> Staled Check</b></label>';
    }else{
    $status = '<label style="color: red"><b> On Hold</b></label>';
    }

    //subdata for data
    $subdata = array();
    $subdata[] = '<input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'">';
    $subdata[] = $proj_name;
    $subdata[] = $comp_name;
    $subdata[] = $row['po_num'];    
    $subdata[] = $sup_name;
    $subdata[] = $bill_date;
    $subdata[] = $check_date;
    $subdata[] = $row['check_no'];    
    $subdata[] = $date_to_ea;
    $subdata[] = $status;

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