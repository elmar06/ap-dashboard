<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCompany.php';
include '../objects/clsSupplier.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$supplier = new Supplier($db);

$get = $po->get_process_po();
while($row = $get->fetch(PDO::FETCH_ASSOC))
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
    //format of status
    if($row['status'] == 1){
      $status = '<label style="color: red"><b> Pending</b></label>';
    }else if($row['status'] == 2){
      $status = '<label style="color: orange"><b> Returned</b></label>';
    }elseif($row['status'] == 5){
      $status = '<label style="color: blue"><b> For Signature</b></label>';
    }elseif($row['status'] == 6){
      $status = '<label style="color: blue"><b> Sent to EA</b></label>';
    }elseif($row['status'] == 8){
      $status = '<label style="color: blue"><b> For Verification</b></label>';
    }elseif($row['status'] == 9){
      $status = '<label style="color: red"><b> On Hold</b></label>';
    }else if($row['status'] == 10){
      $status = '<label style="color: green"><b> For Releasing</b></label>';
    }else if($row['status'] == 11){
      $status = '<label style="color: green"><b> Released</b></label>';
    }else{
      $status = '<label style="color: blue"><b> In Process</b></label>';
    }
    $bill_date = date('m/d/Y', strtotime($row['bill_date']));
    echo '
    <tr>
        <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
        <td><center>'.$status.'</center></td>
        <td>'.$comp_name.'</td>
        <td>'.$row['po_num'].'</td>
        <td>'.$row['si_num'].'</td>
        <td>'.$sup_name.'</td>
        <td>'.$bill_date.'</td>
        <td>'.number_format(floatval($row['amount']), 2).'</td>                          
    </tr>';
}
?>