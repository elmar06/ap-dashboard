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