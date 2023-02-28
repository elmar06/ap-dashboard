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
<!-- update as of 3/23/20 -->
<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/backOffice.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Accounting Payables</a></li>
              <li class="breadcrumb-item active" aria-current="page">For Signature (Back Office)</li>
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
              <a type="button" class="btn btn-success mb-1" href="#" onclick="apply()" ><i class="fas fa-check"></i> Apply</a>&nbsp;
              <a id="btnCancel" type="button" class="btn btn-danger mb-1" href="#" onclick="cancel_bulk()"><i class="fas fa-times"></i> Cancel</a>
            </div><br>
            <!-- DataTable with Hover -->
            <div class="row mb-3">
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover processTable">
                      <thead class="thead-light">
                        <tr>
                          <th style="max-width: 1%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                          <th><center>Status</center></th>
                          <th>SI No</th>
                          <th>CV No</th>
                          <th>Check No</th>
                          <th>Company</th>
                          <th>PO/JO No</th>
                          <th>Payee</th>
                        </tr>
                      </thead>
                      <tbody id="process-body">
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
                            $view = $po->get_all_for_signature_bo();
                            while($row = $view->fetch(PDO::FETCH_ASSOC))
                            {
                              //get multiple si num
                              $si_num = '';
                              $poID = $row['po_id'];
                              $po_id = explode(',', $poID);
                              foreach($po_id as $value)
                              {
                                $po->id = $value;
                                $get_si = $po->get_multi_si_num();
                                while($row2 = $get_si->fetch(PDO:: FETCH_ASSOC))
                                { 
                                  $si_num = $si_num.','.$row2['si_num'];
                                }
                                $si_num = ltrim($si_num, ',');
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
                              //date format
                              $bill_date = date('m/d/Y', strtotime($row['bill_date']));
                              echo '
                              <tr>
                                <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                                <td style="width: 180px"><center>
                                <select class="form-control-sm action" style="width:120px">
                                  <option value="0" selected disabled>Mark Status</option>';
                                  if($row['po-stat'] == 5){
                                    echo '<option value="1" selected>Sent to EA</option>
                                          <option value="2">Returned from EA</option>
                                          <option value="3">Cancel Check</option>';
                                  }elseif($row['po-stat'] == 6){
                                    echo '<option value="1" disabled selected>Sent to EA</option>
                                          <option value="2">Returned from EA</option>
                                          <option value="3">Cancel Check</option>';
                                  }elseif($row['po-stat'] == 7){
                                    echo '<option value="1" disabled>Sent to EA</option>
                                          <option value="1" disabled selected>For Pick Up in EA</option>
                                          <option value="2">Returned from EA</option>
                                          <option value="3">Cancel Check</option>';
                                  }elseif($row['po-stat'] == 8){
                                    echo '<option value="1" disabled>Sent to EA</option>
                                          <option value="2" disabled selected>Returned from EA</option>
                                          <option value="3">Cancel Check</option>';
                                  }elseif($row['po-stat'] == 13){
                                    echo '<option value="1" disabled>Sent to EA</option>
                                          <option value="2" disabled>Returned from EA</option>
                                          <option value="3" disabled selected>Canceled Check</option>';
                                  }else{
                                    echo '<option value="1">Sent to EA</option>
                                          <option value="2">Returned from EA</option>
                                          <option value="3">Canceled Check</option>';
                                  }
                                  echo '</select>
                                  <button class="btn-sm btn-success apply" value="'.$row['po-id'].'"><i class="fas fa-check"></i></button>
                                  <button class="btn-sm btn-danger cancel" value="'.$row['po-id'].'"><i class="fas fa-times-circle"></i></button></center>
                                </td>
                                <td>'.$si_num.'</td>
                                <td>'.$row['cv_no'].'</td>
                                <td>'.$row['check_no'].'</td>
                                <td>'.$comp_name.'</td>
                                <td>'.$row['po_num'].'</td>
                                <td>'.$sup_name.'</td>
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
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
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
<?php include_once 'js/forSignature-js.php';?>

</body>
</html>