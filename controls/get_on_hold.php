<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);
$supplier = new Supplier($db);
$company = new Company($db);

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
    $get = $po->get_on_hold_check();
    while($row = $get->fetch(PDO::FETCH_ASSOC))
    {
      $status = '<label style="color: red"><b>On Hold</b></label>';
      $bill_date = date('m/d/Y', strtotime($row['bill_date']));
      //get the COMPANY name if exist
      $company->id = $row['comp-id'];
      $get2 = $company->get_company_detail();
      while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
      {
        if($row['comp-id'] == $rowComp['id']){
          $comp_name = $rowComp['company'];
        }else{
          $comp_name = '-';
        }
      }
      //get the SUPPLIER name if exist
      $supplier->id = $row['supp-id'];
      $get3 = $supplier->get_supplier_details();
      while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
      {
        if($row['supp-id'] == $rowSupp['id']){
          $sup_name = $rowSupp['supplier_name'];
        }else{
          $sup_name = '-';
        }
      }
      echo '
      <tr>
        <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
        <td>'.$row['cv_no'].'</td>
        <td>'.$row['check_no'].'</td>
        <td>'.number_format($row['cv_amount'], 2).'</td>
        <td>'.$comp_name.'</td>
        <td>'.$row['po_num'].'</td>
        <td style="width: 180px">'.$sup_name.'</td>
        <td style="width: 95px"><center>'.$status.'</center></td>
      </tr>';
    }
  }
}
?>