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
              <li class="breadcrumb-item active" aria-current="page">Returned Check</li>
            </ol>
          </div><!-- /Breadcrumbs -->
          <div id="page-body">
          <!-- DataTable with Hover -->
          <div class="row mb-3">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table1-responsive p-3">
                  <table class="table1 align-items-center table-flush table-hover DataTable">
                    <thead class="thead-light">
                      <tr>
                        <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                        <th>Forwarded</th>
                        <th>Received</th>
                        <th>Returned</th>
                        <th>Company</th>
                        <th>Payee</th>
                        <th>Check Date</th>
                        <th>CV No</th>
                        <th>Check No</th>                        
                        <th><center>Status</center></th>
                      </tr>
                    </thead>
                    <tbody id="req-body">
                    <?php
                      $po->submitted_by = $_SESSION['id'];
                      $view = $po->get_return_from_ea();
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
                        $status = '<label style="color: green"><b> Returned</b></label>';
                        //date formatting
                        $forwarded = date('m/d/Y', strtotime($row['date_to_ea']));
                        $received = '-';
                        if($row['date_received_ea'] != null){
                          $received = date('m/d/Y', strtotime($row['date_received_ea']));
                        }
                        $returned = date('m/d/Y', strtotime($row['date_from_ea']));
                        $check_date = date('m/d/Y', strtotime($row['check_date']));
                        echo '
                        <tr>
                          <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                          <td><center>'.$forwarded.'</center></td>
                          <td><center>'.$received.'</center></td>
                          <td><center>'.$returned.'</center></td>
                          <td style="max-width: 150px;">'.$comp_name.'</td>
                          <td>'.$sup_name.'</td>
                          <td><center>'.$check_date.'</center></td>
                          <td>'.$row['cv_no'].'</td>
                          <td>'.$row['check_no'].'</td>
                          
                          <td><center>'.$status.'</center></td>
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