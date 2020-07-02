<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->status = $_POST['stat'];
$get = $po->get_for_releasing_checker();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
    $status = '<label style="color: green"><b> For Releasing</b></label>';
  echo '
  <tr>
    <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
    <td>'.$row['cv_no'].'</td>
    <td>'.$row['check_no'].'</td>
    <td>'.$row['comp-name'].'</td>
    <td>'.$row['po_num'].'</td>
    <td>'.$row['supplier_name'].'</td>
    <td><center>'.$status.'</center></td>
  </tr>';
}
?>