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
  <link href="../../assets/css/ruang-admin.css" rel="stylesheet">
  <link href="../../assets/vendor/dataTables1/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/datetimepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/toastr/toastr.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/backOffice.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Accounting Payables</a></li>
              <li class="breadcrumb-item active" aria-current="page">Released Check (Back Office)</li>
            </ol>
          </div><!-- /Breadcrumbs -->
          <div id="page-body">
            <div class="row">
              <div class="col-lg-2">
                <a class="btn btn-primary btn-sm" style="width:100%" id="pills-release-btn" href="#">Released Check</a>
              </div>
              <div class="col-lg-2">
                <a class="btn btn-info btn-sm" style="width:100%" id="pills-forwarded-btn" href="#">Forwarded to Compliance</a>
              </div>
              <div class="col-lg-2">
                <a class="btn btn-success btn-sm" style="width:100%" id="pills-received-btn" href="#">Received by Compliance</a>
              </div>
              <div class="col-lg-2">
                <a class="btn btn-danger btn-sm" style="width:100%" id="pills-returned-btn" href="#">Returned by Compliance</a>
              </div>
            </div><br>
            <!-- RELEASED TAB -->
            <div class="row" id="pills-released">
              <div class="col-lg-12">
                <div id="btnDiv">
                  <a type="button" class="btn btn-success mb-1" href="#" onclick="forward_all()"><i class="fas fa-arrow-alt-circle-right"></i> Forward to Compliance</a>
                </div><br>
                <!-- DataTable with Hover -->
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="table1-responsive">
                      <table class="table1 align-items-center table-flush table-hover DataTable">
                        <thead class="thead-light">
                          <tr>
                            <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                            <th><center>OR #</center></th>
                            <th>Project</th>
                            <th>SI #</th>
                            <th>Check No</th>
                            <th>Company</th>
                            <th>PO/JO No</th>
                            <th>Payee</th>
                            <th>Amount</th>
                            <th><center>Date Released</center></th>
                          </tr>
                        </thead>
                        <tbody id="released-body">
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $view = $po->get_released_fo();
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
                            $release = date('m/d/Y', strtotime($row['date_release']));
                            $amount = number_format($row['cv_amount'], 2);
                            //initialize action button
                            $action = '<button class="btn btn-success btn-sm btnForward" value="'.$row['po-id'].'"><i class="fas fa-plus-circle"></i> Forward to Compliance</button>';
                            if($row['or_num'] == '' || $row['or_num'] == null){
                                $or_num = '-';
                            }else{
                                $or_num = $row['or_num'];
                            }
                            echo '
                            <tr>
                              <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                              <td><center>'.$or_num.'</center></td>
                              <td>'.$proj_name.'</td>
                              <td>'.$row['si_num'].'</td>                          
                              <td>'.$row['check_no'].'</td>
                              <td>'.$comp_name.'</td>
                              <td>'.$row['po_num'].'</td>
                              <td style="width: 150px">'.$sup_name.'</td>
                              <td>'.$amount.'</td>
                              <td><center>'.$release.'</center></td>
                            </tr>';
                          }
                        ?>
                        </tbody>
                      </table> 
                    </div>
                  </div>
                </div><!-- /column -->
              </div>
            </div>
            <!-- FORWARDED TAB -->
            <div class="row" id="pills-forwarded">
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover DataTable">
                      <thead class="thead-light">
                        <tr>
                          <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                          <th><center>OR #</center></th>
                          <th>SI #</th>
                          <th>Check No</th>
                          <th>Amount</th>
                          <th>Project</th>
                          <th>Company</th>
                          <th>PO/JO No</th>
                          <th>Payee</th>
                          <th><center>Date Released</center></th>
                        </tr>
                      </thead>
                      <tbody id="received-body">
                      <?php
                        $po->submitted_by = $_SESSION['id'];
                        $view = $po->get_forwarded_compliance();
                        while($row = $view->fetch(PDO::FETCH_ASSOC))
                        {
                          //get the PROJECT name if exist
                          $proj_name = '';
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
                          //get the check details
                          $check_no = '-';
                          $amount = '-';
                          $get4 = $check_details->get_details_byID($row['po-id']);
                          while($rowCheck = $get4->fetch(PDO:: FETCH_ASSOC))
                          {
                            $check_no = $rowCheck['check_no'];
                            $amount = number_format($rowCheck['cv_amount'], 2);
                          }
                          //date format
                          $release = date('m/d/Y', strtotime($row['date_release']));
                          //initialize action button
                          $action = '<button class="btn btn-success btn-sm btnForward" value="'.$row['po-id'].'"><i class="fas fa-plus-circle"></i> Forward to Compliance</button>';
                          if($row['or_num'] == '' || $row['or_num'] == null){
                            $or_num = '-';
                          }else{
                            $or_num = $row['or_num'];
                          }
                          echo '
                          <tr>
                            <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                            <td><center>'.$or_num.'</center></td>
                            <td>'.$row['si_num'].'</td>                          
                            <td>'.$check_no.'</td>
                            <td>'.$amount.'</td>
                            <td>'.$proj_name.'</td>
                            <td>'.$comp_name.'</td>
                            <td>'.$row['po_num'].'</td>
                            <td style="width: 150px">'.$sup_name.'</td>
                            <td><center>'.$release.'</center></td>
                          </tr>';
                        }
                      ?>
                      </tbody>
                    </table> 
                  </div>
                </div>
              </div><!-- /column -->
            </div><!-- row -->
            <!-- RECEIVED TAB -->
            <div class="row" id="pills-received">
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover DataTable">
                      <thead class="thead-light">
                        <tr>
                          <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                          <th><center>OR #</center></th>
                          <th>SI #</th>
                          <th>Check No</th>
                          <th>Amount</th>
                          <th>Project</th>
                          <th>Company</th>
                          <th>PO/JO No</th>
                          <th>Payee</th>
                          <th><center>Date Released</center></th>
                          <th><center>Date Received</center></th>
                        </tr>
                      </thead>
                      <tbody id="received-body">
                      <?php
                        $po->submitted_by = $_SESSION['id'];
                        $view = $po->get_received_compliance();
                        while($row = $view->fetch(PDO::FETCH_ASSOC))
                        {
                          //get the PROJECT name if exist
                          $proj_name = '';
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
                          //get the check details
                          $check_no = '-';
                          $amount = '-';
                          $get4 = $check_details->get_details_byID($row['po-id']);
                          while($rowCheck = $get4->fetch(PDO:: FETCH_ASSOC))
                          {
                            $check_no = $rowCheck['check_no'];
                            $amount = number_format($rowCheck['cv_amount'], 2);
                          }
                          //date format
                          $release = date('m/d/Y', strtotime($row['date_release']));
                          $received = date('m/d/Y', strtotime($row['date_received_comp']));
                          //initialize action button
                          $action = '<button class="btn btn-success btn-sm btnForward" value="'.$row['po-id'].'"><i class="fas fa-plus-circle"></i> Forward to Compliance</button>';
                          if($row['or_num'] == '' || $row['or_num'] == null){
                              $or_num = '-';
                          }else{
                              $or_num = $row['or_num'];
                          }
                          echo '
                          <tr>
                            <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                            <td><center>'.$or_num.'</center></td>
                            <td>'.$row['si_num'].'</td>                          
                            <td>'.$check_no.'</td>
                            <td>'.$amount.'</td>
                            <td>'.$proj_name.'</td>
                            <td>'.$comp_name.'</td>
                            <td>'.$row['po_num'].'</td>
                            <td style="width: 150px">'.$sup_name.'</td>
                            <td><center>'.$release.'</center></td>
                            <td><center>'.$received.'</center></td>
                          </tr>';
                        }
                      ?>
                      </tbody>
                    </table> 
                  </div>
                </div>
              </div><!-- /column -->
            </div><!-- row -->
            <!-- RETURNED TAB -->
            <div class="row" id="pills-returned">
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover DataTable">
                      <thead class="thead-light">
                        <tr>
                          <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                          <th><center>OR #</center></th>       
                          <th>SI #</th>
                          <th>Check No</th>
                          <th>Amount</th>
                          <th>Project</th>
                          <th>Company</th>
                          <th>PO/JO No</th>
                          <th>Payee</th>
                          <th><center>Date Returned</center></th>
                          <th><center>Remarks</center></th>
                        </tr>
                      </thead>
                      <tbody id="returned-body">
                      <?php
                        $po->submitted_by = $_SESSION['id'];
                        $view = $po->get_returned_comp();
                        while($row = $view->fetch(PDO::FETCH_ASSOC))
                        {
                          //get the PROJECT name if exist
                          $proj_name = '';
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
                          //get the check details
                          $check_no = '-';
                          $amount = '-';
                          $get4 = $check_details->get_details_byID($row['po-id']);
                          while($rowCheck = $get4->fetch(PDO:: FETCH_ASSOC))
                          {
                            $check_no = $rowCheck['check_no'];
                            $amount = number_format($rowCheck['cv_amount'], 2);
                          }
                          //date format
                          $returned = date('m/d/Y', strtotime($row['date_returned_comp']));
                          //initialize action button
                          $action = '<button class="btn btn-success btn-sm btnForward" value="'.$row['po-id'].'"><i class="fas fa-plus-circle"></i> Forward to Compliance</button>';
                          if($row['or_num'] == '' || $row['or_num'] == null){
                              $or_num = '-';
                          }else{
                              $or_num = $row['or_num'];
                          }
                          echo '
                          <tr>
                            <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                            <td><center>'.$or_num.'</center></td>                          
                            <td>'.$row['si_num'].'</td>                          
                            <td>'.$check_no.'</td>
                            <td>'.$amount.'</td>
                            <td>'.$proj_name.'</td>
                            <td>'.$comp_name.'</td>
                            <td>'.$row['po_num'].'</td>
                            <td style="width: 150px">'.$sup_name.'</td>
                            <td><center>'.$returned.'</center></td>
                            <td><center>'.$row['comp_remark'].'</center></td>
                          </tr>';
                        }
                      ?>
                      </tbody>
                    </table> 
                  </div>
                </div>
              </div><!-- /column -->
            </div><!-- row -->              
          </div><!-- /page-body -->   
    </div><!-- /container-wrapper-->
  </div><!-- /wrapper -->
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Add OR Num Modal -->
<div class="modal fade" id="AddORModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
      <button class="btn btn-primary" onclick="submit_OR()">Submit</button>
      </div>
    </div>
  </div>
</div>

<script src="../../assets/vendor/jquery/jquery.min.js"></script>
<script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../../assets/js/ruang-admin.min.js"></script>
<script src="../../assets/vendor/dataTables1/js/jquery.dataTables.min.js"></script>
<script src="../../assets/vendor/dataTables1/js/dataTables.bootstrap.min.js"></script>
<script src="../../assets/vendor/datetimepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../../assets/vendor/select2/js/select2.full.min.js"></script>
<script src="../../assets/vendor/select2/js/select2.min.js"></script>
<script src="../../assets/js/jquery.toast.js"></script>
<script src="../../assets/vendor/toastr/toastr.js"></script>
<?php include 'js/release_bo-js.php';?>

</body>
</html>