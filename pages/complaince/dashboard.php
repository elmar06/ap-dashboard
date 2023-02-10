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
    <?php include '../../includes/verify.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Accounting</a></li>
              <li class="breadcrumb-item active" aria-current="page">Treasury</li>
            </ol>
          </div><!-- /Breadcrumbs -->
          <!-- Pending Card -->
          <div id="page-body">
            <div class="row mb-3">
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">For Verification</div>
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_for_verification();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
                        ?>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#" onclick="get_for_verification()"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-certificate fa-2x text-info"></i>
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
                        <div class="text-xs font-weight-bold text-uppercase mb-1">On Hold</div>
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_on_hold();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
                        ?>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#" onclick="get_on_hold()"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-pause-circle fa-2x text-danger"></i>
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
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_releasing();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['releasing-count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
                        ?>
                        <div class="mt-2 mb-0 text-muted text-xs">
                          <a class="text-success mr-2" href="#" onclick="get_releasing()"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Total Released PO/JO Card-->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Released</div>
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_released();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['released-count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
                        ?>
                        <div class="mt-2 mb-0 text-muted text-xs">
                          <a class="text-success mr-2" href="released.php"><i class="fas fa-arrow-up"></i> More Details</a>
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
            <div>
              <a type="button" class="btn btn-primary mb-1" href="#" onclick="mark_on_hold()"><i class="fas fa-hand-paper"></i> Hold Check</a>
              <a type="button" class="btn btn-success mb-1" href="#" onclick="mark_for_releasing()"><i class="fas fa-check-square"></i> Mark as for Releasing</a>
            </div><br>
            <!-- DataTable with Hover -->
            <div class="row mb-3">
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover" id="req-table">
                      <thead class="thead-light">
                        <tr>
                        <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                          <th><center>Status</center></th>
                          <th>CV #</th>
                          <th>Check #</th>
                          <th>CV Amount</th>
                          <th>Company</th>
                          <th>PO/JO #</th>
                          <th>Suppplier</th>
                          <th>Due Date</th>
                          <th>Received by FO</th>
                          <th>Project</th>
                        </tr>
                      </thead>
                      <tbody id="req-body">
                      <?php
                        //get the user company access
                        $access->user_id = $user_id;
                        $get = $access->get_company();
                        while($row1 = $get->fetch(PDO::FETCH_ASSOC))
                        {
                          //get the access company id
                          $id = $row1['comp-access'];
                          $array_id = explode(',', $id);
                          foreach($array_id as $value)
                          {
                            $comp_id =  $value; 
                            //display all the data by access
                            $po->company = $comp_id;
                            $view = $po->get_list_checker();
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
                              $proj_name = '';
                              //get the PROJECT name if exist
                              $project->id = $row['proj-id'];
                              $get1 = $project->get_proj_details();
                              while($rowProj = $get1->fetch(PDO::FETCH_ASSOC))
                              {
                                if($row['proj-id'] == $rowProj['id']){
                                  $proj_name = $rowProj['project'];
                                }
                              }
                              //format of status
                              if($row['status'] == 4){
                                $status = '<label style="color: blue"><b>On Process by BO</b></label>';
                              }elseif($row['status'] == 5){
                                $status = '<label style="color: blue"><b>For Signature</b></label>';
                              }elseif($row['status'] == 6){
                                $status = '<label style="color: blue"><b>Sent To EA</b></label>';
                              }elseif($row['status'] == 7){
                                $status = '<label style="color: blue"><b>Signed</b></label>';
                              }elseif($row['status'] == 8){
                                $status = '<label style="color: blue"><b>For Verification</b></label>';
                              }elseif($row['status'] == 9){
                                $status = '<label style="color: red"><b>On Hold</b></label>';
                              }else
                              {
                                $status = '<label style="color: green"><b>For Releasing</b></label>';
                              }
                              //date format
                              $due = date('m/d/Y', strtotime($row['due_date']));
                              if($row['date_received_fo'] != null || $row['date_received_fo'] != ''){
                                $received_fo = date('m/d/Y', strtotime($row['date_received_fo']));
                              }else{
                                $received_fo = '-';
                              }
                              
                              echo '
                              <tr>
                                <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                                <td style="width: 95px"><center>'.$status.'</center></td>
                                <td>'.$row['cv_no'].'</td>
                                <td>'.$row['check_no'].'</td>
                                <td>'.number_format(floatval($row['cv_amount']), 2).'</td>
                                <td>'.$comp_name.'</td>
                                <td>'.$row['po_num'].'</td>
                                <td style="width: 180px">'.$sup_name.'</td>
                                <td>'.$due.'</td>
                                <td>'.$received_fo.'</td>
                                <td>'.$proj_name.'</td>
                              </tr>';
                            }
                          }
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