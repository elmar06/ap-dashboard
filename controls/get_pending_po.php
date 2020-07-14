<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$get = $po->get_pending_po();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
    $status = '<label style="color: red"><b> Pending</b></label>';
    $bill_date = date('m/d/Y', strtotime($row['bill_date']));
  echo '
  <tr>
    <td>'.$row['comp-name'].'</td>
    <td>'.$row['po_num'].'</td>
    <td>'.$row['bill_no'].'</td>
    <td>'.$row['supplier_name'].'</td>
    <td>'.$bill_date.'</td>
    <td><center>'.$status.'</center></td>
  </tr>';
}
?>