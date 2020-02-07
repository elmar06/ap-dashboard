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
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/purchasing.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Purchasing</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
                        $count = $po->count_pending();
                        if($row = $count->fetch(PDO::FETCH_ASSOC))
                        {
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['pending-count'].'</div>';
                        }else{
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                      ?>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      <a class="text-success mr-2" href="#"><i class="fas fa-arrow-up"></i> More Details</a>
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
                        $count = $po->count_return();
                        if($row = $count->fetch(PDO::FETCH_ASSOC))
                        {
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['return-count'].'</div>';
                        }else{
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                      ?>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      <a class="text-success mr-2" href="#"><i class="fas fa-arrow-up"></i> More Details</a>
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
                        $count = $po->count_on_process();
                        if($row = $count->fetch(PDO::FETCH_ASSOC))
                        {
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['process-count'].'</div>';
                        }else{
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                      ?>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      <a class="text-success mr-2" href="#"><i class="fas fa-arrow-up"></i> More Details</a>
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
                        $count = $po->count_releasing();
                        if($row = $count->fetch(PDO::FETCH_ASSOC))
                        {
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['releasing-count'].'</div>';
                        }else{
                          echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                      ?>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#"><i class="fas fa-arrow-up"></i> More Details</a>
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
          <div class="row mb-3">
            <div class="col-md-12">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PO-Modal" id="#myBtn"> 
                Submit PO/JO
              </button>
            </div>
          </div>
          <!-- Submitted PO/JO Details -->
          <div id="po-details-body" class="row">
          <?php
            $get = $po->get_details_pending();
            while($row=$get->fetch(PDO::FETCH_ASSOC))
            {
              echo '
              <div class="col-lg-4">
                <div class="card mb-5">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">PO/JO Number: '.$row['po_num'].'</h6>
                  </div>
                  <div class="card-body">
                    <p>Company: '.$row['company-name'].'<br>
                      Supplier: '.$row['supplier_name'].'
                    </p>
                    <div class="mt-2 mb-0 text-xs" align="right">
                      <a class="text-success details" href="#" value="'.$row['po-id'].'" data-toggle="modal"><i class="fas fa-plus"></i> More Details</a>
                    </div>
                  </div>
                </div>
              </div>';
            }
          ?>
          </div> <!-- end of po-details body -->
      </div><!---/Container-Fluid-->
    </div><!-- /content-wrapper -->
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>
</div> <!-- /wrapper -->

<!-- Submit PO Modal -->
<!-- Modal -->
<div class="modal fade" id="PO-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <label>Invoice/Billing No:</label>
            <input id="bill-no" class="form-control mb-3" type="text" placeholder="Enter Billing number">
          </div>
          <div class="col-lg-6">
            <label>PO/JO Number:</label>
            <input id="po-no" class="form-control mb-3" type="text" placeholder="Enter PO/JO number">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <label>Company:</label>
            <select id="company" class="form-control mb-3 select2" style="width: 100%;">
              <option selected disabled>Select a Company</option>
              <?php
                $get = $company->get_active_company();
                while($row = $get->fetch(PDO::FETCH_ASSOC))
                {
                  echo '<option value="'.$row['id'].'">'.$row['company'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="col-lg-6">
            <label>Supplier:</label>
            <select id="supplier" class="form-control mb-3 select2"  style="width: 100%;">
              <option selected disabled>Select a Supplier</option>
              <?php
                $get = $supplier->get_active_supplier();
                while($row = $get->fetch(PDO::FETCH_ASSOC))
                {
                  echo '<option value="'.$row['id'].'">'.$row['supplier_name'].'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6"  style="margin-top: 16px">
            <label>Project:</label>
            <select id="project" class="form-control mb-3 select2" style="width: 100%;">
              <option selected disabled>Select a Project</option>
              <?php
                $get = $company->get_active_company();
                while($row = $get->fetch(PDO::FETCH_ASSOC))
                {
                  echo '<option value="'.$row['id'].'">'.$row['company'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="col-lg-6"  style="margin-top: 16px">
            <label>Department:</label>
            <select id="department" class="form-control mb-3 select2"  style="width: 100%;">
              <option selected disabled>Select a Department</option>
              <?php
                $get = $dept->get_active_department();
                while($row = $get->fetch(PDO::FETCH_ASSOC))
                {
                  echo '<option value="'.$row['id'].'">'.$row['department'].'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8" style="margin-top: 17px">
            <label>Billing/Invoice Date:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
              </div>
              <input id="bill-date" class="form-control datepicker" placeholder="Enter Billing Date" onchange="getDueDate()">
            </div>
          </div>
          <div class="col-lg-4" style="margin-top: 17px">
            <label>Terms:</label>
            <input id="terms" class="form-control mb-3" type="text" placeholder="Enter Terms" onchange="getDueDate()">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
          <label>Due Date:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
              </div>
              <input id="due-date" class="form-control datepicker" placeholder="PO Due Date" disabled >
            </div>
          </div>
          <div class="col-lg-4">
            <label>Days before Due</label>
            <input id="days-due" class="form-control mb-3" type="text" placeholder="No. of Days" disabled>
          </div>
        </div>
        <!-- Alert -->
        <div id="add-success" class="alert alert-success" role="alert" style="display: none"></div>
        <div id="add-warning" class="alert alert-danger" role="alert" style="display: none"></div>         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" onclick="SubmitPO()">Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="POmodalDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="details-body" class="modal-body">
        <!-- modal body goes here -->
      </div>
      <div class="modal-footer">
        <button id="btnClose" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="btnCancel" type="button" class="btn btn-secondary" style="display: none" onclick="DisableFields()">Cancel</button>
        <button id="btnEdit" class="btn btn-info" onclick="EnableFields()">Edit</button>
        <button id="btnSubmit" class="btn btn-primary" onclick="upd_po_details()" disabled>Submit</button>
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
<?php include 'js/dash-js.php';?>

</body>
</html>