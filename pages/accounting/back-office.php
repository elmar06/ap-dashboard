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

  <style>
    .card-height {
      height: 110px;
    }
  </style>
</head>

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
          <li class="breadcrumb-item active" aria-current="page">Dashboard (Back Office)</li>
        </ol>
      </div><!-- /Breadcrumbs -->
      <!-- Pending Card -->
      <div id="page-body">
        <div class="row">
          <!-- Total Submitted PO/JO Card-->
          <div class="col-xl-2 col-md-3 mb-3 card-height">
            <div class="card h-100">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">For Receiving</div>
                    <?php
                      //check the for receiving po by company
                      $total = 0;
                      $id = $_SESSION['company'];
                      $array_id = explode(',', $id);
                      foreach ($array_id as $key=>$value) {
                        $subtotal = 0;
                        $comp_id =  $value;
                        $po->company = $comp_id;
                        $count = $po->count_for_receive_bo();
                        while($row = $count->fetch(PDO::FETCH_ASSOC)) {
                          $subtotal = $row['receiving-count']; 
                        }
                        $total += $subtotal;
                      }
                      echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $total . '</div>';
                    ?>
                    <div class="mt-2 mb-0 text-muted text-xs">
                      <a class="text-success mr-2" href="#" onclick="get_for_receiving()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-2 col-md-3 mb-3 card-height">
            <div class="card h-100">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">For BO Processing</div>
                    <?php
                      //check the for receiving po by company
                      $total = 0;
                      $id = $_SESSION['company'];
                      $array_id = explode(',', $id);
                      foreach ($array_id as $key=>$value) {
                        $subtotal = 0;
                        $comp_id =  $value;
                        $po->company = $comp_id;
                        $count = $po->count_for_process_bo();
                        while($row = $count->fetch(PDO::FETCH_ASSOC)) {
                          $subtotal = $row['pending-count']; 
                        }
                        $total += $subtotal;
                      }
                      echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $total . '</div>';
                    ?>
                    <div class="mt-2 mb-0 text-muted text-xs">
                      <a class="text-success mr-2" href="#" onclick="get_for_processing()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-file-contract fa-2x text-danger"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- COUNT THE FORWARDED PO/JO FROM MANILA -->
          <div class="col-xl-2 col-md-3 mb-3 card-height">
            <div class="card h-100">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Forwarded from Manila</div>
                    <?php
                      //check the for receiving po by company
                      $total = 0;
                      $id = $_SESSION['company'];
                      $array_id = explode(',', $id);
                      foreach ($array_id as $key=>$value) {
                        $subtotal = 0;
                        $comp_id =  $value;
                        $po->company = $comp_id;
                        $count = $po->count_from_manila();
                        while($row = $count->fetch(PDO::FETCH_ASSOC)) {
                          $subtotal = $row['count']; 
                        }
                        $total += $subtotal;
                      }
                      echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $total . '</div>';
                    ?>
                    <div class="mt-2 mb-0 text-muted text-xs">
                      <a class="text-success mr-2" href="#" onclick="get_from_manila()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                  </div>
                  <div class="col-auto">
                  <i class="fa-solid fa-paper-plane-top fa-2x text-primary"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Received by Accounting Payable -->
          <div class="col-xl-2 col-md-3 mb-3 card-height">
            <div class="card h-100">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">For Signature</div>
                    <?php
                      //check the for receiving po by company
                      $total = 0;
                      $id = $_SESSION['company'];
                      $array_id = explode(',', $id);
                      foreach ($array_id as $key=>$value) {
                        $subtotal = 0;
                        $comp_id =  $value;
                        $po->company = $comp_id;
                        $count = $po->count_for_signature();
                        while($row = $count->fetch(PDO::FETCH_ASSOC)) {
                          $subtotal = $row['count']; 
                        }
                        $total += $subtotal;
                      }
                      echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $total . '</div>';
                    ?>
                    <div class="mt-2 mb-0 text-muted text-xs">
                      <a class="text-success mr-2" href="for_signature.php"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-file-signature fa-2x text-warning"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- For Releasing Card -->
          <div class="col-xl-2 col-md-3 mb-3 card-height">
            <div class="card h-100">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">On Hold</div>
                    <?php
                      //check the for receiving po by company//check the for receiving po by company
                      $total = 0;
                      $id = $_SESSION['company'];
                      $array_id = explode(',', $id);
                      foreach ($array_id as $key=>$value) {
                        $subtotal = 0;
                        $comp_id =  $value;
                        $po->company = $comp_id;
                        $count = $po->count_on_hold();
                        while($row = $count->fetch(PDO::FETCH_ASSOC)) {
                          $subtotal = $row['count']; 
                        }
                        $total += $subtotal;
                      }
                      echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $total . '</div>';
                    ?>
                    <div class="mt-2 mb-0 text-muted text-xs">
                      <a class="text-success mr-2" href="#" onclick="get_for_verification()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-check-double fa-2x text-info"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- end of card row -->
        <div class="row mb-3">
          <div class="col-lg-12">
            <button id="btnAllReceive" class="btn btn-success mb-1" onclick="mark_all_received()" disabled><i class="fas fa-check-circle"></i> Mark Receive</button>
            <button id="btnCreate" class="btn btn-primary mb-1" data-toggle="modal" data-target="#createCV"><i class="fas fa-plus-square"></i> Create Multi CV</button>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="table1-responsive p-3">
                <table class="table1 align-items-center table-flush table-hover tableData">
                  <thead class="thead-light">
                    <tr>
                      <th style="max-width: 2%"><input type="checkbox" class="checkboxall" /><span class="checkmark"></span></th>
                      <th>
                        <center>Action</center>
                      </th>
                      <th>Company</th>
                      <th>PO/JO #</th>
                      <th>SI #</th>
                      <th>Supplier</th>
                      <th>Billing Date</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody id="req-body">
                    <?php
                    //get the user company access
                    $access->user_id = $user_id;
                    $get = $access->get_company();
                    while ($row1 = $get->fetch(PDO::FETCH_ASSOC)) {
                      //get the access company id
                      $id = $row1['comp-access'];
                      $array_id = explode(',', $id);
                      foreach ($array_id as $value) {
                        $comp_id =  $value;
                        //display all the data by access
                        $po->company = $comp_id;
                        $view = $po->get_all_process_bo();
                        while ($row = $view->fetch(PDO::FETCH_ASSOC)) {
                          //check if the request is a multi cv

                          //date format
                          $bill_date = date('m/d/y', strtotime($row['bill_date']));
                          if ($row['status'] == 3) {
                            $action = '<a href="#" class="btn-sm btn-success btnReceived" onclick="mark_received_bo('.$row['po-id'].')"><i class="fas fa-hand-holding"></i> Received</a> <a href="#" class="btn-sm btn-danger return" value="' . $row['po-id'] . '"><i class="fas fa-undo-alt"></i> Return</a>';
                          } elseif ($row['status'] == 15) {
                            $action = '<a href="#" class="btn-sm btn-info upd-cv" value="' . $row['po-id'] . '"><i class="fas fa-pencil-alt"></i> Update CV</a> <a href="#" class="btn-sm btn-danger return" value="' . $row['po-id'] . '"><i class="fas fa-undo-alt"></i> Return</a>';
                          } elseif ($row['status'] == 20) {
                            $action = '<a href="#" class="btn-sm btn-info edit" value="' . $row['po-id'] . '"><i class="fas fa-edit"></i> For Reprocess (Staled Check)</a>';
                          } elseif ($row['status'] == 21) {
                            $action = '<a href="#" class="btn-sm btn-warning edit" value="' . $row['po-id'] . '"><i class="fas fa-edit"></i> For Reprocess (Cancelled Check)</a>';
                          } else {
                            $action = '<a href="#" class="btn-sm btn-primary edit" value="' . $row['po-id'] . '"><i class="fas fa-edit"></i> Create CV</a> <a href="#" class="btn-sm btn-danger return" value="' . $row['po-id'] . '"><i class="fas fa-undo-alt"></i> Return</a>';
                          }

                          //get the COMPANY name if exist
                          $comp_name = '-';
                          $company->id = $row['comp-id'];
                          $get2 = $company->get_company_detail();
                          while ($rowComp = $get2->fetch(PDO::FETCH_ASSOC)) {
                            if ($row['comp-id'] == $rowComp['id']) {
                              $comp_name = $rowComp['company'];
                            }
                          }
                          //get the SUPPLIER name if exist
                          $sup_name = '-';
                          $supplier->id = $row['supp-id'];
                          $get3 = $supplier->get_supplier_details();
                          while ($rowSupp = $get3->fetch(PDO::FETCH_ASSOC)) {
                            if ($row['supp-id'] == $rowSupp['id']) {
                              $sup_name = $rowSupp['supplier_name'];
                            }
                          }
                          echo '
                          <tr>
                            <td style="max-width: 2%"><input type="checkbox" name="checklist" class="checklist" value="' . $row['po-id'] . '"></td>
                            <td><center>' . $action . '</center></td>
                            <td>' . $comp_name . '</td>
                            <td>' . $row['po_num'] . '</td>
                            <td>' . $row['si_num'] . '</td>
                            <td>' . $sup_name . '</td>
                            <td style="max-width: 20%">' . $bill_date . '</td>
                            <td>' . number_format(floatval($row['amount']), 2) . '</td>                               
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
        </div>
      </div><!-- /page-body -->
    </div>
  </div><!-- /wrapper -->
  <!-- Footer -->
  <?php include '../../includes/footer.php'; ?>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- View Details Modal -->
  <div class="modal fade" id="POmodalDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="details-body" class="modal-body">
          <!-- modal body goes here -->
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button id="btnForward" class="btn btn-success" onclick="forwardToCebu()">Forward to Cebu</button>
          <button id="btnSubmit" class="btn btn-primary" onclick="submitForSignature()">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <!-- View Details Modal -->
  <div class="modal fade" id="editPOmodalDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="update-body" class="modal-body">
          <!-- modal body goes here -->
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button id="btnUpdate" class="btn btn-success" onclick="receivedFromManila()">Received</button>
          <button id="btnUpdate" class="btn btn-primary" onclick="updForSignature()">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Create one CV in multiple request Modal -->
  <div class="modal fade" id="createCV" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="check-details">
            <small><b><i>Check Information</i></b></small>
            <div class="row">
              <div class="col-lg-6">
                <label><i style="color: red">*</i> CV Number:</label>
                <input id="multi-cv-no" class="form-control mb-3" type="text" placeholder="Enter CV Number">
              </div>
              <div class="col-lg-6">
                <label><i style="color: red">*</i> Check Number:</label>
                <input id="multi-check-no" class="form-control mb-3" type="text" placeholder="Enter Check Number">
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <label><i style="color: red">*</i> Bank:</label>
                <select id="multi-bank" class="form-control mb-3 select2" style="width: 100%;">
                  <option selected disabled>Select a Bank</option>
                  <?php
                  $get = $bank->get_all_banks();
                  while ($row5 = $get->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row5['id'] . '">' . $row5['account'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-lg-6">
                <label><i style="color: red">*</i> Check Date:</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                  </div>
                  <input id="multi-checkdate" class="form-control datepicker" placeholder="Enter Check Date">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 mb-3">
                <label><i style="color: red">*</i> Select a PO/JO number to process:</label>
                <select id="multiReq" class="form-control mb-3 basic-multiple" multiple="multiple" style="width: 100%;" onchange="get_amount()">
                  <?php
                  $view = $po->get_all_for_process();
                  while ($row = $view->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['po-id'] . '">SI Num: ' . $row['si_num'] . '</option>';
                  }
                  // //get the user company access
                  // $access->user_id = $user_id;
                  // $get = $access->get_company();
                  // while($row1 = $get->fetch(PDO::FETCH_ASSOC))
                  // {
                  //   //get the access company id
                  //   $id = $row1['comp-access'];
                  //   $array_id = explode(',', $id);
                  //   foreach($array_id as $value)
                  //   {
                  //     $comp_id =  $value; 
                  //     //display all the data by access
                  //     $po->company = $comp_id;

                  //   }
                  // }
                  ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <label><i style="color: red">*</i> Total Amount:</label>
                <input id="multi-Amount" class="form-control mb-3" type="text" placeholder="Total Amount" disabled>
              </div>
              <div class="col-lg-6">
                <label><i style="color: red">*</i> Withholding Tax:</label>
                <input id="multi-Tax" class="form-control mb-3" type="text" placeholder="Amount">
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <label><i style="color: red">*</i> CV Amount:</label>
                <input id="multi-cvAmount" class="form-control mb-3" type="text" placeholder="CV Amount">
              </div>
              <div class="col-lg-12">
                <div id="success" class="alert alert-success" role="alert" style="display: none"></div>
                <div id="warning" class="alert alert-danger" role="alert" style="display: none"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button id="btnMultiForward" class="btn btn-success" onclick="forwardToCebuMulti()">Forward to Cebu</button>
          <button id="btnSubmit" class="btn btn-primary" onclick="submit_cv()">Submit</button>
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
  <?php include 'js/backOffice-js.php'; ?>

</body>

</html>