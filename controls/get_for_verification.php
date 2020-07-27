<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$get = $po->get_on_hold_check();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
  $status = '<label style="color: blue"><b> On Hold</b></label>';
  $bill_date = date('m/d/Y', strtotime($row['bill_date']));
  echo '
  <tr>
    <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
    <td>'.$row['comp-name'].'</td>
    <td>'.$row['po_num'].'</td>
    <td>'.$row['supplier_name'].'</td>
    <td>'.$bill_date.'</td>    
    <td><center>'.$status.'</center></td>
  </tr>';
}
?>