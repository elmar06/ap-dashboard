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
  <link href="../../assets/vendor/dataTables1/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/compliance.php'; ?><!-- page header -->
        <!-- Container Fluid-->
        <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex justify-content-between mb-4">
            <ol class="breadcrumb" align="right">
              <li class="breadcrumb-item"><a href="#">Accounting</a></li>
              <li class="breadcrumb-item active" aria-current="page">Compliance / Received Request</li>
            </ol>
          </div><!-- /Breadcrumbs -->
          <!-- Pending Card -->
          <div class="row mb-3">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table1-responsive p-3">
                  <table id="submitted-table" class="table1 table-bordered table-flush table-hover DataTable" style="cursor:pointer;">
                    <thead class="thead-light">
                      <tr>
                          <th>Released Date</th>
                          <th>CV #</th>
                          <th>Check #</th>
                          <th>CV Amount</th>
                          <th>Company</th>
                          <th>PO/JO #</th>
                          <th>Suppplier</th>
                          <th>Due Date</th>
                          <th>Project</th>
                      </tr>
                    </thead>
                    <tbody id="po-submit-body">
                    <?php
                        $view = $po->get_list_compliance();
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
                            //date format
                            $date_release = date('m/d/Y', strtotime($row['date_release']));                              
                            $due = date('m/d/Y', strtotime($row['due_date']));                              
                            $action = '<button class="btn-sm btn-success received" value="'.$row['po-id'].'"><i class="fas fa-check"></i></button>
                            <button class="btn-sm btn-danger return" value="'.$row['po-id'].'"><i class="fas fa-times-circle"></i></button>';
                            echo '
                            <tr>
                                <td>'.$date_release.'</td>
                                <td>'.$row['cv_no'].'</td>
                                <td>'.$row['check_no'].'</td>
                                <td>'.number_format(floatval($row['cv_amount']), 2).'</td>
                                <td>'.$comp_name.'</td>
                                <td>'.$row['po_num'].'</td>
                                <td style="width: 180px">'.$sup_name.'</td>
                                <td>'.$due.'</td>
                                <td>'.$proj_name.'</td>
                            </tr>';
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
                    </tbody>
                  </table> 
                </div>
              </div>
            </div>     
        </div><!---/Container Fluid-->
      </div>
</div>
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../../assets/vendor/datetimepicker/js/bootstrap-datepicker.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../../assets/js/ruang-admin.min.js"></script>
  <!-- Datatable plugins -->
  <script src="../../assets/vendor/select2/js/select2.min.js"></script>
  <script src="../../assets/vendor/dataTables1/js/jquery.dataTables.min.js"></script>
  <script src="../../assets/vendor/select2/js/select2.full.min.js"></script>
  <script src="../../assets/vendor/dataTables1/js/dataTables.bootstrap.min.js"></script>
  <script src="../../assets/js/jquery.toast.js"></script>
  <?php include "js/received-js.php"; ?>
</body>
</html>