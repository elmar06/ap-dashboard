<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);

//get the user company access
$user_id = $_SESSION['id'];
$access->user_id = $user_id;
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
    $po->id = $comp_id;
    $view = $po->get_all_process_bo();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {
      //date format
      $bill_date = date('m/d/Y', strtotime($row['bill_date']));
      echo '
      <tr>
        <td style="max-width: 2%"><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
        <td style="max-width: 15%">'.$row['comp-name'].'</td>
        <td>'.$row['po_num'].'</td>
        <td>'.$row['supplier_name'].'</td>
        <td>'.$bill_date.'</td>
        <td>'.$row['fullname'].'</td>
        <td><center><a href="#" class="btn-sm btn-success edit" value="'.$row['po-id'].'"><i class="fas fa-edit"></i> Edit</a></center></td>
      </tr>';
    }  
  }
}
?>