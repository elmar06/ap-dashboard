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
</head>

<body id="page-top" style="zoom:80%">
  <div id="wrapper">
    <?php include '../../includes/admin.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Administrator</a></li>
              <li class="breadcrumb-item active" aria-current="page">For Releasing PO's / JO's</li>
            </ol>
          </div><!-- /Breadcrumbs -->
          <!-- Pending Card -->
          <div id="page-body">        
            <div>
                <a id="btnAllReceived" type="button" class="btn btn-primary mb-1" href="#" style="display: none" onclick="received_all()">Mark All Received</a>
                <a id="btnAllReturned" type="button" class="btn btn-warning mb-1" href="#" style="display: none" onclick="returned_all()">Mark All Returned</a>
                <a id="btnAllRelease" type="button" class="btn btn-success mb-1" href="#" style="display: none" onclick="released_all()">Mark All Released</a>
            </div><br>
          <!-- DataTable with Hover -->
          <div class="row mb-3">
            <div class="col-lg-12">
              <div class="card mb-4">
              <div class="table1-responsive p-3">
                  <table id="submitted-table" class="table1 table-bordered table-flush table-hover" style="cursor:pointer;">
                    <thead class="thead-light">
                      <tr>
                        <th hidden><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                        <th><center>Status</center></th>                     
                        <th>Project</th>
                        <th>Company</th>
                        <th>PO/JO No</th>
                        <th>Payee</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody id="po-submit-body">
                      <?php
                        $view = $po->get_releasing_po();
                        while($row = $view->fetch(PDO::FETCH_ASSOC))
                        {
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
                            if($row['status'] == 3){
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
                            }else if($row['status'] == 12){
                                $status = '<label style="color: green"><b> Forwarded to Comp</b></label>';
                            }else if($row['status'] == 13){
                                $status = '<label style="color: orange"><b> Returned by Comp</b></label>';
                            }else if($row['status'] == 14){
                                $status = '<label style="color: green"><b> Accepted by Comp</b></label>';
                            }elseif($row['status'] == 15){
                                $status = '<label style="color: blue"><b> Forwarded to Cebu</b></label>';
                            }elseif($row['status'] == 20){
                                $status = '<label style="color: orange"><b> Staled Check</b></label>';
                            }else{
                                $status = '<label style="color: blue"><b> In Process</b></label>';
                            }
                                                    
                            echo '
                            <tr>
                                <td hidden><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                                <td><center>'.$status.'</center></td>                    
                                <td align="center">'.$proj_name.'</td>
                                <td>'.$comp_name.'</td>
                                <td>'.$row['po_num'].'</td>
                                <td>'.$sup_name.'</td>
                                <td align="center">'.$row['amount'].'</td>                                  
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
        <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
        <button id="btnReleased" class="btn btn-primary" data-dismiss="modal" aria-label="Close"><i class="fa-sharp fa-solid fa-pen-to-square"></i> Update</button>
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