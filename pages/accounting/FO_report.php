<!DOCTYPE html>
<html lang="en">

    <head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../../assets/img/logo/logo.png" rel="icon">
  <title>AP Dashboard - User</title>
  <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="../../assets/vendor/datetimepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/toastr/toastr.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
    <div id="wrapper">
    <?php include '../../includes/frontOffice.php'; ?><!-- page header -->
      <!-- Container Fluid-->
      <!-- Breadcrumbs -->
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex justify-content-between mb-4">
                <ol class="breadcrumb" align="right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Accounting Payables</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reports (Front Office)</li>
                </ol>
            </div><!-- /Breadcrumbs -->
            <div class="card mb-4 p-3">
                <div class="row">
                    <div class="col-lg-12">
                        <label>Generate Report By:</label>
                    </div>   
                </div>  
                <div class="row">
                    <div class="col-lg-3"><br>
                        <label>Company:</label>
                        <select id="fo-company" class="form-control mb-3 select2">
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
                    <div class="col-lg-3"><br>
                        <br><label style="padding-bottom: 23px"> </label>
                        <a class="btn btn-danger remove-data" href="#"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label>Supplier:</label>
                        <select id="fo-supplier" class="form-control mb-3 select2">
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
                    <div class="col-lg-3"><br>
                        <label style="padding-bottom: 23px"> </label>
                        <a class="btn btn-danger remove-data" href="#"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3"><br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input id="from" class="form-control datepicker" placeholder="Date From">
                        </div>
                    </div>
                    <div class="col-lg-3"><br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input id="to" class="form-control datepicker" placeholder="Date To">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <button class="btn btn-success" onclick="generate_report()"><i class="fas fa-check"></i> Generate</button>
                    </div>
                </div>
            </div>
        </div><!---/Container Fluid-->
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
<script src="../../assets/vendor/datetimepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Datatable plugins -->
<script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/js/jquery.toast.js"></script>
<script src="../../assets/vendor/toastr/toastr.js"></script>
<script src="../../assets/vendor/select2/js/select2.full.min.js"></script>
<script src="../../assets/vendor/select2/js/select2.min.js"></script>
<?php include 'js/report-js.php'; ?>

</body>
</html>