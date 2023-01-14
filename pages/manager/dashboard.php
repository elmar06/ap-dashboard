<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../../assets/img/logo/logo.png" rel="icon">
  <title>AP Dashboard</title>
  <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/datetimepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
  <link href="../../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../../assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/manager.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Purchasing</a></li>
              <li class="breadcrumb-item active" aria-current="page">Manager's Dashboard</li>
            </ol>
          </div><!-- /Breadcrumbs -->

          <!-- Cards -->
          <!-- Pending Card -->
          <div class="row mb-3">
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Pending PO/JO</div>
                      <?php
                        $po->submitted_by = $_SESSION['id'];
                        $count = $po->count_pending();
                        if($row = $count->fetch(PDO::FETCH_ASSOC))
                        {
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['pending-count'].'</div>';
                        }else{
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                      ?>
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
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Returned</div>
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
                      <div class="text-xs font-weight-bold text-uppercase mb-1">On Process</div>
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
          </div> <!-- end of card row -->
          <!-- Add/Submit a new PO/JO button -->
          <div id="req-btn" class="row mb-3">
            <div class="col-md-12">
              <button type="button" class="btn btn-danger" id="btnClear" style="display: none" onclick="clear_list()"> Clear Search</button>
            </div>
          </div>
          <div id="req-list" class="row mb-3">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table id="submitted-table" class="table align-items-center table-flush table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                        <th>Company</th>
                        <th>PO/JO No</th>
                        <th>SI No</th>
                        <th>Supplier</th>
                        <th>Billing Date</th>   
                        <th>Amount</th>                  
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="req-body">
                    <?php
                      $view = $po->get_submitted_po();
                      while($row = $view->fetch(PDO::FETCH_ASSOC))
                      {
                        //get the COMPANY name if exist
                        $comp_name = '-';
                        $company->id = $row['comp-id'];
                        $get2 = $company->get_company_detail();
                        while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
                        {
                          if($row['comp-id'] == $rowComp['id']){
                            $comp_name = $rowComp['company'];
                          }
                        }
                        //get the SUPPLIER name if exist
                        $sup_name = '-';
                        $supplier->id = $row['supp-id'];
                        $get3 = $supplier->get_supplier_details();
                        while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
                        {
                          if($row['supp-id'] == $rowSupp['id']){
                            $sup_name = $rowSupp['supplier_name'];
                          }
                        }
                        //format of status
                        if($row['status'] == 1){
                          $status = '<label style="color: red"><b> Pending</b></label>';
                        }else if($row['status'] == 2){
                          $status = '<label style="color: orange"><b> Returned</b></label>';
                        }elseif($row['status'] == 5){
                          $status = '<label style="color: blue"><b> For Signature</b></label>';
                        }elseif($row['status'] == 6){
                          $status = '<label style="color: blue"><b> Sent to EA</b></label>';
                        }elseif($row['status'] == 8){
                          $status = '<label style="color: blue"><b> For Verification</b></label>';
                        }elseif($row['status'] == 9){
                          $status = '<label style="color: red"><b> On Hold</b></label>';
                        }else if($row['status'] == 10){
                          $status = '<label style="color: green"><b> For Releasing</b></label>';
                        }else if($row['status'] == 11){
                          $status = '<label style="color: green"><b> Released</b></label>';
                        }else{
                          $status = '<label style="color: blue"><b> On Process</b></label>';
                        }
                        //date format
                        $bill_date = date('m/d/Y', strtotime($row['bill_date']));
                        echo '
                        <tr>
                          <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                          <td>'.$comp_name.'</td>
                          <td>'.$row['po_num'].'</td>
                          <td>'.$row['si_num'].'</td>
                          <td>'.$sup_name.'</td>
                          <td>'.$bill_date.'</td>
                          <td>'.number_format(floatval($row['amount']), 2).'</td>
                          <td><center>'.$status.'</center></td>
                        </tr>';
                        }
                      ?>
                    </tbody>
                  </table> 
                </div>
              </div>
            </div>     
          </div><!-- /end of req-table-->
      </div><!---/Container-Fluid-->
  </div><!-- /wrapper -->
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>

<!-- View Details Modal -->
<div class="modal fade" id="POmodalDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DisableFields()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="details-body" class="modal-body">
        <!-- modal body goes here -->
      </div>
      <div class="modal-footer">
        <button id="btnClose" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<script src="../../assets/vendor/jquery/jquery.min.js"></script>
<script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/vendor/datetimepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../../assets/js/ruang-admin.min.js"></script>
<script src="../../assets/js/jquery.toast.js"></script>
<script src="../../assets/vendor/select2/js/select2.full.min.js"></script>
<script src="../../assets/vendor/select2/js/select2.min.js"></script>
<script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<?php include 'js/dashboard-js.php';?>

</body>
</html>