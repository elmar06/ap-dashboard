<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$status = $_POST['status'];
if($status == 5)//get for signature
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
            <td>'.$row['cv_no'].'</td>
            <td>'.$row['check_no'].'</td>
            <td>'.$row['comp-name'].'</td>
            <td>'.$row['po_num'].'</td>
            <td>'.$row['supplier_name'].'</td>
            <td><center>'.$status.'</center></td>
        </tr>';
    }
}
elseif($status == 6)//get request signed
{
    $po->status = $status;
    $view = $po->get_signed_ea();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {
        $status = '<label style="color: green"><b> Signed</b></label>';
        
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
            <td>'.$row['comp-name'].'</td>
            <td>'.$row['po_num'].'</td>
            <td>'.$row['supplier_name'].'</td>
            <td><center>'.$status.'</center></td>
        </tr>';
    }
}
?>