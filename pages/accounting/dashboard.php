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
  <link href="../../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/payables.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Accounting Payables</a></li>
              <li class="breadcrumb-item">Pages</li>
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
                      <div class="h5 mb-0 font-weight-bold text-gray-800">25</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> More Details</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-primary"></i>
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
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Received by AP</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">60</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> More Details</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-shopping-cart fa-2x text-success"></i>
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
                      <div class="text-xs font-weight-bold text-uppercase mb-1">For Releasing</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">36</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> More Details</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-info"></i>
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
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Submitted PO/JO</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> More Details</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Company</th>
                        <th>PO/JO No</th>
                        <th>Supplier</th>
                        <th>Invoice/Billing No</th>
                        <th>Billing Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>ABC Company</td>
                        <td>19-000801</td>
                        <td>123A Supplier</td>
                        <td>1234567890</td>
                        <td>2011/04/25</td>
                        <td><a style="color: red">Pending</a></td>
                      </tr>
                      <tr>
                        <td>XYZ Company</td>
                        <td>19-000802</td>
                        <td>Atlantic Hardware</td>
                        <td>321456-13</td>
                        <td>2011/07/25</td>
                        <td><a style="color: blue">For BO Processing</a></td>
                      </tr>
                      <tr>
                        <td>Citrineland</td>
                        <td>20-000201</td>
                        <td>Vic Enterprises</td>
                        <td>88974-254</td>
                        <td>2009/01/12</td>
                        <td><a style="color: green">For Releasing</a></td>
                      </tr>
                       <tr>
                        <td>CCC Company</td>
                        <td>19-000803</td>
                        <td>ABC Supplier</td>
                        <td>123-4578-154</td>
                        <td>2009/01/12</td>
                        <td><a style="color: orange">For Signature</a></td>
                      </tr>
                    </tbody>
                  </table> 
                </div>
              </div>
            </div>      
    
        </div><!---/Container Fluid-->
      </div>
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>

  </div>

  <!-- Submit PO Modal -->
  <!-- Modal -->
  <div class="modal fade bd-example-modal-lg" id="pendingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-clipboard-list"></i> Request Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h6><i>General Information</i></h6>
          <div class="row">
            <div class="col-md-6">
              <label>PO/JO Number:</label>
              <input class="form-control mb-3" type="text" value="19-000801" disabled>
            </div>
            <div class="col-md-6">
              <label>Invoice/Billing No:</label>
              <input class="form-control mb-3" type="text" value="1234567890" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Billing/Invoice Date:</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" class="form-control" aria-describedby="basic-addon1" value="1/12/2020" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Company:</label>
              <input class="form-control mb-3" type="text" value="ABC Company" disabled>
              <label>Supplier:</label>
              <input class="form-control mb-3" type="text" value="123A Supplier" disabled>
            </div>
          </div><hr>
          <div class="row">
            <div class="col-md-6">
              <label>Date Received:</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" class="form-control" aria-describedby="basic-addon1" value="12/12/2019">
              </div>
            </div>
            <div class="col-md-6">
              <label>Terms:</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="fa fa-clock"></i></span>
                </div>
                <input type="text" class="form-control" aria-describedby="basic-addon1" value="30">
              </div>
            </div>    
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Due Date:</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" class="form-control" aria-describedby="basic-addon1" value="1/12/2020" disabled>
              </div>
            </div>
            <div class="col-md-6">
              <label>Days before Due Date:</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="fa fa-clock"></i></span>
                </div>
                <input type="text" class="form-control" aria-describedby="basic-addon1" value="30" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                <label class="custom-control-label" for="customSwitch1">Mark this Request as Returned</label>
              </div>
            </div>    
          </div><hr>
          <label><i>Check Information</i></label>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label>CV Number:</label>
                <input type="text" class="form-control" aria-describedby="basic-addon1" value="12/12/2019">
            </div>
            <div class="col-md-6 mb-3">
              <label>Check Number:</label>
                <input type="text" class="form-control" aria-describedby="basic-addon1" value="30">
            </div>  
          </div> 
          <div class="row">
            <div class="col-md-12 mb-3">
              <label>Bank:</label>
                <select class="form-control">
                  <option selected disabled>Plese select Bank</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
              <label>Date Sent to EA:</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" class="form-control" aria-describedby="basic-addon1" value="30">
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label>Date received from EA:</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" class="form-control" aria-describedby="basic-addon1" value="30">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch2">
                <label class="custom-control-label" for="customSwitch2">Mark as Released</label>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label>Date Release:</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" class="form-control" aria-describedby="basic-addon1" value="30">
              </div>
            </div>    
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success">Submit</button>
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
  <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../../assets/js/ruang-admin.min.js"></script>
  <!-- Datatable plugins -->
  <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

</body>
</html>

<!-- Page level custom scripts -->
<script>
  $(document).ready(function () {
    $('#dataTable').DataTable(); // ID From dataTable 
    $('#dataTableHover').DataTable(); // ID From dataTable with Hover
  });
</script>

<script>
$('.pending').click(function(e){
  e.preventDefault();
  $('#pendingModal').modal('show');
})
</script>

<!-- show modal if the double click a cell -->
<script>
$(document).on('dblclick', '#dataTableHover tr', function(){

  $('#pendingModal').modal('show');
})
</script>