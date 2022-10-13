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
            <li class="breadcrumb-item"><a href="dashboard.php">SCM-PMC</a></li>
            <li class="breadcrumb-item">Pages</li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
          </ol>
        </div><!-- /Breadcrumbs -->
          <!-- DataTable with Hover -->
          <div class="col-lg-12">
            <div class="form-group">
              <!-- <div class="row">
                &nbsp;&nbsp;&nbsp;
                <button id="btnAdd" class="btn btn-primary btn-block" style="width: 13%" data-toggle="modal" data-target="#newUser"><i class="fas fa-plus"></i> Add Supplier</button>&nbsp;
                <button id="btnMultiRemove" type="button" class="btn btn-danger" style="display: none"><i class="fas fa-trash"></i> Remove Multiple</button>&nbsp;
              </div> -->
            </div>
            <div class="card mb-5">
              <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover dataTable" id="supplier-table">
                  <thead class="thead-light">
                    <tr>
                      <th style="width: 3%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                      <th style="width: 50%"><center>Supplier Name</center></th>
                      <th style="width: 15%"><center>Status</center></th>
                    </tr>
                  </thead>
                  <tbody id="supplier-body">
                    <!-- table body in here -->
                    <?php
                      $view = $supplier->view_suppliers();
                      while($row = $view->fetch(PDO::FETCH_ASSOC))
                      {
                        if($row['status'] == 1)
                        {
                          $status = '<label style="color: green"><b> Active</b></label>';
                        }else{
                          $status = '<label style="color: red"><b> Inactive</b></label>';
                        }
                          echo'
                          <tr>
                            <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['id'].'"></td>
                            <td>'.$row['supplier_name'].'</td>
                            <td><center>'.$status.'</center></td>
                          </tr>';
                      }
                    ?>
                  </tbody>
                </table> 
              </div><!-- /table-responsive -->
            </div><!-- /card -->
          </div> <!-- /col -->     
      </div><!---/Container Fluid-->
  </div><!-- /wrapper -->
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Modal Section-->
<!-- Add New User Modal -->
<div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-tag"></i> Supplier Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                  <input type="text" class="form-control firstname" id="name" placeholder="Supplier Name">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control firstname" id="terms" placeholder="Terms">
                </div>
                <!-- Alert -->
                <div id="add-success" class="alert alert-success" role="alert" style="display: none"></div>
                <div id="add-warning" class="alert alert-danger" role="alert" style="display: none"></div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="btnSave" type="button" class="btn btn-primary">Save</button>
        </div>
        </div>
    </div>
</div>
<!-- Display the details of user modal -->
<div class="modal fade" id="supplierDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user"></i> User Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div id="details-body" class="modal-body">
          <!-- body goes here -->
          <!-- Alert -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="btnUpdSupplier" type="button" class="btn btn-primary">Update Details</button>
        </div>
        </div>
    </div>
</div>

<!-- Error modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <center><label id="error-msg" style="font-size: 18px; color: red; display: none;"></label></center>
          <center><label id="success-msg" style="font-size: 18px; color: green; display: none;"></label></center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<script src="../../assets/vendor/jquery/jquery.min.js"></script>
<script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../../assets/js/ruang-admin.min.js"></script>
<!-- Datatable plugins -->
<script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/js/jquery.toast.js"></script>
<?php include 'js/supplier-js.php'; ?>

</body>
</html>