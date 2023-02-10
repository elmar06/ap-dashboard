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

$status = $_POST['status'];
if($status == 5)//get for signature
{
    $po->status = $status;
    $view = $po->get_for_receiving_ea();
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
        //initialize action
        $action = '<button class="btn-sm btn-success mb-1 btnReceived" type="button" value="'.$row['po-id'].'"><i class="fas fa-hand-holding"></i> Received</button>';                              
        echo '
        <tr>
          <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
          <td style="width: 95px"><center>'.$action.'</center></td>
          <td>'.$row['cv_no'].'</td>
          <td>'.$row['check_no'].'</td>
          <td>'.number_format(floatval($row['cv_amount']),2).'</td>
          <td style="width: 180px">'.$sup_name.'</td>  
          <td>'.$comp_name.'</td>
          <td>'.$row['po_num'].'</td>                                                             
        </tr>';
      }
}
elseif($status == 6)//get for signature
{
    $po->status = $status;
    $view = $po->get_for_signature_ea();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {
        //format of status
        $status = '<label style="color: red"><b> For Signature</b></label>';

        echo '
        <tr>
            <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
            <td><center>'.$status.'</center></td>
            <td>'.$row['cv_no'].'</td>
            <td>'.$row['check_no'].'</td>
            <td>'.number_format($row['cv_amount'], 2).'</td>
            <td>'.$row['comp-name'].'</td>
            <td>'.$row['po_num'].'</td>
            <td>'.$row['supplier_name'].'</td>            
        </tr>';
    }
}
elseif($status == 7)//get request signed
{
    $po->status = $status;
    $view = $po->get_signed_ea();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {
        $status = '<label style="color: green"><b> Signed</b></label>';
        
        echo '
        <tr>
            <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
            <td><center>'.$status.'</center></td>
            <td>'.$row['cv_no'].'</td>
            <td>'.$row['check_no'].'</td>
            <td>'.number_format($row['cv_amount'], 2).'</td>
            <td>'.$row['comp-name'].'</td>
            <td>'.$row['po_num'].'</td>
            <td>'.$row['supplier_name'].'</td>            
        </tr>';
    }
}
else//get returned check to AP Team
{
    $po->status = $status;
    $view = $po->get_return_from_ea();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {
        //format of status
        $status = '<label style="color: green"><b> Returned</b></label>';

        echo '
        <tr>
            <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
            <td>'.$row['cv_no'].'</td>
            <td>'.$row['check_no'].'</td>
            <td>'.number_format($row['cv_amount'], 2).'</td>
            <td>'.$row['comp-name'].'</td>
            <td>'.$row['po_num'].'</td>
            <td>'.$row['supplier_name'].'</td>
            <td><center>'.$status.'</center></td>
        </tr>';
    }
}
?>