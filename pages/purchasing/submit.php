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
  <link href="../../assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
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
          <!-- Pending Card -->
          <div class="row mb-3">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table id="submitted-table" class="table align-items-center table-flush table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th hidden><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                        <th>Company</th>
                        <th>PO/JO No</th>
                        <th>Invoice/Billing No</th>
                        <th>Supplier</th>
                        <th>Billing Date</th>
                        <th><center>Status</center></th>
                      </tr>
                    </thead>
                    <tbody id="po-submit-body">
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
                          elseif($row['status'] == 8)
                          {
                            $status = '<label style="color: red"><b> On Hold</b></label>';
                          }
                          else if($row['status'] == 9)
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
                            <td hidden><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
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
        </div><!---/Container Fluid-->
      </div>
</div>
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>

<!-- Edit Details Modal -->
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
        <button id="btnSubmit" class="btn btn-primary" onclick="upd_po_details()">Resubmit</button>
      </div>
    </div>
  </div>
</div>

<!-- View Only Details Modal -->
<div class="modal fade" id="viewDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
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
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../../assets/js/ruang-admin.min.js"></script>
  <!-- Datatable plugins -->
  <script src="../../assets/vendor/select2/js/select2.full.min.js"></script>
  <script src="../../assets/vendor/select2/js/select2.min.js"></script>
  <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="../../assets/js/jquery.toast.js"></script>
  <?php include "js/submit-js.php"; ?>
</body>
</html>