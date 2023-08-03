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
  <link href="../../assets/vendor/datetimepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/toastr/toastr.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/compliance.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Accounting</a></li>
              <li class="breadcrumb-item active" aria-current="page">Compliance</li>
            </ol>
          </div><!-- /Breadcrumbs -->
          <!-- Pending Card -->
          <div id="page-body">
            <div class="row mb-3">
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">For Receiving</div>
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_for_receive_comp();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
                        ?>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#" onclick="get_for_receiving()"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-hand-holding fa-2x text-info"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- For Releasing Card -->
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Returned</div>
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_returned_comp();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
                        ?>
                        <div class="mt-2 mb-0 text-muted text-xs">
                          <a class="text-success mr-2" href="#" onclick="get_returned()"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-undo-alt fa-2x text-danger"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Received Card -->
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Received</div>
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_received_comp();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
                        ?>
                        <div class="mt-2 mb-0 text-muted text-xs">
                          <a class="text-success mr-2" href="received.php"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-check-double fa-2x text-success"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- end of card row -->
            <div id="btnDiv" style="display: none;">
              <a type="button" class="btn btn-success mb-1" href="#" onclick="mark_all_received()"><i class="fas fa-check-square"></i> Mark All Received</a>
              <a type="button" id="btnMarkAllReturn" class="btn btn-danger mb-1" href="#"><i class="fas fa-undo-alt"></i> Mark All for Returned</a>
            </div><br>
            <!-- DataTable with Hover -->
            <div class="row mb-3">
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div id="tblReceiving" class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover DataTable">
                      <thead class="thead-light">
                        <tr>
                          <th style="max-width: 2%"><input type="checkbox" class="checkboxall1"/><span class="checkmark"></span></th>
                          <th><center>Action</center></th>
                          <th>OR #</th>
                          <th>SI #</th>
                          <th>Company</th>
                          <th>Payee</th>
                          <th>CV #</th>
                          <th>Check #</th>
                          <th>CV Amount</th>
                          <th>Tax</th>
                          <th>PO/JO #</th>                    
                          <th>Due Date</th>
                          <th>Project</th>
                          <th>Released Date</th>
                        </tr>
                      </thead>
                      <tbody id="receive-body">
                      <?php
                        $view = $po->get_list_compliance();
                        while($row = $view->fetch(PDO::FETCH_ASSOC))
                        {
                          //get the PROJECT name if exist
                          $proj_name = '-';
                          $project->id = $row['proj-id'];
                          $get1 = $project->get_proj_details();
                          while($rowProj = $get1->fetch(PDO::FETCH_ASSOC))
                          {
                            if($row['proj-id'] == $rowProj['id']){
                              $proj_name = $rowProj['project'];
                            }
                          }
                          //get the COMPANY name if exist
                          $comp_name = '-';
                          $company->id = $row['comp-id'];
                          $get2 = $company->get_company_detail();
                          while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
                          {
                            if($row['comp-id'] == $rowComp['id']){
                              $comp_name = $rowComp['company'];
                            }
                          }
                          //get the SUPPLIER name if exist
                          $sup_name = '-';
                          $supplier->id = $row['supp-id'];
                          $get3 = $supplier->get_supplier_details();
                          while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
                          {
                            if($row['supp-id'] == $rowSupp['id']){
                              $sup_name = $rowSupp['supplier_name'];
                            }
                          }
                          //get the check details
                          $check_no = '-';
                          $amount = '-';
                          $tax = '-';
                          $cv_no = '-';
                          $get4 = $check_details->get_details_byID($row['po-id']);
                          while($rowCheck = $get4->fetch(PDO:: FETCH_ASSOC))
                          {
                            $check_no = $rowCheck['check_no'];
                            $cv_no = $rowCheck['cv_no'];
                            $amount = number_format(intval($rowCheck['cv_amount']), 2);
                            $tax = number_format(intval($rowCheck['tax']), 2);
                          }      
                          //date format
                          $date_release = date('m/d/Y', strtotime($row['date_release']));                              
                          $due = date('m/d/Y', strtotime($row['due_date']));                              
                          $action = '<button class="btn-sm btn-success received" value="'.$row['po-id'].'"><i class="fas fa-check"></i></button>
                          <button class="btn-sm btn-danger return" value="'.$row['po-id'].'"><i class="fas fa-times-circle"></i></button>';
                          echo '
                          <tr>
                            <td><input type="checkbox" name="checklist1" class="checklist1" value="'.$row['po-id'].'"></td>
                            <td>'.$action.'</td>
                            <td>'.$row['or_num'].'</td>
                            <td>'.$row['si_num'].'</td>
                            <td>'.$comp_name.'</td>
                            <td style="width: 180px">'.$sup_name.'</td>
                            <td>'.$cv_no.'</td>
                            <td>'.$check_no.'</td>
                            <td>'.$amount.'</td>
                            <td>'.$tax.'</td>
                            <td>'.$row['po_num'].'</td>
                            <td>'.$due.'</td>
                            <td>'.$proj_name.'</td>
                            <td>'.$date_release.'</td>
                          </tr>';
                        }
                      ?>
                      </tbody>
                    </table> 
                  </div>
                  <!-- RETURNED TABLE -->
                  <div id="tblReturn" class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover DataTable">
                      <thead class="thead-light">
                        <tr>
                        <th style="max-width: 2%"><input type="checkbox" class="checkboxall2"/><span class="checkmark"></span></th>
                          <th><center>Action</center></th>
                          <th>OR #</th>
                          <th>SI #</th>
                          <th>Company</th>
                          <th>Payee</th>
                          <th>CV #</th>
                          <th>Check #</th>
                          <th>CV Amount</th>
                          <th>Tax</th>
                          <th>PO/JO #</th>
                          <th>Due Date</th>
                          <th>Project</th>
                          <th>Released Date</th>
                        </tr>
                      </thead>
                      <tbody id="return-body">
                      <?php
                        $view = $po->get_returned_comp();
                        while($row = $view->fetch(PDO::FETCH_ASSOC))
                        {
                          //get the COMPANY name if exist
                          $comp_name = '-';
                          $company->id = $row['comp-id'];
                          $get2 = $company->get_company_detail();
                          while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
                          {
                            if($row['comp-id'] == $rowComp['id']){
                              $comp_name = $rowComp['company'];
                            }
                          }
                          //get the SUPPLIER name if exist
                          $sup_name = '-';
                          $supplier->id = $row['supp-id'];
                          $get3 = $supplier->get_supplier_details();
                          while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
                          {
                            if($row['supp-id'] == $rowSupp['id']){
                              $sup_name = $rowSupp['supplier_name'];
                            }
                          }
                          $proj_name = '-';
                          //get the PROJECT name if exist
                          $project->id = $row['proj-id'];
                          $get1 = $project->get_proj_details();
                          while($rowProj = $get1->fetch(PDO::FETCH_ASSOC))
                          {
                            if($row['proj-id'] == $rowProj['id']){
                              $proj_name = $rowProj['project'];
                            }
                          }
                          //get the check details
                          $check_no = '-';
                          $amount = '-';
                          $tax = '-';
                          $cv_no = '-';
                          $get4 = $check_details->get_details_byID($row['po-id']);
                          while($rowCheck = $get4->fetch(PDO:: FETCH_ASSOC))
                          {
                            $check_no = $rowCheck['check_no'];
                            $cv_no = $rowCheck['cv_no'];
                            $amount = number_format(intval($rowCheck['cv_amount']), 2);
                            $tax = number_format(intval($rowCheck['tax']), 2);
                          }
                          //date format
                          $date_release = date('m/d/Y', strtotime($row['date_release']));                              
                          $due = date('m/d/Y', strtotime($row['due_date']));                              
                          $action = '<button class="btn-sm btn-success received" value="'.$row['po-id'].'"><i class="fas fa-check"></i></button>';
                          echo '
                          <tr>
                            <td><input type="checkbox" name="checklist2" class="checklist2" value="'.$row['po-id'].'"></td>
                            <td>'.$action.'</td>
                            <td>'.$row['or_num'].'</td>
                            <td>'.$row['si_num'].'</td>
                            <td>'.$comp_name.'</td>
                            <td style="width: 180px">'.$sup_name.'</td>
                            <td>'.$cv_no.'</td>
                            <td>'.$check_no.'</td>
                            <td>'.$amount.'</td>
                            <td>'.$tax.'</td>
                            <td>'.$row['po_num'].'</td>
                            <td>'.$due.'</td>
                            <td>'.$proj_name.'</td>
                            <td>'.$date_release.'</td>
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
<!-- RECEIVING notification Modal -->
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
        <div id="notf-msg" style="font-size: 18px;">Are you sure you want to accept this request?</div>
        <input id="po-id" class="form-control" style="display: none;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel</button>
        <button id="btnSubmit" class="btn btn-success" onclick="received_request()"><i class="fas fa-check-circle"></i> Accept</button>
      </div>
    </div>
  </div>
</div>
<!-- RETURNED notification Modal -->
<div class="modal fade" id="returnedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
        <div id="notf-msg" style="font-size: 18px;">Please input your reason of declining this request</div>
        <textarea id="reason" class="form-control" row="4"></textarea>
        <input id="return-id" class="form-control" style="display:none">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel</button>
        <button id="btnSubmit" class="btn btn-danger" onclick="return_request()"><i class="fas fa-times-circle"></i> Mark As Return</button>
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
<?php include 'js/dashboard-js.php';?>

</body>
</html>