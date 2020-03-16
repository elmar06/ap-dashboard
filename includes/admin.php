<?php
session_start();
if(!(isset($_SESSION['fullname'])))
{
  header('Location: ../../index.php');
}

include '../../config/clsConnection.php';
include '../../objects/clsSupplier.php';
include '../../objects/clsCompany.php';
include '../../objects/clsPODetails.php';
include '../../objects/clsDepartment.php';
include '../../objects/clsProject.php';
include '../../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$supplier = new Supplier($db);
$company = new Company($db);
$po = new PO_Details($db);
$dept = new Department($db);
$project = new Project($db);
$user = new Users($db);
?>
<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon">
      <img src="../../assets/img/dashboard-logo.png">
    </div>
    <div class="sidebar-brand-text mx-3">AP Dashboard</div>
  </a>
  <hr class="sidebar-divider my-0">
  <li class="nav-item">
    <a class="nav-link" href="dashboard.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
  <hr class="sidebar-divider">
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
      <i class="fas fa-list-alt"></i>
      <span>Master List</span>
    </a>
    <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="nav-link" href="company.php"><i class="fas fa-fw fa-building"></i><span>Company</span></a>
        <a class="nav-link" href="department.php"><i class="fas fa-fw fa-landmark"></i><span>Department</span></a>
        <a class="nav-link" href="project.php"><i class="fas fa-fw fa-archway"></i><span>Project</span></a>
        <a class="nav-link" href="supplier.php"><i class="fas fa-fw fa-store"></i><span>Suppliers</span></a>
      </div>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="released_check.php">
      <i class="fas fa-fw fa-check-circle"></i>
      <span>Released Check</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="report.php">
      <i class="fas fa-fw fa-chart-pie"></i>
      <span>Reports</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="users.php">
      <i class="fas fa-fw fa-users"></i>
      <span>Users</span>
    </a>
  </li>
</ul>
<!-- Sidebar -->
<div id="content-wrapper" class="d-flex flex-column">
  <div id="content">
    <!-- TopBar -->
    <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
      <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
      <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <img class="img-profile rounded-circle" src="../../assets/img/boy.png" style="max-width: 60px">
            <span class="ml-2 d-none d-lg-inline text-white small"><?php echo $_SESSION['fullname']?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <input id="user-id" value="<?php echo $_SESSION['id']; ?>" style="display: none;">
            <a id="settings" class="dropdown-item" href="#" onclick="getUserDetails()">
              <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
              Settings
            </a>
            <a class="dropdown-item" href="../../controls/logout.php">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- Topbar -->

<!-- Display the details of user modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user"></i> User Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="setting-body" class="modal-body">
            <!-- body goes here -->
            <!-- Alert -->
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="updateSettings()">Update Details</button>
          </div>
        </div>
    </div>
</div>

<script>
function getUserDetails()
{
  var id = $('#user-id').val();

  $.ajax({
    type: 'POST',
    url: '../../controls/user_settings.php',
    data: {id: id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#settingsModal').modal('show');
      $('#setting-body').html(html);
    }
  })
}

function updateSettings()
{
  var id = $('#user-id').val();
  var firstname = $('#user-firstname').val();
  var lastname = $('#user-lastname').val();
  var email = $('#user-email').val();
  var department = $('#user-department').val();
  var username = $('#user-username').val();
  var password = $('#user-password').val();
  var password2 = $('#user-password2').val();
  var myData = 'id=' + id + '&firstname=' + firstname + '&lastname=' + lastname + '&email=' + email + '&department=' + department + '&username=' + username + '&password=' + password;

  $.ajax({
    type: 'POST',
    url: '../../controls/upd_user.php',
    data: myData,
    beforeSend: function()
    {
      showToast();
    },
    success: function(response)
    {
      if(response > 0)
      {
        alert('success');
      }
      else
      {
        alert('failed')
      }
    }
  })
}
</script>