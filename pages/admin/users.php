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
  <link href="../../assets/vendor/font-awesome/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="../../assets/vendor/toastr/toastr.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include '../../includes/admin.php'; ?><!-- page header -->
      <!-- Container Fluid-->
      <!-- Breadcrumbs -->
      <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex justify-content-between mb-4">
          <ol class="breadcrumb" align="right">
            <li class="breadcrumb-item"><a href="dashboard.php">Administrator</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
          </ol>
        </div><!-- /Breadcrumbs -->
          <!-- DataTable with Hover -->
          <div class="col-lg-12">
            <div class="form-group">
              <div class="row">
                &nbsp;&nbsp;&nbsp;
                <button id="btnAdd" class="btn btn-primary btn-block" style="width: 13%" data-toggle="modal" data-target="#newUser"><i class="fas fa-plus"></i> Add User</button>&nbsp;
                <button id="btnAddComp" type="button" class="btn btn-info"><i class="fas fa-folder-plus"></i> Add Access</button>&nbsp;
                <button id="btnActivate" type="button" class="btn btn-success"><i class="fas fa-check"></i> Activate</button>&nbsp;
                <button id="btnRemove" type="button" class="btn btn-danger"><i class="fas fa-trash"></i> Remove</button>&nbsp;
                <button id="btnReset" type="button" class="btn btn-warning"><i class="fas fa-sync-alt"></i> Reset Password</button>
              </div>
            </div>
            <div class="card mb-4">
              <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="user-table">
                  <thead class="thead-light">
                    <tr>
                      <th style="width: 3%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                      <th>Fullname</th>
                      <th>Username</th>
                      <th><center>Dept/Role</center></th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="user-body">
                    <!-- table body in here -->
                    <?php
                      $view = $user->view_all_user();
                      while($row = $view->fetch(PDO::FETCH_ASSOC))
                      {
                          //format of status
                          if($row['status'] == 1)
                          {
                            $status = '<label style="color: green"><b> Active</b></label>';
                          }
                          else
                          {
                            $status = '<label style="color: red"><b> Inactive</b></label>';
                          }
                          //department
                          if($row['access'] == 1){
                            $dept = 'Administrator';
                          }elseif($row['access'] == 2){   
                            $dept = 'AP Front Office';
                          }elseif($row['access'] == 3){   
                            $dept = 'AP Back Office';
                          }elseif($row['dept'] == 2 && $row['access'] == 4){
                            $dept = 'SCM';
                          }elseif($row['dept'] == 1 && $row['access'] == 4){
                            $dept = 'PMC';
                          }elseif($row['access'] == 5){
                            $dept = 'EA';
                          }elseif($row['access'] == 6){
                            $dept = 'Treasury';
                          }elseif($row['access'] == 7){
                            $dept = 'Manager';
                          }elseif($row['access'] == 8){
                            $dept = 'Accounting Sup';
                          }else{
                            $dept = 'Compliance';
                          }
                          echo '
                              <tr>
                                <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['id'].'"></td>
                                <td style="width: 200px">'.$row['fullname'].'</td>
                                <td>'.$row['username'].'</td>
                                <td><center>'.$dept.'</center></td>
                                <td>'.$status.'</td>
                              </tr>';
                      }
                    ?>
                  </tbody>
                </table> 
              </div><!-- /table-responsive -->
            </div><!-- /card -->
          </div> <!-- /col -->     
      </div><!---/Container Fluid-->
  </div><!-- /wrapper -->
<!-- Footer -->
<?php include '../../includes/footer.php'; ?>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Modal Section-->
<!-- Add New User Modal -->
<div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user"></i> User Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <input type="text" class="form-control firstname" id="firstname" placeholder="Firstname">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control lastname" id="lastname" placeholder="Lastname">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" 
                    placeholder="Email Address">
                </div>
                <div class="form-group">
                    <select id="department" class="form-control mb-3">
                      <option value="0" selected disabled>Please select a Role</option>
                      <option value="1">Administrator</option>
                      <option value="2">AP Front Office</option>
                      <option value="3">AP Back Office</option>
                      <option value="8">AP FO & BO</option>
                      <option value="4">Purchasing</option>
                      <option value="5">EA</option>
                      <option value="6">Treasury</option>
                      <option value="7">Manager</option>
                      <option value="8">Accounting Supervisor</option>
                      <option value="9">Compliance</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control username" id="username" placeholder="Username" disabled>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" placeholder="Username" value="123456" disabled>
                </div>
                <!-- Alert -->
                <div id="add-success" class="alert alert-success" role="alert" style="display: none"></div>
                <div id="add-warning" class="alert alert-danger" role="alert" style="display: none"></div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="btnSaveUser" type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
</div>
<!-- Display the details of user modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user"></i> User Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div id="details-body" class="modal-body">
          <!-- body goes here -->
          <!-- Alert -->
        </div>
        <div class="modal-footer">
          <button id="btnEdit" type="button" class="btn btn-info">Edit</button>
          <button id="btnUpdUser" type="button" class="btn btn-primary" disabled>Update Details</button>
        </div>
        </div>
    </div>
</div>
<!-- Display the details of user company modal -->
<div class="modal fade" id="userCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user"></i> Company Access Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body access-body">
            <!-- details goes here -->
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="apply_access()">Save Changes</button>
        </div>
        </div>
    </div>
</div>

<script src="../../assets/vendor/jquery/jquery.min.js"></script>
<script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../../assets/js/ruang-admin.min.js"></script>
<!-- Datatable plugins -->
<script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/js/jquery.toast.js"></script>
<script src="../../assets/vendor/toastr/toastr.js"></script>
<script src="../../assets/vendor/select2/js/select2.full.min.js"></script>
<script src="../../assets/vendor/select2/js/select2.min.js"></script>
<?php include 'js/users-js.php'; ?>

</body>
</html>