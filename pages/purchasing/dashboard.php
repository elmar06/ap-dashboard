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
          <div id="page-body">
            <div class="row mb-3">
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Pending PO/JO</div>
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_pending_by_user();
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
              <!-- Returned count -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Returned</div>
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_return_by_user();
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
                          $count = $po->count_on_process_by_user();
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
                          $count = $po->count_releasing_by_user();
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PO-Modal" id="#myBtn"> Submit PO/JO</button>
                <button type="button" class="btn btn-danger" id="btnClear" style="display: none" onclick="clear_list()"> Clear Search</button>
              </div>
            </div>
            <!-- Submitted PO/JO Details -->
            <div id="po-details-body" class="row">
              <?php
                $po->submitted_by = $_SESSION['id'];
                $get = $po->get_details_pending();
                while($row=$get->fetch(PDO::FETCH_ASSOC))
                {
                  echo '
                  <div class="col-lg-4">
                    <div class="card mb-5">
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <div class="row">
                            <h6 class="m-0 font-weight-bold text-primary">PO/JO Number: '.$row['po_num'].'</h6>  
                        </div>
                      </div>
                      <div class="card-body">
                        <p>Company: '.$row['company-name'].'<br>
                          Supplier: '.$row['supplier_name'].'
                        </p>
                        <div class="row">
                          <div class="mt-2 mb-0 text-xs col-sm-6" align="left">
                            <a class="text-success details" href="#" value="'.$row['po-id'].'" data-toggle="modal"><i class="fas fa-plus"></i> More Details</a>
                          </div>
                          <div class="mt-2 mb-0 text-xs col-sm-6" align="right">
                            <a class="text-danger remove" href="#" value="'.$row['po-id'].'" data-toggle="modal"><i class="fas fa-trash"></i> Delete</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>';
                }
              ?>
            </div> <!-- end of po-details body -->
            <div id="req-list" class="row mb-3">
              <!-- DataTable with Hover -->
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="table-responsive p-3">
                    <table id="submitted-table" class="table align-items-center table-flush table-hover">
                      <thead class="thead-light">
                        <tr>
                          <th style="display: none"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                          <th>Company</th>
                          <th>PO/JO No</th>
                          <th>Invoice/Billing No</th>
                          <th>Supplier</th>
                          <th>Billing Date</th>
                          <th><center>Status</center></th>
                        </tr>
                      </thead>
                      <tbody id="req-body">
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $view = $po->get_submitted_po_by_user();
                          while($row = $view->fetch(PDO::FETCH_ASSOC))
                          {
                            //format of status
                            if($row['status'] == 1)
                            {
                              $status = '<label style="color: red"><b> Pending</b></label>';
                            }
                            else if($row['status'] == 2)
                            {
                              $status = '<label style="color: orange"><b> Returned</b></label>';
                            }
                            else if($row['status'] == 8)
                            {
                              $status = '<label style="color: green"><b> For Releasing</b></label>';
                            }
                            else
                            {
                              $status = '<label style="color: blue"><b> On Process</b></label>';
                            }
                            //date format
                            $bill_date = date('m/d/Y', strtotime($row['bill_date']));
                            echo '
                            <tr>
                              <td style="display: none"><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                              <td>'.$row['comp-name'].'</td>
                              <td>'.$row['po_num'].'</td>
                              <td>'.$row['bill_no'].'</td>
                              <td>'.$row['supplier_name'].'</td>
                              <td>'.$bill_date.'</td>
                              <td><center>'.$status.'</center></td>
                            </tr>';
                          }
                        ?>
                      </tbody>
                    </table> 
                  </div>
                </div>
              </div>     
            </div><!-- /end of req-table -->
          </div> <!-- /end of page-body -->
      </div><!---/Container-Fluid-->
  </div><!-- /wrapper -->
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>


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
            <label><i style="color: red">*</i> Billing No:</label>
            <input id="bill-no" class="form-control mb-3" type="text" placeholder="Enter Billing number">
          </div>
          <div class="col-lg-6">
            <label><i style="color: red">*</i> PO/JO Number:</label>
            <input id="po-no" class="form-control mb-3" type="text" placeholder="Enter PO/JO number">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <label><i style="color: red">*</i> Amount</label>
            <input id="amount" class="form-control mb-3" type="text" placeholder="Amount">
          </div>
          <div class="col-lg-6">
            <label><i style="color: red">*</i> Sales Invoice No.</label>
            <input id="sales-invoice" class="form-control mb-3" type="text" placeholder="Sales Invoice here..">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <label><i style="color: red">*</i> Company:</label>
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
            <label><i style="color: red">*</i> Supplier:</label>
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
            <label><i style="color: red">*</i> Project:</label>
            <select id="project" class="form-control mb-3 select2" style="width: 100%;">
              <option selected disabled>Select a Project</option>
              <?php
                $get = $project->get_active_project();
                while($row = $get->fetch(PDO::FETCH_ASSOC))
                {
                  echo '<option value="'.$row['id'].'">'.$row['project'].'</option>';
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
            <label><i style="color: red">*</i> Billing/Invoice Date:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
              </div>
              <input id="bill-date" class="form-control datepicker" placeholder="Enter Billing Date" onchange="getDueDate()">
            </div>
          </div>
          <div class="col-lg-4" style="margin-top: 17px">
            <label><i style="color: red">*</i> Terms:</label>
            <input id="terms" class="form-control mb-3" type="text" placeholder="Enter Terms" onchange="getDueDate()" value="0">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
          <label><i style="color: red">*</i> Due Date:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
              </div>
              <input id="due-date" class="form-control datepicker" placeholder="PO Due Date" disabled >
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitch1">
              <label class="custom-control-label" for="customSwitch1"> Credit Memo</label>
            </div>
          </div>
        </div>
        <div class="row report" style="display:none">
          <div class="col-lg-12">
            <label style="padding-top: 15px"><i style="color: red">*</i>Incident Report</label>
            <textarea id="report" class="form-control mb-3" type="text" placeholder="Report here.."></textarea>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DisableFields()">
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
        <button id="btnSubmit" class="btn btn-primary" onclick="upd_po_details()">Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="color: red"><b>NOTICE</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="notf-msg" style="font-size: 18px;">Are you sure you want to remove this request?</div>
        <input id="po-id" class="form-control" style="display: none;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel</button>
        <button id="btnSubmit" class="btn btn-danger" onclick="remove_po()"><i class="fas fa-trash"></i> Remove</button>
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
<?php include 'js/dash-js.php';?>

</body>
</html>