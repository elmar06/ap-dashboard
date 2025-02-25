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
<!-- update as of 3/23/20 -->

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/backOffice.php'; ?>
    <!-- page header -->
    <!-- Container Fluid-->
    <!-- Breadcrumbs -->
    <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex justify-content-between mb-4">
        <ol class="breadcrumb" align="right">
          <li class="breadcrumb-item"><a href="#">Accounting Payables</a></li>
          <li class="breadcrumb-item active" aria-current="page">Stale Check (Back Office)</li>
        </ol>
      </div><!-- /Breadcrumbs -->
      <!-- Pending Card -->
      <div id="page-body">
        <div id="bulk-action" class="row" style="display: none">
          <div class="col-lg-2">
            <select id="action" class="form-control select2" style="width: 100%">
              <option selected disabled>Bulk Actions</option>
              <option value="1">Sent to EA</option>
              <option value="2">Received from EA</option>
            </select>
          </div>
        </div><br>
        <!-- DataTable with Hover -->
        <div class="row mb-3">
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="table1-responsive p-3">
                <table class="table1 align-items-center table-flush table-hover" id="process-table">
                  <thead class="thead-light">
                    <tr>
                      <th style="max-width: 1%"><input type="checkbox" class="checkboxall" /><span class="checkmark"></span></th>
                      <th>CV No</th>
                      <th>Check No</th>
                      <th>PO/JO No</th>
                      <th>Company</th>
                      <th>Payee</th>
                      <th>Staled Date</th>
                    </tr>
                  </thead>
                  <tbody id="process-body">
                    <?php
                    // get the stale check details
                    $view = $po->get_all_stale();
                    while ($rowStale = $view->fetch(PDO::FETCH_ASSOC)) {
                      $po_num = '-';
                      $comp_name = '-';
                      $sup_name = '-';
                      $comp_id = '-';
                      //get the po details
                      $po_id = $rowStale['po_id'];
                      $array_po_id = explode(',', $po_id);
                      foreach ($array_po_id as $po_val) {
                        $po->id = $po_val;
                        $get_po = $po->get_po_by_id();

                        // $rowPO = $get_po->fetch(PDO::FETCH_ASSOC);
                        // print_r($rowPO);

                        while ($rowPO = $get_po->fetch(PDO::FETCH_ASSOC)) {
                          $comp_id = $rowPO['comp-id'];
                          $supp_id = $rowPO['supp-id'];
                          $po_num = $rowPO['po_num'];

                          //get the company details
                          $company->id = $comp_id;
                          $get2 = $company->get_company_detail();
                          while ($rowComp = $get2->fetch(PDO::FETCH_ASSOC)) {
                            if ($comp_id == $rowComp['id']) {
                              $comp_name = $rowComp['company'];
                            }
                          }
                          //get the SUPPLIER name if exist
                          $supplier->id = $supp_id;
                          $get3 = $supplier->get_supplier_details();

                          while ($rowSupp = $get3->fetch(PDO::FETCH_ASSOC)) {
                            if ($supp_id == $rowSupp['id']) {
                              $sup_name = $rowSupp['supplier_name'];
                            }
                          }
                        }
                      }
                      echo '
                          <tr>
                            <td><input type="checkbox" name="checklist" class="checklist" value="' . $rowStale['po_id'] . '"></td>
                            <td>' . $rowStale['cv_no'] . '</td>
                            <td>' . $rowStale['check_no'] . '</td>
                            <td>' . $po_num . '</td>
                            <td>' . $comp_name . '</td>
                            <td>' . $sup_name . '</td>
                            <td>' . $rowStale['stale_date'] . '</td>
                          </tr>
                          ';
                      // }
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
  <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Check Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="details-body" class="modal-body">
          <!-- modal body goes here -->
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" onclick="submit_cancellation()">Submit</button>
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
  <?php include_once 'js/cancel-js.php'; ?>

</body>

</html>