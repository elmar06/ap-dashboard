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
  <link href="../../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="../../assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/datetimepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/toastr/toastr.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/verify.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Accounting Payables</a></li>
              <li class="breadcrumb-item active" aria-current="page">Checker</li>
            </ol>
          </div><!-- /Breadcrumbs -->
          <!-- Pending Card -->
          <div id="page-body">
          <div>
            <a type="button" class="btn btn-success mb-1" href="#" onclick="mark_for_releasing()"><i class="fas fa-check-square"></i> Release Check</a>
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
                    <tbody id="req-body">
                    <?php
                      $po->submitted_by = $_SESSION['id'];
                      $view = $po->get_on_hold_check();
                      while($row = $view->fetch(PDO::FETCH_ASSOC))
                      {
                        $status = '<label style="color: red"><b> On Hold</b></label>';
                        
                        echo '
                        <tr>
                          <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                          <td>'.$row['cv_no'].'</td>
                          <td>'.$row['check_no'].'</td>
                          <td>'.$row['comp-name'].'</td>
                          <td>'.$row['po_num'].'</td>
                          <td>'.$row['supplier_name'].'</td>
                          <td><center>'.$status.'</center></td>
                        </tr>';
                      }
                    ?>
                    </tbody>
                  </table> 
                </div>
              </div>
            </div><!-- /column -->
          </div><!-- /row --> 
          </div><!-- /page-body -->   
    </div><!-- /container-wrapper-->
  </div><!-- /wrapper -->
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

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
        <a href="#" id="returned" class="btn btn-danger" onclick="mark_returned()"><i class="fas fa-undo-alt"></i></a>
        <a href="#" id="received" class="btn btn-success" onclick="mark_received()"><i class="fas fa-check"></i></a>
        <a href="#" id="cancel" class="btn btn-danger" onclick="cancel_return()" style="display: none"><i class="fas fa-times"></i></a>
        <button id="btnSubmit" class="btn btn-primary" style="display: none">Submit</button>
      </div>
    </div>
  </div>
</div>

<script src="../../assets/vendor/jquery/jquery.min.js"></script>
<script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../../assets/js/ruang-admin.min.js"></script>
<script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/vendor/datetimepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../assets/vendor/select2/js/select2.full.min.js"></script>
<script src="../../assets/vendor/select2/js/select2.min.js"></script>
<script src="../../assets/js/jquery.toast.js"></script>
<script src="../../assets/vendor/toastr/toastr.js"></script>
<?php include 'js/verify-js.php';?>

</body>
</html>