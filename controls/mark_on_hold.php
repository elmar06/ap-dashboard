<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);

$po->status = 8;
$po->date_on_hold = date('Y-m-d');
$po->po_id = $_POST['id'];
$po->id = $_POST['id'];

$upd = $po->mark_on_hold();

if($upd)
{
    $po->submitted_by = $_SESSION['id'];
    $view = $po->get_return_from_ea();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {
      //format of status
      if($row['status'] == 7)
      {
          $status = '<label style="color: blue"><b> For Verification</b></label>';
      }
      elseif($row['status'] == 8)
      {
          $status = '<label style="color: red"><b> On Hold</b></label>';
      }
      else
      {
          $status = '<label style="color: green"><b> For Releasing</b></label>';
      }
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
}else{
    echo 0;
}
?>