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
  <link href="../../assets/vendor/toastr/toastr.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/datetimepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/ea.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Executive Assistant</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div><!-- /Breadcrumbs -->
          <div id="page-body">
            <div class="row mb-3">
              <!-- FOR RECEIVING -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">For Receiving</div>
                        <?php
                          $count = $po->count_for_receiving_ea();
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
                        <i class="fas fa-hand-holding fa-2x text-success"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- FOR SIGNATURE -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">For Signature</div>
                        <?php
                          $count = $po->count_for_signature();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
                        ?>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#" onclick="get_for_signature()"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-file-signature fa-2x text-danger"></i>
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
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Signed</div>
                        <?php
                          $count = $po->count_signed();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
                        ?>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#" onclick="get_signed()"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-retweet fa-2x text-warning"></i>
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
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Return to AP Team</div>
                        <?php
                          $count = $po->count_return_from_ea();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
                        ?>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="return.php"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-info"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- end of card row -->
            <!-- TAB PANELS -->
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#receivingTab" role="presentation">For Receiving</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#receivedTab" role="presentation">Received</a>
              </li>
            </ul><br>
            <div class="tab-content tabcontent-border">
              <!-- TAB PANEL FOR RECEIVING -->
              <div class="tab-pane active" role="tabpanel" id="receivingTab">
                <div class="row mb-3">
                  <div class="col-lg-12">
                  <div>
                    <a id="btnMultiReceived" type="button" class="btn btn-success mb-1" href="#" onclick="mark_multi_received_ea()" style="display: none;"><i class="fas fa-hand-holding"></i> Mark as Received</a>
                  </div><br>
                    <div class="card mb-4">
                      <div class="table1-responsive p-3">
                        <table id="receiving" class="table1 align-items-center table-flush table-hover DataTable">
                          <thead class="thead-light">
                            <tr>
                              <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                              <th><center>Action</center></th>
                              <th>Date Forwarded</th>
                              <th>CV No</th>
                              <th>Check #</th>
                              <th>CV Amount</th>
                              <th>Suppplier</th>
                              <th>Company</th>
                              <th>PO/JO #</th>                                                            
                            </tr>
                          </thead>
                          <tbody id="receiving-body">
                          <?php
                            $po->submitted_by = $_SESSION['id'];
                            $view = $po->get_for_receiving_ea();
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
                              $forward_date = date('m/d/Y', strtotime($row['date_to_ea']));
                              //initialize action
                              $action = '<button class="btn-sm btn-success mb-1 btnReceived" type="button" value="'.$row['po-id'].'"><i class="fas fa-hand-holding"></i> Received</button>';                              
                              echo '
                              <tr>
                                <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                                <td style="width: 95px"><center>'.$action.'</center></td>
                                <td><center>'.$forward_date.'</center></td>
                                <td>'.$row['cv_no'].'</td>
                                <td>'.$row['check_no'].'</td>
                                <td>'.number_format(floatval($row['cv_amount']),2).'</td>
                                <td style="width: 180px">'.$sup_name.'</td>  
                                <td>'.$comp_name.'</td>
                                <td>'.$row['po_num'].'</td>                                                             
                              </tr>';
                            }
                          ?>
                          </tbody>
                        </table> 
                      </div>
                    </div>
                  </div><!-- /column -->
                </div><!-- /row --> 
              </div>
              <!-- TAB PANEL FOR RECEIVED REQUEST -->
              <div class="tab-pane" role="tabpanel" id="receivedTab">
                <div class="row mb-3">
                  <div class="col-lg-12">
                    <div>
                      <!-- <a id="btnSigned" type="button" class="btn btn-success mb-1" href="#" onclick="mark_signed()"><i class="fas fa-check-circle"></i> Mark as Signed</a> -->
                      <a id="btnReturned" type="button" class="btn btn-primary mb-1" href="#" onclick="mark_returned()"><i class="fas fa-undo-alt"></i> Mark as Returned to AP</a>
                    </div><br>
                    <div class="card mb-4">
                      <div class="table1-responsive p-3">
                        <table  id="received" class="table1 table-flush table-hover DataTable">
                          <thead class="thead-light" style="width: 100%;">
                            <tr>
                              <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                              <th><center>Status</center></th>
                              <th>CV No</th>
                              <th>Check #</th>
                              <th>CV Amount</th>
                              <th>Company</th>
                              <th>PO/JO #</th>
                              <th>Suppplier</th>                              
                            </tr>
                          </thead>
                          <tbody id="received-body">
                          <?php
                            $po->submitted_by = $_SESSION['id'];
                            $view = $po->get_list_for_ea();
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
                              //format of status
                              if($row['status'] == 6)
                              {
                                $status = '<label style="color: red"><b> For Signature</b></label>';
                              }
                              else
                              {
                                $status = '<label style="color: green"><b> Signed</b></label>';
                              }
                              
                              echo '
                              <tr>
                                <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                                <td style="width: 95px"><center>'.$status.'</center></td>                                
                                <td>'.$row['cv_no'].'</td>
                                <td>'.$row['check_no'].'</td>
                                <td>'.number_format(floatval($row['cv_amount']),2).'</td>
                                <td>'.$comp_name.'</td>
                                <td>'.$row['po_num'].'</td>
                                <td style="width: 180px">'.$sup_name.'</td>
                              </tr>';
                            }
                          ?>
                          </tbody>
                        </table> 
                      </div>
                    </div>
                  </div><!-- /column -->
                </div><!-- /row --> 
              </div><!-- /tab content -->
            </div> <!-- /tab panel content -->
          </div><!-- /page-body -->   
    </div><!-- /container-wrapper-->
  </div><!-- /wrapper -->
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<script src="../../assets/vendor/jquery/jquery.min.js"></script>
<script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../../assets/js/ruang-admin.min.js"></script>
<script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/vendor/datetimepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../assets/vendor/select2/js/select2.full.min.js"></script>
<script src="../../assets/vendor/select2/js/select2.min.js"></script>
<script src="../../assets/vendor/toastr/toastr.js"></script>
<script src="../../assets/js/jquery.toast.js"></script>
<?php include 'js/dashboard-js.php';?>

</body>
</html>