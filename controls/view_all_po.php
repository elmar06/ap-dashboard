<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

echo '<div class="row mb-3">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Pending PO/JO</div>';
                    $count = $po->count_pending();
                    if($row2 = $count->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row2['pending-count'].'</div>';
                    }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                    }
                    echo '<div class="mt-2 mb-0 text-muted text-xs">
                    <a class="text-success mr-2" href="#" onclick="get_pending_po()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-times-circle fa-2x text-danger"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Returned</div>';
                    $count = $po->count_return();
                    if($row3 = $count->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row3['return-count'].'</div>';
                    }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                    }
                    echo '<div class="mt-2 mb-0 text-muted text-xs">
                    <a class="text-success mr-2" href="#" onclick="get_returned_po()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-retweet fa-2x text-warning"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">On Process</div>';
                    $count = $po->count_on_process();
                    if($row4 = $count->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row4['process-count'].'</div>';
                    }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                    }

                    echo '<div class="mt-2 mb-0 text-muted text-xs">
                    <a class="text-success mr-2" href="#" onclick="get_process_po()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-history fa-2x text-info"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">For Releasing</div>';
                    $count = $po->count_releasing();
                    if($row5 = $count->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row5['releasing-count'].'</div>';
                    }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                    }
                    echo '<div class="mt-2 mb-0 text-muted text-xs">
                    <a class="text-success mr-2" href="#" onclick="get_releasing_po()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="req-table">
                <thead class="thead-light">
                    <tr>
                    <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                    <th>Company</th>
                    <th>PO/JO No</th>
                    <th>Supplier</th>
                    <th>Billing Date</th>
                    <th>Submitted By</th>
                    <th>Status</th>
                    </tr>
                </thead>
                <tbody id="req-body">';
                    $view = $po->get_submitted_po_acc();
                    while($row6 = $view->fetch(PDO::FETCH_ASSOC))
                    {
                        //format of status
                        if($row6['status'] == 1)
                        {
                        $status = '<label style="color: red"><b> Pending</b></label>';
                        }
                        else if($row6['status'] == 2)
                        {
                        $status = '<label style="color: orange"><b> Returned</b></label>';
                        }
                        else if($row6['status'] == 9)
                        {
                        $status = '<label style="color: orange"><b> On Hold</b></label>';
                        }
                        else
                        {
                        $status = '<label style="color: blue"><b> On Process</b></label>';
                        }
                    //date format
                    $bill_date = date('m/d/Y', strtotime($row6['bill_date']));
                    echo '
                    <tr>
                        <td><input type="checkbox" name="checklist" class="checklist" value="'.$row6['po-id'].'"></td>
                        <td>'.$row6['comp-name'].'</td>
                        <td>'.$row6['po_num'].'</td>
                        <td>'.$row6['supplier_name'].'</td>
                        <td>'.$bill_date.'</td>
                        <td>'.$row6['fullname'].'</td>
                        <td><center>'.$status.'</center></td>
                    </tr>';
                    }
                echo '</tbody>
                </table> 
            </div>
            </div>
        </div><!-- /column -->
        </div>';
?>

<!-- Page level custom scripts -->
<script>
$(document).ready(function () {
  $('#dataTable').DataTable(); // ID From dataTable 
  $('#req-table').DataTable(); // ID From dataTable with Hover
})