<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

echo '
    <div class="row mb-3">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">For Signature</div>';
                    $count = $po->count_for_signature();
                    if($row = $count->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                    }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                    }
                    echo' <div class="mt-2 mb-0 text-muted text-xs">
                    <a class="text-success mr-2" href="#" onclick="get_for_signature()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-file-signature fa-2x text-danger"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!-- Received by Accounting Payable -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Signed</div>';                      
                    $count = $po->count_signed();
                    if($row = $count->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                    }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                    }                     
                    echo '<div class="mt-2 mb-0 text-muted text-xs">
                    <a class="text-success mr-2" href="#" onclick="get_signed()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-retweet fa-2x text-warning"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!-- Received by Accounting Payable -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Return to AP Team</div>';                  
                    $count = $po->count_return_from_ea();
                    if($row = $count->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                    }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                    }                     
                    echo '<div class="mt-2 mb-0 text-muted text-xs">
                    <a class="text-success mr-2" href="#" onclick="get_return_to_ap()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div> <!-- end of card row -->
        <div>
        <a id="btnSigned" type="button" class="btn btn-success mb-1" href="#" onclick="mark_signed()"><i class="fas fa-check-circle"></i> Mark as Signed</a>
        <a id="btnReturned" type="button" class="btn btn-primary mb-1" href="#" onclick="mark_returned()"><i class="fas fa-undo-alt"></i> Mark as Returned to AP</a>
        </div><br>
        <!-- DataTable with Hover -->
        <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="req-table">
                <thead class="thead-light">
                    <tr>
                    <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                    <th>CV No</th>
                    <th>Check No</th>
                    <th>Company</th>
                    <th>PO/JO No</th>
                    <th>Suppplier</th>
                    <th><center>Status</center></th>
                    </tr>
                </thead>
                <tbody id="req-body">';
                    $po->submitted_by = $_SESSION['id'];
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
                echo '</tbody>
                </table> 
            </div>
            </div>
        </div>
    </div>';
?>
<script>
$(document).ready(function () {
  $('#req-table').DataTable();// ID From dataTable with Hover
})
</script>