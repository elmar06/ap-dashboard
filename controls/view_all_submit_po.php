<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->submitted_by = $_SESSION['id'];
$view = $po->get_submitted_po_by_user();
while($row = $view->fetch(PDO::FETCH_ASSOC))
{
    //format of status
    if($row['status'] == 1)
    {
    $status = '<label style="color: red"><b> Pending</b></label>';
    }
    else if($row['status'] == 2)
    {
    $status = '<label style="color: orange"><b> Returned</b></label>';
    }
    else if($row['status'] == 8)
    {
    $status = '<label style="color: green"><b> For Releasing</b></label>';
    }
    else
    {
    $status = '<label style="color: blue"><b> On Process</b></label>';
    }
    //date format
    $bill_date = date('m/d/Y', strtotime($row['bill_date']));
    echo '
    <tr>
        <td hidden><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
        <td>'.$row['comp-name'].'</td>
        <td>'.$row['po_num'].'</td>
        <td>'.$row['bill_no'].'</td>
        <td>'.$row['supplier_name'].'</td>
        <td>'.$bill_date.'</td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td><center>'.$status.'</center></td>
    </tr>';
}

?>