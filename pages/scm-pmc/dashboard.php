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
  <link href="../../assets/vendor/datetimepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
  <link href="../../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../../assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/purchasing.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">SCM-PMC</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div><!-- /Breadcrumbs -->

          <!-- Cards -->
          <!-- Pending Card -->
          <div id="page-body">
            <div class="row mb-3">
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Pending PO/JO</div>
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_pending_by_user();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['pending-count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
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
              <!-- Returned count -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Returned</div>
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_return_by_user();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['return-count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
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
                        <div class="text-xs font-weight-bold text-uppercase mb-1">On Process</div>
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_on_process_by_user();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['process-count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
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
                          $po->submitted_by = $_SESSION['id'];
                          $count = $po->count_releasing_by_user();
                          if($row = $count->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['releasing-count'].'</div>';
                          }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                          }
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PO-Modal" id="#myBtn"> Submit PO/JO</button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#UploadModal" id="#btnUpload"> Upload File</button>
                <a type="button" class="btn btn-info" href="../../assets/sample/SampleCSV-v1.xlsx"> Download CSV Sample</a>
                <button type="button" class="btn btn-danger" id="btnClear" style="display: none" onclick="clear_list()"> Clear Search</button>
              </div>
            </div>
            <!-- Submitted PO/JO Details -->
            <div id="po-details-body" class="row">
              <?php
                $po->submitted_by = $_SESSION['id'];
                $get = $po->get_details_pending();
                while($row=$get->fetch(PDO::FETCH_ASSOC))
                {
                  echo '
                  <div class="col-lg-4">
                    <div class="card mb-5">
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <div class="row">
                            <h6 class="m-0 font-weight-bold text-primary">PO/JO Number: '.$row['po_num'].'</h6>  
                        </div>
                      </div>
                      <div class="card-body">
                        <p>Company: '.$row['company-name'].'<br>
                          Supplier: '.$row['supplier_name'].'
                        </p>
                        <div class="row">
                          <div class="mt-2 mb-0 text-xs col-sm-6" align="left">
                            <a class="text-success details" href="#" value="'.$row['po-id'].'" data-toggle="modal"><i class="fas fa-plus"></i> More Details</a>
                          </div>
                          <div class="mt-2 mb-0 text-xs col-sm-6" align="right">
                            <a class="text-danger remove" href="#" value="'.$row['po-id'].'" data-toggle="modal"><i class="fas fa-trash"></i> Delete</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>';
                }
              ?>
            </div> <!-- end of po-details body -->
            <!-- PENDING -->
            <div id="tblSearch1" class="row mb-3">
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover DataTable">
                      <thead class="thead-light">
                        <tr>
                          <th style="display: none"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                          <th>Project</th>
                          <th>Company</th>
                          <th>PO/JO No</th>                          
                          <th>Supplier</th>
                          <th>Billing Date</th>
                          <th><center>Status</center></th>
                        </tr>
                      </thead>
                      <tbody id="req-body">
                        <?php
                          $po->status = 1;
                          $po->submitted_by = $_SESSION['id'];
                          $get = $po->get_po_list_by_status_req();
                          while($row = $get->fetch(PDO::FETCH_ASSOC))
                          {
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
                            $comp_name = '';
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
                            $sup_name = '';
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
                            $status = '<label style="color: red"><b> Pending</b></label>';
                            //date format
                            $bill_date = date('m/d/Y', strtotime($row['bill_date']));
                            echo '
                            <tr>
                              <td style="display: none"><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                              <td>'.$proj_name.'</td>
                              <td>'.$comp_name.'</td>
                              <td>'.$row['po_num'].'</td>
                              <td>'.$sup_name.'</td>
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
            </div><!-- /end of req-table -->
            <!-- RETURNED -->
            <div id="tblSearch2" class="row mb-3">
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover DataTable">
                      <thead class="thead-light">
                        <tr>
                          <th style="display: none"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                          <th>Project</th>
                          <th>Company</th>
                          <th>PO/JO No</th>                          
                          <th>Supplier</th>
                          <th>Billing Date</th>
                          <th><center>Status</center></th>
                        </tr>
                      </thead>
                      <tbody id="req-body">
                        <?php
                          $po->status = 2;
                          $po->submitted_by = $_SESSION['id'];
                          $get = $po->get_po_list_by_status_req();
                          while($row = $get->fetch(PDO::FETCH_ASSOC))
                          {
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
                            $comp_name = '';
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
                            $sup_name = '';
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
                            $status = '<label style="color: orange"><b> Returned</b></label>';
                            //date format
                            $bill_date = date('m/d/Y', strtotime($row['bill_date']));
                            echo '
                            <tr>
                              <td style="display: none"><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                              <td>'.$proj_name.'</td>
                              <td>'.$comp_name.'</td>
                              <td>'.$row['po_num'].'</td>
                              <td>'.$sup_name.'</td>
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
            </div><!-- /end of req-table -->
            <!-- ON PROCESS -->
            <div id="tblSearch3" class="row mb-3">
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover DataTable">
                      <thead class="thead-light">
                        <tr>
                          <th style="display: none"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                          <th>Project</th>
                          <th>Company</th>
                          <th>PO/JO No</th>                          
                          <th>Supplier</th>
                          <th>Billing Date</th>
                          <th><center>Status</center></th>
                        </tr>
                      </thead>
                      <tbody id="req-body">
                        <?php
                          $po->submitted_by = $_SESSION['id'];
                          $get = $po->get_po_list_process_req();
                          while($row = $get->fetch(PDO::FETCH_ASSOC))
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
                            $comp_name = '';
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
                            $sup_name = '';
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
                            $status = '<label style="color: blue"><b> On Process</b></label>';
                            //date format
                            $bill_date = date('m/d/Y', strtotime($row['bill_date']));
                            echo '
                            <tr>
                              <td style="display: none"><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                              <td>'.$proj_name.'</td>
                              <td>'.$comp_name.'</td>
                              <td>'.$row['po_num'].'</td>
                              <td>'.$sup_name.'</td>
                              <td>'.$bill_date.'</td>
                              <td style="width: 13%"><center>'.$status.'</center></td>
                            </tr>';
                          }
                        ?>
                      </tbody>
                    </table> 
                  </div>
                </div>
              </div>     
            </div><!-- /end of req-table -->
            <!-- FOR RELEASING -->
            <div id="tblSearch4" class="row mb-3">
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover DataTable">
                      <thead class="thead-light">
                        <tr>
                          <th style="display: none"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                          <th>Project</th>
                          <th>Company</th>
                          <th>PO/JO No</th>                          
                          <th>Supplier</th>
                          <th>Billing Date</th>
                          <th><center>Status</center></th>
                        </tr>
                      </thead>
                      <tbody id="req-body">
                        <?php
                          $po->status = 10;
                          $po->submitted_by = $_SESSION['id'];
                          $get = $po->get_po_list_by_status_req();
                          while($row = $get->fetch(PDO::FETCH_ASSOC))
                          {
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
                            $comp_name = '';
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
                            $sup_name = '';
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
                            $status = '<label style="color: green"><b> For Releasing</b></label>';
                            //date format
                            $bill_date = date('m/d/Y', strtotime($row['bill_date']));
                            echo '
                            <tr>
                              <td style="display: none"><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                              <td>'.$proj_name.'</td>
                              <td>'.$comp_name.'</td>
                              <td>'.$row['po_num'].'</td>
                              <td>'.$sup_name.'</td>
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
            </div><!-- /end of req-table -->
          </div> <!-- /end of page-body -->
      </div><!---/Container-Fluid-->
  </div><!-- /wrapper -->
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>

<!-- MODAL SECTION -->
<!-- Submit PO Modal -->
<div class="modal fade" id="PO-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <label><i style="color: red">*</i> PO/JO Number:</label>
            <input id="po-no" class="form-control mb-3" type="text" placeholder="Enter PO/JO number">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <label><i style="color: red">*</i> PO/Contract Amount:</label>
            <input id="po-amount" class="form-control mb-3 amount" type="text" placeholder="Enter Amount">
          </div>
          <div class="col-lg-6">
            <label></i> PO Date:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
              </div>
              <input id="po-date" class="form-control datepicker" placeholder="Enter PO Date">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <label><i style="color: red">*</i> SI No/Type of Billing:</label>
            <input id="si-num" class="form-control mb-3" type="text" placeholder="Enter Billing number">
          </div>
          <div class="col-lg-6">
            <label><i style="color: red">*</i> SI/Billing Amount</label>
            <input id="si-amount" class="form-control mb-3 amount" type="text" placeholder="Enter Amount">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <label><i style="color: red">*</i> Company:</label>
            <select id="company" class="form-control mb-3 select2" style="width: 100%;">
              <option selected disabled>Select a Company</option>
              <?php
                $get = $company->get_active_company();
                while($row = $get->fetch(PDO::FETCH_ASSOC))
                {
                  echo '<option value="'.$row['id'].'">'.$row['company'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="col-lg-6">
            <label><i style="color: red">*</i> Supplier:</label>
            <select id="supplier" class="form-control mb-3 select2"  style="width: 100%;">
              <option selected disabled>Select a Supplier</option>
              <?php
                $get = $supplier->get_active_supplier();
                while($row = $get->fetch(PDO::FETCH_ASSOC))
                {
                  echo '<option value="'.$row['id'].'">'.$row['supplier_name'].'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6"  style="margin-top: 16px">
            <label> Project:</label>
            <select id="project" class="form-control mb-3 select2" style="width: 100%;">
              <option selected disabled>Select a Project</option>
              <?php
                $get = $project->get_active_project();
                while($row = $get->fetch(PDO::FETCH_ASSOC))
                {
                  echo '<option value="'.$row['id'].'">'.$row['project'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="col-lg-6"  style="margin-top: 16px">
            <label>Department:</label>
            <select id="department" class="form-control mb-3 select2"  style="width: 100%;">
              <option selected disabled>Select a Department</option>
              <?php
                $get = $dept->get_active_department();
                while($row = $get->fetch(PDO::FETCH_ASSOC))
                {
                  echo '<option value="'.$row['id'].'">'.$row['department'].'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8" style="margin-top: 17px">
            <label><i style="color: red">*</i> Billing/SI Date:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
              </div>
              <input id="bill-date" class="form-control datepicker" placeholder="Enter Billing Date" onchange="getDueDate()">
            </div>
          </div>
          <div class="col-lg-4" style="margin-top: 17px">
            <label><i style="color: red">*</i> Terms:</label>
            <input id="terms" class="form-control mb-3" type="text" placeholder="Enter Terms" value="30 days" onchange="getDueDate()">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
          <label><i style="color: red">*</i> Due Date:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
              </div>
              <input id="due-date" class="form-control datepicker" placeholder="Due Date">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitch1" onchange="mark_as_credit_memo()">
              <label class="custom-control-label" for="customSwitch1"> Credit Memo</label>
            </div>
          </div>
        </div>
        <div class="row report" style="display: none;">
          <div class="col-lg-12">
            <textarea id="memo-no" class="form-control mb-3" type="text" placeholder="Input Memo No. here"></textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="remarks">
              <label class="custom-control-label" for="remarks"> Share this records with SCM/PMC</label>
            </div>
          </div>
        </div>
        <!-- Alert -->
        <div id="add-success" class="alert alert-success" role="alert" style="display: none"></div>
        <div id="add-warning" class="alert alert-danger" role="alert" style="display: none"></div>         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" onclick="SubmitPO()">Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="POmodalDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
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
        <button id="btnSubmit" class="btn btn-primary" onclick="upd_po_details()">Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- UPLOAD MODAL -->
<div id="UploadModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-upload"></span> Upload File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="alert alert-info" role="alert"><span class="fa fa-info-circle"></span> Please select a file to upload in PO Detail's database. Please use CSV(Comma delimited) format.</div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <label for="exampleInputEmail1">Choose a File</label><br>
              <form name="form" method="post" enctype="multipart/form-data">
                <input type="file" id="filecover" name="worker_file" value="Browse" onchange="readURL(this);" accept=".csv" /><br>
                <label id="upload-success" style="color: green; display:none"></label>
                <label id="upload-warning" style="color: red; display:none"></label>
              </form><br>
          </div>
        </div>
        <div id="loading" style="display: none"><center><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>
        </div>
      </div>
      <div class="modal-footer">
        <button id="btnFileUpload" class="btn btn-primary" onclick="uploadFile()">Upload File</button>
        <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- notification Modal -->
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
        <div id="notf-msg" style="font-size: 18px;">Are you sure you want to remove this request?</div>
        <input id="po-id" class="form-control" style="display: none;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel</button>
        <button id="btnSubmit" class="btn btn-danger" onclick="remove_po()"><i class="fas fa-trash"></i> Remove</button>
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
<?php include 'js/dash-js.php';?>

</body>
</html>