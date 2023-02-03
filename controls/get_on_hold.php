<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';
include '../objects/clsProject.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);
$supplier = new Supplier($db);
$company = new Company($db);
$project = new Project($db);

//get the user company access
$access->user_id = $_SESSION['id'];
$get = $access->get_company();
while($row1 = $get->fetch(PDO::FETCH_ASSOC))
{
  //get the access company id
  $id = $row1['comp-access'];
  $array_id = explode(',', $id);
  foreach($array_id as $value)
  {
    $comp_id =  $value; 
    //display all the data by access
    $po->company = $comp_id;
    $view = $po->get_on_hold_check();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {
      //get the COMPANY name if exist
      $comp_name = '-';
      $company->id = $row['comp-id'];
      $get2 = $company->get_company_detail();
      while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
      {
        if($row['comp-id'] == $rowComp['id']){
          $comp_name = $rowComp['company'];
        }
      }
      //get the SUPPLIER name if exist
      $sup_name = '-';
      $supplier->id = $row['supp-id'];
      $get3 = $supplier->get_supplier_details();
      while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
      {
        if($row['supp-id'] == $rowSupp['id']){
          $sup_name = $rowSupp['supplier_name'];
        }
      }
      $proj_name = '';
      //get the PROJECT name if exist
      $project->id = $row['proj-id'];
      $get1 = $project->get_proj_details();
      while($rowProj = $get1->fetch(PDO::FETCH_ASSOC))
      {
        if($row['proj-id'] == $rowProj['id']){
          $proj_name = $rowProj['project'];
        }
      }
      //format of status
      if($row['status'] == 4){
        $status = '<label style="color: blue"><b>On Process by BO</b></label>';
      }elseif($row['status'] == 5){
        $status = '<label style="color: blue"><b>For Signature</b></label>';
      }elseif($row['status'] == 6){
        $status = '<label style="color: blue"><b>Sent To EA</b></label>';
      }elseif($row['status'] == 7){
        $status = '<label style="color: blue"><b>Signed</b></label>';
      }elseif($row['status'] == 8){
        $status = '<label style="color: blue"><b>For Verification</b></label>';
      }elseif($row['status'] == 9){
        $status = '<label style="color: red"><b>On Hold</b></label>';
      }else
      {
        $status = '<label style="color: green"><b>For Releasing</b></label>';
      }
      //date format
      $due = date('m/d/Y', strtotime($row['due_date']));
      if($row['date_received_fo'] != null || $row['date_received_fo'] != ''){
        $received_fo = date('m/d/Y', strtotime($row['date_received_fo']));
      }else{
        $received_fo = '-';
      }
      
      echo '
      <tr>
        <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
        <td style="width: 95px"><center>'.$status.'</center></td>
        <td>'.$row['cv_no'].'</td>
        <td>'.$row['check_no'].'</td>
        <td>'.number_format(floatval($row['cv_amount']), 2).'</td>
        <td>'.$comp_name.'</td>
        <td>'.$row['po_num'].'</td>
        <td style="width: 180px">'.$sup_name.'</td>
        <td>'.$due.'</td>
        <td>'.$received_fo.'</td>
        <td>'.$proj_name.'</td>
      </tr>';
    }
  }
}
?>