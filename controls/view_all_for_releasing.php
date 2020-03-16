<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$view = $po->get_for_releasing_fo();
while($row = $view->fetch(PDO::FETCH_ASSOC))
{                      
    //date format
    $bill_date = date('m/d/Y', strtotime($row['bill_date']));
    echo '
    <tr>
        <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
        <td>'.$row['comp-name'].'</td>
        <td>'.$row['po_num'].'</td>
        <td>'.$row['supplier_name'].'</td>
        <td>'.$bill_date.'</td>
        <td>'.$row['fullname'].'</td>
        <td>
        <center>
        <button class="btn btn-success btn-sm btnRelease" value="'.$row['po-id'].'"><i class="fas fa-check-circle"></i> Released</button>
        </center></td>
    </tr>';
}
?>