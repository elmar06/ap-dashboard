<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';
include '../objects/clsProject.php';
include '../objects/clsDepartment.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$supplier = new Supplier($db);
$proj = new Project($db);
$dept = new Department($db);

$po->id = $_POST['id'];
$get = $po->get_po_by_id();

while($row = $get->fetch(PDO::FETCH_ASSOC))
{
  //get the Manila time by timezone
  date_default_timezone_set('Asia/Manila');
  //format the date for display
  $bill_date = date('F d, yy', strtotime($row['bill_date']));
  $due_date = date('F d, yy', strtotime($row['due_date']));
  $check_date = date('F d, yy', strtotime($row['check_date']));

  //get the difference between bill_date & due_date
  $date1 = time();
  $date2 = strtotime($row['due_date']);
  $datediff = $date2 - $date1;
  $days_left = floor($datediff/(60*60*24))." day/s";

  echo '
      <div class="row">
        <div class="col-lg-6">
            <label>CV No.</label>
            <input id="cv-no" class="form-control mb-3" type="text"  value="'.$row['cv_no'].'" disabled>
        </div>
        <div class="col-lg-6">
            <label>Check No.</label>
            <input id="upd-sales-invoice" class="form-control mb-3" type="text" value="'.$row['si_num'].'" disabled>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
            <label>Bank</label>
            <input id="upd-amount" class="form-control mb-3" type="text"  value="'.$row['bank-name'].'" disabled>
        </div>
        <div class="col-lg-6">
            <label>Check No.</label>
            <input id="upd-sales-invoice" class="form-control mb-3" type="text" value="'.$row['check_date'].'" disabled>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <label>Invoice/Billing No:</label>
          <input id="upd-id" class="form-control mb-3" type="text"  value="'.$row['bill_no'].'" disabled>
        </div>
        <div class="col-lg-6">
          <label>PO/JO Number:</label>
          <input id="upd-po-no" class="form-control mb-3" type="text" placeholder="Enter PO/JO number" value="'.$row['po_num'].'" disabled>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
            <label>Amount</label>
            <input id="upd-amount" class="form-control mb-3" type="text" placeholder="Amount" value="'.$row['amount'].'" disabled>
        </div>
        <div class="col-lg-6">
            <label>Check Date:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                </div>
                <input id="upd-due-date" class="form-control datepicker" placeholder="PO Due Date" disabled value="'.$check_date.'">
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <label>Company:</label>
          <select id="upd-company" class="form-control mb-3 select2" style="width: 100%;" disabled>
            <option selected disabled>Select a Company</option>';
              $getCompany = $company->get_active_company();
              while($rowComp = $getCompany->fetch(PDO::FETCH_ASSOC))
              {
                if($row['comp-id'] == $rowComp['id'])
                {
                  echo '<option value="'.$rowComp['id'].'" selected>'.$rowComp['company'].'</option>';
                }else{
                  echo '<option value="'.$rowComp['id'].'">'.$rowComp['company'].'</option>';
                }
              }
          echo '</select>
        </div>
        <div class="col-lg-6">
          <label>Supplier:</label>
          <select id="upd-supplier" class="form-control mb-3 select2"  style="width: 100%;" disabled>
            <option selected disabled>Select a Supplier</option>';
              $get2 = $supplier->get_active_supplier();
              while($row2 = $get2->fetch(PDO::FETCH_ASSOC))
              {
                if($row['supp-id'] == $row2['id'])
                {
                    echo '<option value="'.$row2['id'].'" selected>'.$row2['supplier_name'].'</option>';
                }else{
                    echo '<option value="'.$row2['id'].'">'.$row2['supplier_name'].'</option>';
                }
              }
          echo '</select>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <label style="padding-top: 15px">Project:</label>
          <select id="upd-project" class="form-control mb-3 select2" style="width: 100%;" disabled>
            <option selected disabled>Select a Project</option>';
              $get3 = $proj->get_active_project();
              while($row3 = $get3->fetch(PDO::FETCH_ASSOC))
              {
                  if($row['proj-id'] == $row3['id'])
                  {
                      echo '<option value="'.$row3['id'].'" selected>'.$row3['project'].'</option>';
                  }else{
                      echo '<option value="'.$row3['id'].'">'.$row3['project'].'</option>';
                  }
              }
          echo '</select>
        </div>
        <div class="col-lg-6">
          <label style="padding-top: 15px">Department:</label>
          <select id="upd-department" class="form-control mb-3 select2"  style="width: 100%;" disabled>
            <option selected disabled>Select a Department</option>';
              $get4 = $dept->get_active_department();
              while($row4 = $get4->fetch(PDO::FETCH_ASSOC))
              {
                  if($row['dept-id'] == $row4['id'])
                  {
                      echo '<option value="'.$row4['id'].'" selected>'.$row4['department'].'</option>';
                  }else{
                      echo '<option value="'.$row4['id'].'">'.$row4['department'].'</option>';
                  }
              }
          echo '</select>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8">
          <label style="padding-top: 15px">Billing/Invoice Date:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="upd-bill-date" class="form-control datepicker" placeholder="Enter Billing Date" onchange="getDueDateEdit()" value="'.$bill_date.'" disabled>
          </div>
        </div>
        <div class="col-lg-4">
          <label style="padding-top: 15px">Terms:</label>
          <input id="upd-terms" class="form-control mb-3" type="text" placeholder="Enter Terms" onchange="getDueDateEdit()" value="'.$row['terms'].'" disabled>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8">
        <label>Due Date:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="upd-due-date" class="form-control datepicker" placeholder="PO Due Date" disabled value="'.$due_date.'">
          </div>
        </div>
      </div>';     
}
?>