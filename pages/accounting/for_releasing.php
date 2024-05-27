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
    <?php include '../../includes/frontOffice.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Accounting Payables</a></li>
              <li class="breadcrumb-item active" aria-current="page">For Releasing (Front Office)</li>
            </ol>
          </div><!-- /Breadcrumbs -->
          <!-- Pending Card -->
          <div id="page-body">
          <!-- <div>
            <button id="btnAllRelease" type="button" class="btn btn-success mb-1" href="#" onclick="released_all()" disabled>Mark All Released</button>
          </div><br> -->
          <!-- DataTable with Hover -->
          <div class="row mb-3">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table1-responsive p-3">
                  <table class="table1 align-items-center table-flush table-hover" id="releasing-table">
                    <thead class="thead-light">
                      <tr>
                        <th><center>Action</center></th>
                        <th>Check No</th>
                        <th>Amount</th>
                        <th>Project</th>
                        <th>Company</th>
                        <th>PO/JO No</th>
                        <th>Payee</th>
                        <th>Billing Date</th>
                      </tr>
                    </thead>
                    <tbody id="released-body">
                    <?php
                      //get all the check details
                      // $getCheck = $check_details->get_active_check();
                      // while($row1 = $getCheck->fetch(PDO:: FETCH_ASSOC))
                      // {
                      //   $check_no = $row1['check_no'];
                      //   //get the po_details & po_other_details
                      //   $po_id = $row1['po_id'];
                      //   $array_po_id = explode(',', $po_id);
                      //   foreach($array_po_id as $po_val)
                      //   {

                      //   }
                      // }
                      $view = $po->get_for_releasing_fo();
                      while($row = $view->fetch(PDO::FETCH_ASSOC))
                      { 
                        //get the COMPANY name if exist
                        $company->id = $row['comp-id'];
                        $get2 = $company->get_company_detail();
                        while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
                        {
                          if($row['comp-id'] == $rowComp['id']){
                            $comp_name = $rowComp['company'];
                          }else{
                            $comp_name = '-';
                          }
                        }
                        //get the SUPPLIER name if exist
                        $supplier->id = $row['supp-id'];
                        $get3 = $supplier->get_supplier_details();
                        while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
                        {
                          if($row['supp-id'] == $rowSupp['id']){
                            $sup_name = $rowSupp['supplier_name'];
                          }else{
                            $sup_name = '-';
                          }
                        }    
                        $proj_name = '';
                        //get the PROJECT name if exist
                        $project->id = $row['proj-id'];
                        $get1 = $project->get_proj_details();
                        while($rowProj = $get1->fetch(PDO::FETCH_ASSOC))
                        {
                          if($row['proj-id'] == $rowProj['id']){
                            $proj_name = $rowProj['project'];
                          }else{
                            $proj_name = '-';
                          }
                        }                 
                        //date format
                        $bill_date = date('m/d/Y', strtotime($row['bill_date']));
                        echo '
                        <tr>
                          <td>
                            <center>
                              <button class="btn btn-success btn-sm btnRelease" value="'.$row['po-id'].'"><i class="fas fa-check-circle"></i> Released</button>
                            </center>
                          </td>
                          <td>'.$row['check_no'].'</td>
                          <td>'.number_format($row['cv_amount'], 2).'</td>
                          <td>'.$proj_name.'</td>
                          <td>'.$comp_name.'</td>
                          <td>'.$row['po_num'].'</td>
                          <td style="width: 200px">'.$sup_name.'</td>
                          <td>'.$bill_date.'</td>
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
        <h5 class="modal-title" id="exampleModalLabel">PO Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="details-body" class="modal-body">
        <!-- modal body goes here -->
      </div>
      <div class="modal-footer">
      <button class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Mark for Releasing Modal -->
<div class="modal fade" id="ReleasingDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">PO Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="release-body" class="modal-body">
        <!-- modal body goes here -->
      </div>
      <div class="modal-footer">
      <button class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button class="btn btn-primary" onclick="submit()">Submit</button>
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
<?php include 'js/forReleasing-js.php';?>

</body>
</html>