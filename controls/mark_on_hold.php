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
$po->date_on_hold = date('Y-m-d');
$po->po_id = $_POST['id'];
$po->id = $_POST['id'];

$upd = $po->mark_on_hold();

if($upd)
{
    echo '
        <div class="row mb-3">
            <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">For Verification</div>';
                        $po->submitted_by = $_SESSION['id'];
                        $count = $po->count_for_verification();
                        if($row = $count->fetch(PDO::FETCH_ASSOC))
                        {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                        }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                    echo '<div class="mt-2 mb-0 text-muted text-xs">
                    <a class="text-success mr-2" href="#" onclick="get_pending_po()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-certificate fa-2x text-info"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <!-- For Releasing Card -->
            <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">On Hold</div>';
                        $po->submitted_by = $_SESSION['id'];
                        $count = $po->count_on_hold();
                        if($row = $count->fetch(PDO::FETCH_ASSOC))
                        {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                        }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                    echo '<div class="mt-2 mb-0 text-muted text-xs">
                    <a class="text-success mr-2" href="#" onclick="get_process_po()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-pause-circle fa-2x text-danger"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <!-- Total Submitted PO/JO Card-->
            <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">For Releasing</div>';
                        $po->submitted_by = $_SESSION['id'];
                        $count = $po->count_releasing();
                        if($row = $count->fetch(PDO::FETCH_ASSOC))
                        {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['releasing-count'].'</div>';
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
        </div> <!-- end of card row -->
        <div>
            <a type="button" class="btn btn-primary mb-1" href="#" onclick="mark_on_hold()"><i class="fas fa-hand-paper"></i> Hold Check</a>
            <a type="button" class="btn btn-success mb-1" href="#" onclick="mark_for_releasing()"><i class="fas fa-check-square"></i> Mark as for Releasing</a>
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
                    $view = $po->get_list_checker();
                    while($row = $view->fetch(PDO::FETCH_ASSOC))
                    {
                        //format of status
                        if($row['status'] == 8)
                        {
                            $status = '<label style="color: blue"><b> For Verification</b></label>';
                        }
                        elseif($row['status'] == 9)
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
                        <td style="width: 200px">'.$row['supplier_name'].'</td>
                        <td style="width: 120px"><center>'.$status.'</center></td>
                        </tr>';
                    }
                    echo '</tbody>
                </table> 
                </div>
            </div>
            </div><!-- /column -->
        </div><!-- /row -->';
}else{
    echo 0;
}
?>
<script>
$(document).ready(function () {
  $('#req-table').DataTable();// ID From dataTable with Hover
})
</script>