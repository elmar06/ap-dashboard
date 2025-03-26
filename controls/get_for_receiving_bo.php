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
    $view = $po->get_for_receiving_bo();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {
      //date format
      $bill_date = date('m/d/Y', strtotime($row['bill_date']));
      if($row['status'] == 3)
      {
        $action = '<a href="#" class="btn-sm btn-success btnReceived" onclick="mark_received_bo('.$row['po-id'].')"><i class="fas fa-hand-holding"></i> Received</a> <a href="#" class="btn-sm btn-danger return" value="' . $row['po-id'] . '"><i class="fas fa-undo-alt"></i> Return</a>';
      }else{
        $action = '<a href="#" class="btn-sm btn-primary edit" value="'.$row['po-id'].'"><i class="fas fa-edit"></i> Create CV</a>';
      }
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
      echo '
      <tr>
        <td style="max-width: 2%"><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
        <td><center>'.$action.'</center></td>
        <td style="max-width: 15%">'.$comp_name.'</td>
        <td>' . $row['po_num'] . '</td>
        <td>' . $row['si_num'] . '</td>
        <td>'.$sup_name.'</td>
        <td>'.$bill_date.'</td>
        <td>' . number_format(floatval($row['amount']), 2) . '</td>  
      </tr>';
    }  
  }
}
?>