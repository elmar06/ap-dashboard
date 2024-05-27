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
  <link href="../../assets/vendor/font-awesome/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/datetimepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
  <link href="../../assets/css/ruang-admin.css" rel="stylesheet">
  <link href="../../assets/vendor/dataTables1/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/toastr/toastr.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/purchasing.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">SCM-PMC</a></li>
              <li class="breadcrumb-item active" aria-current="page">Submitted PO/JO List</li>
            </ol>
          </div><!-- /Breadcrumbs -->
          <!-- Pending Card -->
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="pills-pending-tab" data-toggle="pill" href="#pills-pending" role="tab" aria-controls="pills-home" aria-selected="true">Pending PO/JO</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-returned-tab" data-toggle="pill" href="#pills-returned" role="tab" aria-controls="pills-profile" aria-selected="false">Returned</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-process-tab" data-toggle="pill" href="#pills-process" role="tab" aria-controls="pills-contact" aria-selected="false">In Process</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-releasing-tab" data-toggle="pill" href="#pills-releasing" role="tab" aria-controls="pills-contact" aria-selected="false">For Releasing</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-release-tab" data-toggle="pill" href="#pills-released" role="tab" aria-controls="pills-contact" aria-selected="false">Released</a>
              </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
              <!-- PENDING PO/JO -->
              <div class="tab-pane fade show active" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">
                <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-3">
                    <div class="table1-responsive p-3">
                      <table id="pendingTable" class="table1 table-bordered table-flush table-hover DataTable" style="cursor:pointer;">
                        <thead class="thead-light">
                          <tr>
                            <th><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                            <th>Submitted by</th>
                            <th>Project</th>
                            <th>Company</th>
                            <th>SI No</th>
                            <th>PO/JO No</th>
                            <th>Supplier</th>
                            <th>Amount</th>
                            <th>Bill Date</th>
                          </tr>
                        </thead>
                        <tbody id="po-pending-body">
                          <!-- SERVER SIDE DATATABLE -->
                        </tbody>
                      </table> 
                    </div>
                  </div>
                </div>  
                </div>           
              </div><!-- END-PENDING -->
              <!-- RETURNED -->
              <div class="tab-pane fade" id="pills-returned" role="tabpanel" aria-labelledby="pills-returned-tab">
                <div id="returnedTable" class="row">
                <div class="col-lg-12">
                  <div class="card mb-3">
                    <div class="table1-responsive p-3">
                      <table id="returnTable" class="table1 table-bordered table-flush table-hover DataTable" style="cursor:pointer;">
                        <thead class="thead-light">
                          <tr>
                            <th><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                            <th>Submitted by</th>
                            <th>Project</th>
                            <th>Company</th>
                            <th>SI No</th>
                            <th>PO/JO No</th>
                            <th>Supplier</th>
                            <th>Amount</th>
                            <th>Bill Date</th>
                          </tr>
                        </thead>
                        <tbody id="po-returned-body">
                          <!--  RETURNED TABLE BODY HERE -->
                        </tbody>
                      </table> 
                    </div>
                  </div>
                </div>  
                </div>
              </div>
              <!-- IN PROCESS -->
              <div class="tab-pane fade" id="pills-process" role="tabpanel" aria-labelledby="pills-process-tab">
                <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-3">
                    <div class="table1-responsive p-3">
                      <table id="processTable" class="table1 table-bordered table-flush table-hover DataTable" style="cursor:pointer;">
                        <thead class="thead-light">
                          <tr>
                            <th><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                            <th><center>Status</center></th>
                            <th>Submitted by</th>
                            <th>Project</th>
                            <th>Company</th>
                            <th>SI No</th>
                            <th>PO/JO No</th>
                            <th>Supplier</th>
                            <th>Billing Date</th>
                            <th>Check Date</th>
                            <th>Check No.</th>
                            <th>CV Amount</th>
                            <th>Tax</th>
                            <th>Sent to EA</th>
                          </tr>
                        </thead>
                        <tbody id="po-submit-body">
                          <!-- server side dataTable -->
                        </tbody>
                      </table> 
                    </div>
                  </div>
                </div>  
                </div>
              </div>
              <!-- FOR RELEASING -->
              <div class="tab-pane fade" id="pills-releasing" role="tabpanel" aria-labelledby="pills-releasing-tab">
                <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-3">
                    <div class="table1-responsive p-3">
                      <table id="forReleasingTable" class="table1 table-bordered table-flush table-hover DataTable" style="cursor:pointer;">
                        <thead class="thead-light">
                          <tr>
                            <th><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                            <th>Submitted by</th>
                            <th>Project</th>
                            <th>Company</th>
                            <th>SI No</th>
                            <th>PO/JO No</th>
                            <th>Supplier</th>
                            <th>Billing Date</th>
                            <th>Check Date</th>
                            <th>Check No.</th>
                            <th>CV Amount</th>
                            <th>Tax</th>
                            <th>Sent to EA</th>
                          </tr>
                        </thead>
                        <tbody id="po-releasing-body">
                          <!-- server side dataTable -->
                        </tbody>
                      </table> 
                    </div>
                  </div>
                </div>  
                </div>
              </div>
              <!-- RELEASED -->
              <div class="tab-pane fade" id="pills-released" role="tabpanel" aria-labelledby="pills-released-tab">
                <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-3">
                    <div class="table1-responsive p-3">
                      <table id="releasedTable" class="table1 table-bordered table-flush table-hover DataTable" style="cursor:pointer;">
                        <thead class="thead-light">
                          <tr>
                            <th><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                            <th>Submitted by</th>
                            <th>Project</th>
                            <th>Company</th>
                            <th>SI No</th>
                            <th>PO/JO No</th>
                            <th>Supplier</th>
                            <th>Billing Date</th>
                            <th>Check Date</th>
                            <th>Check No.</th>
                            <th>CV Amount</th>
                            <th>Tax</th>
                            <th>Sent to EA</th>
                          </tr>
                        </thead>
                        <tbody id="po-submit-body">
                          <!-- server side datatable -->
                        </tbody>
                      </table> 
                    </div>
                  </div>
                </div>  
                </div>
              </div>
            </div>
      </div>
</div>
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>

<!-- Edit Details Modal -->
<div class="modal fade" id="POmodalDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
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
        <button id="btnEdit" class="btn btn-danger" onclick="remove_po()">Mark as Void</button>
        <button id="btnEdit" class="btn btn-info" onclick="EnableFields()">Edit</button>
        <button id="btnSubmit" class="btn btn-primary" onclick="upd_po_details()">Resubmit</button>
      </div>
    </div>
  </div>
</div>

<!-- View Only Details Modal -->
<div class="modal fade" id="viewDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DisableFields()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="view-body" class="modal-body">
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
  <script src="../../assets/vendor/datetimepicker/js/bootstrap-datepicker.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../../assets/js/ruang-admin.min.js"></script>
  <!-- Datatable plugins -->
  <script src="../../assets/vendor/select2/js/select2.min.js"></script>
  <script src="../../assets/vendor/dataTables1/js/jquery.dataTables.min.js"></script>
  <script src="../../assets/vendor/select2/js/select2.full.min.js"></script>
  <script src="../../assets/vendor/dataTables1/js/dataTables.bootstrap.min.js"></script>
  <script src="../../assets/js/jquery.toast.js"></script>
  <script src="../../assets/vendor/toastr/toastr.js"></script>
  <?php include "js/submit-js.php"; ?>
</body>
</html>