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
  <link href="../../assets/vendor/dataTables1/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/datetimepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/manager.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Accounting Payables</a></li>
              <li class="breadcrumb-item active" aria-current="page">Released Check</li>
            </ol>
          </div><!-- /Breadcrumbs -->
          <div id="page-body">
          <!-- DataTable with Hover -->
          <div class="row mb-3">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table1-responsive p-3">
                  <table id="req-table" class="table1 align-items-center table-flush table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th style="max-width: 2%" hidden><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>                        
                        <th>OR No</th>
                        <th>Check No</th>
                        <th>CV Amount</th>
                        <th>Payee</th>
                        <th>Company</th>
                        <th><center>Date Released</center></th>                        
                        <th>Project</th>
                        <th>PO/JO No</th>                        
                        <th>SI #</th>                        
                      </tr>
                    </thead>
                    <tbody id="released-body">
                    <?php
                      //get the check details
                      $getCheck = $check_details->get_active_check();
                      while($row1 = $getCheck->fetch(PDO:: FETCH_ASSOC))
                      {
                        $check_no = $row1['check_no'];
                        //get the po_details & po_other_details
                        $po_id = $row1['po_id'];
                        $array_po_id = explode(',', $po_id);
                        foreach($array_po_id as $po_val)
                        {
                          $po->id = $po_val;
                          $getPO = $po->get_po_forReleasing();
                          while($row2 = $getPO->fetch(PDO:: FETCH_ASSOC))
                          {
                            $comp_name = '-';
                            //get the COMPANY name if exist
                            $company->id = $row2['comp-id'];
                            $get2 = $company->get_company_detail();
                            while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
                            {
                              if($row2['comp-id'] == $rowComp['id']){
                                $comp_name = $rowComp['company'];
                              }
                            }
                            $sup_name = '-';
                            //get the SUPPLIER name if exist
                            $supplier->id = $row2['supp-id'];
                            $get3 = $supplier->get_supplier_details();
                            while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
                            {
                              if($row2['supp-id'] == $rowSupp['id']){
                                $sup_name = $rowSupp['supplier_name'];
                              }
                            } 
                            $proj_name = '-'; 
                            //get the PROJECT name if exist
                            $project->id = $row2['proj-id'];
                            $get1 = $project->get_proj_details();
                            while($rowProj = $get1->fetch(PDO::FETCH_ASSOC))
                            {
                              if($row2['proj-id'] == $rowProj['id']){
                                $proj_name = $rowProj['project'];
                              }
                            }
                              //date format
                              $release = date('m/d/Y', strtotime($row2['date_release']));
                              //check if OR No is null/empty
                              if($row2['or_num'] == '' || $row2['or_num'] == null){
                                $or_num = '<button class="btn btn-info btn-sm btnAdd" value="'.$row2['po-id'].'"><i class="fas fa-plus-circle"></i> Add OR</button>';
                              }else{
                                $or_num = $row2['or_num'];
                              }
                              echo '
                              <tr>
                                <td hidden><input type="checkbox" name="checklist" class="checklist" value="'.$row2['po-id'].'"></td>
                                <td>'.$or_num.'</td>
                                <td>'.$check_no.'</td>
                                <td>'.number_format($row2['amount']).'</td>
                                <td style="width: 180px">'.$sup_name.'</td> 
                                <td>'.$comp_name.'</td>
                                <td><center>'.$release.'</center></td>                                
                                <td style="max-width: 150px">'.$proj_name.'</td>
                                <td>'.$row2['po_num'].'</td>
                                <td>'.$row2['si_num'].'</td> 
                              </tr>';
                          }
                        }
                      }
                      // $po->submitted_by = $_SESSION['id'];
                      // $view = $po->get_released_fo();
                      // while($row = $view->fetch(PDO::FETCH_ASSOC))
                      // {
                      //   //get the COMPANY name if exist
                      //   $company->id = $row['comp-id'];
                      //   $get2 = $company->get_company_detail();
                      //   while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
                      //   {
                      //     if($row['comp-id'] == $rowComp['id']){
                      //       $comp_name = $rowComp['company'];
                      //     }else{
                      //       $comp_name = '-';
                      //     }
                      //   }
                      //   //get the SUPPLIER name if exist
                      //   $supplier->id = $row['supp-id'];
                      //   $get3 = $supplier->get_supplier_details();
                      //   while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
                      //   {
                      //     if($row['supp-id'] == $rowSupp['id']){
                      //       $sup_name = $rowSupp['supplier_name'];
                      //     }else{
                      //       $sup_name = '-';
                      //     }
                      //   }  
                      //   $proj_name = '';
                      //   //get the PROJECT name if exist
                      //   $project->id = $row['proj-id'];
                      //   $get1 = $project->get_proj_details();
                      //   while($rowProj = $get1->fetch(PDO::FETCH_ASSOC))
                      //   {
                      //     if($row['proj-id'] == $rowProj['id']){
                      //       $proj_name = $rowProj['project'];
                      //     }else{
                      //       $proj_name = '-';
                      //     }
                      //   }
                      //   //get the check details
                      //   $check_no = '-';
                      //   $amount = '-';
                      //   $get4 = $check_details->get_details_byID($row['po-id']);
                      //   while($rowCheck = $get4->fetch(PDO:: FETCH_ASSOC))
                      //   {
                      //     $check_no = $rowCheck['check_no'];
                      //     $amount = number_format(intval($rowCheck['cv_amount'], 2));
                      //   }
                      //   //date format
                      //   $release = date('m/d/Y', strtotime($row['date_release']));
                      //   //check if OR No is null/empty
                      //   if($row['or_num'] == '' || $row['or_num'] == null){
                      //     $or_num = '<button class="btn btn-info btn-sm btnAdd" value="'.$row['po-id'].'"><i class="fas fa-plus-circle"></i> Add OR</button>';
                      //   }else{
                      //     $or_num = $row['or_num'];
                      //   }
                      //   echo '
                      //   <tr>
                      //     <td hidden><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                      //     <td style="max-width: 150px">'.$proj_name.'</td>
                      //     <td>'.$row['si_num'].'</td>
                      //     <td>'.$or_num.'</td>
                      //     <td>'.$check_no.'</td>
                      //     <td>'.$comp_name.'</td>
                      //     <td>'.$row['po_num'].'</td>
                      //     <td style="width: 180px">'.$sup_name.'</td>
                      //     <td>'.$amount.'</td>
                      //     <td><center>'.$release.'</center></td>
                      //   </tr>';
                      // }
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
<?php include 'js/submit-js.php';?>

</body>
</html>