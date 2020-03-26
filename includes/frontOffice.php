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

$database = new clsConnection();
$db = $database->connect();

$supplier = new Supplier($db);
$company = new Company($db);
$po = new PO_Details($db);
$dept = new Department($db);
$project = new Project($db);
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
    <a class="nav-link" href="front-office.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
  <hr class="sidebar-divider">
  <li class="nav-item">
    <a class="nav-link" href="for_releasing.php">
      <i class="fas fa-fw fa-coins"></i>
      <span>For Releasing</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="released_check.php">
      <i class="fas fa-fw fa-check-circle"></i>
      <span>Released Check</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="forms.html">
      <i class="fas fa-fw fa-chart-pie"></i>
      <span>Reports</span>
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
            <span class="ml-2 d-none d-lg-inline text-white small"><?php echo $_SESSION['fullname'];?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <input id="user-id" value="<?php echo $_SESSION['id']; ?>" style="display: none;">
          <input id="logcount" value="<?php echo $_SESSION['log_count']; ?>" style="display: none;">
            <a class="dropdown-item" href="#">
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
            <button id="btnUpdate" type="button" class="btn btn-primary" onclick="updateSettings()">Update Details</button>
          </div>
        </div>
    </div>
</div>

<!-- change password modal -->
<div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user"></i> User Details</h5>
          </div>
          <div id="pass-body" class="modal-body">
            <!-- body goes here  -->
          </div>
          <div class="modal-footer">
            <button id="btnChangePassword" type="button" class="btn btn-primary" onclick="changePassword()"><i class="fas fa-save"></i> Save</button>
          </div>
        </div>
    </div>
</div>

<!-- modal after successful change of password -->
<div id="noticeModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>NOTICE</b></h4>
      </div>
      <div class="modal-body">
        <p>Congratulation, your password has been successfully updated. You need to login again to complete the process <a href="../../controls/logout.php"><b><u>Click here</b></u></a> to continue.</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="../../controls/logout.php">Logout</a>
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
    url: '../../controls/get_user_details.php',
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

  if(firstname != '' && lastname != '' && email != '')
  {
    if(password != '')//if password is not empty
    {
      $.ajax({
        type: 'POST',
        url: '../../controls/upd_user_settings.php',
        data: myData,
        beforeSend: function()
        {
          showToast();
        },
        success: function(response)
        {
          if(response > 0)
          {
            $('#user-success').html('<center><i class="fas fa-check"></i> User Details successfully udpated.</center>');
            $('#user-success').show();
            setTimeout(function(){
              $('#user-success').hide();
            }, 2000)
          }
          else
          {
            $('#user-warning').html('<center><i class="fas fa-ban"></i> Update Failed. Please contact the Administrator at local 124.</center>');
            $('#user-warning').show();
            setTimeout(function(){
              $('#user-warning').hide();
            }, 3000)
          }
        }
      })
    }else{
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
            $('#user-success').html('<center><i class="fas fa-check"></i> User Details successfully udpated.</center>');
            $('#user-success').show();
            setTimeout(function(){
              $('#user-success').hide();
            }, 2000)
          }
          else
          {
            $('#user-warning').html('<center><i class="fas fa-ban"></i> Update Failed. Please contact the Administrator at local 124.</center>');
            $('#user-warning').show();
            setTimeout(function(){
              $('#user-warning').hide();
            }, 3000)
          }
        }
      })
    }
  }else{
    $('#user-warning').html('<center><i class="fas fa-ban"></i> ERROR! Please fill out all the fields needed.</center>');
    $('#user-warning').show();
    setTimeout(function(){
      $('#user-warning').hide();
    }, 3000)
  }
}
</script>