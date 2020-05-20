<div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
    <div class="card-body">
        <div class="row align-items-center">
        <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">For BO Processing</div>
            <?php
            $po->submitted_by = $_SESSION['id'];
            $count = $po->count_for_process_bo();
            if($row = $count->fetch(PDO::FETCH_ASSOC))
            {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['pending-count'].'</div>';
            }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
            }
            ?>
            <div class="mt-2 mb-0 text-muted text-xs">
            <a class="text-success mr-2" href="process_po.php"><i class="fas fa-arrow-up"></i> More Details</a>
            </div>
        </div>
        <div class="col-auto">
            <i class="fas fa-file-contract fa-2x text-danger"></i>
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
            <div class="text-xs font-weight-bold text-uppercase mb-1">For Signature</div>
            <?php
            $po->submitted_by = $_SESSION['id'];
            $count = $po->count_return();
            if($row = $count->fetch(PDO::FETCH_ASSOC))
            {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['return-count'].'</div>';
            }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
            }
            ?>
            <div class="mt-2 mb-0 text-muted text-xs">
            <a class="text-success mr-2" href="#" onclick="get_returned_po()"><i class="fas fa-arrow-up"></i> More Details</a>
            </div>
        </div>
        <div class="col-auto">
            <i class="fas fa-file-signature fa-2x text-warning"></i>
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
            <div class="text-xs font-weight-bold text-uppercase mb-1">For Verification</div>
            <?php
            $po->submitted_by = $_SESSION['id'];
            $count = $po->count_on_process();
            if($row = $count->fetch(PDO::FETCH_ASSOC))
            {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['process-count'].'</div>';
            }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
            }
            ?>
            <div class="mt-2 mb-0 text-muted text-xs">
            <a class="text-success mr-2" href="#" onclick="get_process_po()"><i class="fas fa-arrow-up"></i> More Details</a>
            </div>
        </div>
        <div class="col-auto">
            <i class="fas fa-check-double fa-2x text-info"></i>
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
            <div class="text-xs font-weight-bold text-uppercase mb-1">For Releasing</div>
            <?php
            $po->submitted_by = $_SESSION['id'];
            $count = $po->count_releasing();
            if($row = $count->fetch(PDO::FETCH_ASSOC))
            {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['releasing-count'].'</div>';
            }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
            }
            ?>
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
</div>