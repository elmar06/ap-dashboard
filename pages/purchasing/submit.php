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
    <?php include '../../includes/purchasing.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Purchasing</a></li>
              <li class="breadcrumb-item active" aria-current="page">Submitted PO/JO List</li>
            </ol>
          </div><!-- /Breadcrumbs -->

          <!-- Cards -->
          <!-- Pending Card -->
          <div class="row mb-3">
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
                      <?php
                        //$view = $po->
                      ?>
                    </tbody>
                  </table> 
                </div>
              </div>
            </div>     
        </div><!---/Container Fluid-->
      </div>
</div>
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>

  <!-- Submit PO Modal -->
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Request</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col-md-12">
            <label>PO/JO Number:</label>
            <input class="form-control  mb-3" type="text" placeholder="Enter PO/JO number here...">
            <label>Company:</label>
            <select class="form-control mb-3">
              <option selected disabled>Please select a Company</option>
            </select>
            <label>Supplier:</label>
            <select class="form-control mb-3">
              <option selected disabled>Plese select a Supplier</option>
            </select>
            <label>Invoice/Billing No:</label>
            <input class="form-control  mb-3" type="text" placeholder="Enter Invoice/Billing number here...">
            <label>Billing/Invoice Date:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
              </div>
              <input type="text" class="form-control" aria-describedby="basic-addon1">
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