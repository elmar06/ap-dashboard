<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$view = $po->get_list_for_ea();
while($row = $view->fetch(PDO::FETCH_ASSOC))
{
//format of status
if($row['status'] == 6)
{
    $status = '<label style="color: red"><b> For Signature</b></label>';
}
elseif($row['status'] == 7)
{
    $status = '<label style="color: green"><b> Signed</b></label>';
}
else
{
    $status = '<label style="color: green"><b> Returned</b></label>';
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
?>