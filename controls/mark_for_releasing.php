<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);

$po->status = 9;
$po->date_for_release = date('Y-m-d');
$po->po_id = $_POST['id'];
$po->id = $_POST['id'];

$upd = $po->mark_for_release();

if($upd)
{
    $po->submitted_by = $_SESSION['id'];
    $view = $po->get_on_hold_check();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {
    $status = '<label style="color: red"><b> On Hold</b></label>';
    
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