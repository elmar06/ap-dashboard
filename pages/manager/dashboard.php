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
  <link href="../../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../../assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/toastr/toastr.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/manager.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Manager</a></li>
              <li class="breadcrumb-item active" aria-current="page">Manager's Dashboard</li>
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
                      <?php
                        //check the for receiving po by company
                        $total = 0;
                        $id = $_SESSION['company'];
                        $array_id = explode(',', $id);
                        foreach ($array_id as $key=>$value) {
                          $subtotal = 0;
                          $comp_id =  $value;
                          $po->company = $comp_id;
                          $count = $po->count_pending();
                          while($row = $count->fetch(PDO::FETCH_ASSOC)) {
                            $subtotal = $row['pending-count']; 
                          }
                          $total += $subtotal;
                        }
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $total . '</div>';
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
            <!-- Received by Accounting Payable -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Returned</div>
                      <?php
                        //check the for receiving po by company
                        $total = 0;
                        $id = $_SESSION['company'];
                        $array_id = explode(',', $id);
                        foreach ($array_id as $key=>$value) {
                          $subtotal = 0;
                          $comp_id =  $value;
                          $po->company = $comp_id;
                          $count = $po->count_return();
                          while($row = $count->fetch(PDO::FETCH_ASSOC)) {
                            $subtotal = $row['return-count']; 
                          }
                          $total += $subtotal;
                        }
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$total.'</div>';
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
                      <div class="text-xs font-weight-bold text-uppercase mb-1">In Process</div>
                      <?php
                        //check the for receiving po by company
                        $total = 0;
                        $id = $_SESSION['company'];
                        $array_id = explode(',', $id);
                        foreach ($array_id as $key=>$value) {
                          $subtotal = 0;
                          $comp_id =  $value;
                          $po->company = $comp_id;
                          $count = $po->count_on_process();
                          while($row = $count->fetch(PDO::FETCH_ASSOC)) {
                            $subtotal = $row['process-count']; 
                          }
                          $total += $subtotal;
                        }
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$total.'</div>';
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
                        //check the for receiving po by company
                        $total = 0;
                        $id = $_SESSION['company'];
                        $array_id = explode(',', $id);
                        foreach ($array_id as $key=>$value) {
                          $subtotal = 0;
                          $comp_id =  $value;
                          $po->company = $comp_id;
                          $count = $po->count_releasing();
                          while($row = $count->fetch(PDO::FETCH_ASSOC)) {
                            $subtotal = $row['releasing-count']; 
                          }
                          $total += $subtotal;
                        }
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$total.'</div>';
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
              <button type="button" class="btn btn-danger" id="btnClear" style="display: none" onclick="clear_list()"> Clear Search</button>
            </div>
          </div>
          <div id="req-list" class="row mb-3">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table1-responsive p-3">
                  <table id="submitted-table" class="table1 align-items-center table-flush table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th hidden><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                        <!-- <th><center>Action</center></th> -->
                        <th><center>Status</center></th>
                        <th>Accepted (FO)</th>
                        <th>Accepted (BO)</th>
                        <!-- <th>SI No</th> -->
                        <th>CV No</th>
                        <th>Check Date</th>
                        <th>Check No</th>                        
                        <th>Project</th>
                        <th>Company</th>
                        <th>PO/JO No</th>
                        <th>Payee</th>
                        <th>Amount</th>
                        <th>Sent to EA</th>
                        <th>Received from EA</th>
                      </tr>
                    </thead>
                    <tbody id="req-body">
                    <?php
                      //get the user company access
                      $access->user_id = $_SESSION['id'];
                      $get = $access->get_company();
                      while($row1 = $get->fetch(PDO::FETCH_ASSOC))
                      { 
                        //get the access company id
                        $id = $row1['comp-access'];
                        $array_id = explode(',', $id);
                        foreach($array_id as $value)
                        {
                          $po->company = $value;
                          $view = $po->get_submitted_po_monitoring();
                          while($row = $view->fetch(PDO::FETCH_ASSOC))
                          {
                            //get all the check details if exist
                            $cv_num = '-';
                            $check_date = '-';
                            $check_no = '-';
                            $cv_amount = '-';
                            $si_num = '-';
                            //get the check details
                            //$check_details->po_id = $row['po-id'];
                            $get_check = $check_details->get_check_details_byID($row['po-id']);
                            while($row2 = $get_check->fetch(PDO:: FETCH_ASSOC))
                            {   
                              //check if the check need to mark as stale
                              $date_now = new DateTime(date('Y-m-d'));
                              $date_check = new DateTime(date('Y-m-d', strtotime($row2['check_date'])));  
                              //calculate the date difference
                              $no_days = $date_now->diff($date_check)->days;
                              if($no_days >= 170){
                                //color code (orange)
                                $cv_num = '<span style="color: #e9680f"><b>'.$row2['cv_no'].'</b></span>';
                                $check_date = '<span style="color: #e9680f"><b>'.date('m/d/y', strtotime($row2['check_date'])).'</b></span>';
                                $check_no = '<span style="color: #e9680f"><b>'.$row2['check_no'].'</b></span>';
                                $cv_amount = number_format($row2['cv_amount'], 2); 
                              }else{
                                $cv_num = $row2['cv_no'];
                                $check_date = date('m/d/y', strtotime($row2['check_date']));
                                $check_no = $row2['check_no'];
                                $cv_amount = number_format($row2['cv_amount'], 2); 
                              }      
                            }
                            //get the date sent to EA(po_other_details) 
                            $date_ea = '-';
                            $received_fo = '-';
                            $received_bo = '-';
                            $from_ea = '-';
                            $po->po_id = $row['po-id'];
                            $get_date = $po->get_other_details();
                            while($row3 = $get_date->fetch(PDO:: FETCH_ASSOC))
                            {
                              //date sent to EA
                              if($row3['date_to_ea'] != null){
                                $date_ea = date('m/d/y', strtotime($row3['date_to_ea']));
                              }
                              //date accepted by FO
                              if($row3['date_received_fo'] != null){
                                $received_fo = date('m/d/Y', strtotime(($row3['date_received_fo'])));
                              }
                              //date accepted by FO
                              if($row3['date_received_bo'] != null){
                                $received_bo = date('m/d/Y', strtotime(($row3['date_received_bo'])));
                              }
                              //date returned by EA
                              if($row3['date_from_ea'] != null){
                                $from_ea = date('m/d/Y', strtotime(($row3['date_from_ea'])));
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
                            $comp_name = '-';
                            //get the COMPANY name if exist
                            $company->id = $row['comp-id'];
                            $get2 = $company->get_company_detail();
                            while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
                            {
                              if($row['comp-id'] == $rowComp['id']){
                                $comp_name = $rowComp['company'];
                              }
                            }
                            $sup_name = '-';
                            //get the SUPPLIER name if exist
                            $supplier->id = $row['supp-id'];
                            $get3 = $supplier->get_supplier_details();
                            while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
                            {
                              if($row['supp-id'] == $rowSupp['id']){
                                $sup_name = $rowSupp['supplier_name'];
                              }
                            }
                            //format of status
                            if($row['status'] == 1){
                              $status = '<label style="color: red"><b> Pending</b></label>';
                            }else if($row['status'] == 2){
                              $status = '<label style="color: orange"><b> Returned</b></label>';
                            }else if($row['status'] == 3){
                              $status = '<label style="color: blue"><b> Received by FO</b></label>';
                            }else if($row['status'] == 4){
                              $status = '<label style="color: blue"><b> Received by BO</b></label>';
                            }elseif($row['status'] == 5){
                              $status = '<label style="color: blue"><b> For Signature</b></label>';
                            }elseif($row['status'] == 6){
                              $status = '<label style="color: blue"><b> Sent to EA</b></label>';
                            }elseif($row['status'] == 7){
                              $status = '<label style="color: blue"><b> Signed</b></label>';
                            }elseif($row['status'] == 8){
                              $status = '<label style="color: blue"><b> For Verification</b></label>';
                            }elseif($row['status'] == 9){
                              $status = '<label style="color: red"><b> On Hold</b></label>';
                            }else if($row['status'] == 10){
                              $status = '<label style="color: green"><b> For Releasing</b></label>';
                            }else if($row['status'] == 11){
                              $status = '<label style="color: green"><b> Released</b></label>';
                            }elseif($row['status'] == 15){
                              $status = '<label style="color: blue"><b> Forwarded to Cebu</b></label>';
                            }elseif($row['status'] == 16){
                              $status = '<label style="color: red"><b> Cancelled Check</b></label>';
                            }elseif($row['status'] == 20){
                              $status = '<label style="color: orange"><b> Staled Check</b></label>';
                            }else{
                              $status = '<label style="color: blue"><b> In Process</b></label>';
                            }
                            //action button
                            $action = '<a class="btn btn-danger btn-sm bntCancel" href="#" value="'.$row['po-id'].'"><i class="fa-sharp fa-solid fa-ban"></i> Cancel</a>';
                            
                            echo '
                            <tr>
                              <td hidden><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                              <td><center>'.$status.'</center></td>
                              <td><center>'.$received_fo.'</center></td>
                              <td><center>'.$received_bo.'</center></td>                        
                              <td align="center">'.$cv_num.'</td>
                              <td align="center">'.$check_date.'</td>
                              <td align="center">'.$check_no.'</td>
                              <td align="center">'.$proj_name.'</td>
                              <td>'.$comp_name.'</td>
                              <td>'.$row['po_num'].'</td>
                              <td>'.$sup_name.'</td>
                              <td align="center">'.$cv_amount.'</td>
                              <td align="center">'.$date_ea.'</td> 
                              <td align="center">'.$from_ea.'</td>                                    
                            </tr>';
                          }
                        }
                      }
                      ?>
                    </tbody>
                  </table> 
                </div>
              </div>
            </div>     
          </div><!-- /end of req-table-->
      </div><!---/Container-Fluid-->
  </div><!-- /wrapper -->
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
        <button id="btnEdit" class="btn btn-info" onclick="EnableFields()">Edit</button>
        <button id="btnSubmit" class="btn btn-primary" onclick="upd_po_details()">Resubmit</button>
      </div>
    </div>
  </div>
</div>

<!-- process modal -->
<div class="modal fade" id="viewProcessReq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DisableFields()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="process-body" class="modal-body">
        <!-- modal body goes here -->
      </div>
      <div class="modal-footer">
        <?php
          if($_SESSION['id'] == 4 || $_SESSION['id'] == 5 || $_SESSION['id'] == 53)//button visible only for this users
          {
            echo '<button id="btnStale" class="btn btn-warning" onclick="mark_stale()"><i class="fa-solid fa-barcode-scan"></i> Mark as Stale</button>
                  <button id="btnCancel" class="btn btn-danger" onclick="mark_cancel()"><i class="fa-solid fa-ban"></i> Mark as Cancel</button>';
          }
        ?>
        <button id="btnToManila" class="btn btn-primary" onclick="showManilaModal()"><i class="fa-solid fa-paper-plane"></i> Forward to Manila</button>
        <button id="btnToManila" class="btn btn-success" onclick="markPrio()"><i class="fa-solid fa-bell-on"></i> Mark as Prio</button>
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
        <button id="btnPrio" class="btn btn-success" onclick="markPrio()"><i class="fa-solid fa-bell-on"></i> Mark as Prio</button>
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
<script src="../../assets/js/jquery.toast.js"></script>
  <script src="../../assets/vendor/toastr/toastr.js"></script>
<?php include 'js/dashboard-js.php';?>

</body>
</html>