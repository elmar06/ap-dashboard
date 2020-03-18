<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

echo '
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
    <div class="card-body">
        <div class="row align-items-center">
        <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Pending PO/JO</div>';
            $po->submitted_by = $_SESSION['id'];
            $count = $po->count_pending_by_user();
            if($row = $count->fetch(PDO::FETCH_ASSOC))
            {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['pending-count'].'</div>';
            }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
            }
            echo'
            <div class="mt-2 mb-0 text-muted text-xs">
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
<!-- Received by Accounting Payable -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
        <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Returned</div>';
            $po->submitted_by = $_SESSION['id'];
            $count = $po->count_return_by_user();
            if($row = $count->fetch(PDO::FETCH_ASSOC))
            {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['return-count'].'</div>';
            }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
            }
            echo'
            <div class="mt-2 mb-0 text-muted text-xs">
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
<!-- For Releasing Card -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
        <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">On Process</div>';
            $po->submitted_by = $_SESSION['id'];
            $count = $po->count_on_process_by_user();
            if($row = $count->fetch(PDO::FETCH_ASSOC))
            {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['process-count'].'</div>';
            }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
            }
            echo'
            <div class="mt-2 mb-0 text-muted text-xs">
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
<!-- Total Submitted PO/JO Card-->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
        <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">For Releasing</div>';
            $po->submitted_by = $_SESSION['id'];
            $count = $po->count_releasing_by_user();
            if($row = $count->fetch(PDO::FETCH_ASSOC))
            {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['releasing-count'].'</div>';
            }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
            }
            echo '
            <div class="mt-2 mb-0 text-muted text-xs">
            <a class="text-success mr-2" href="#" onclick="get_releasing_po()"><i class="fas fa-arrow-up"></i> More Details</a>
            </div>
        </div>
        <div class="col-auto">
            <i class="fas fa-check-circle fa-2x text-success"></i>
        </div>
        </div>
    </div>
    </div>
</div>';
?>