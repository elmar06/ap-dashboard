<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';
include '../objects/clsProject.php';
include '../objects/clsDepartment.php';
include '../objects/clsBank.php';
include '../objects/clsCheckDetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$supplier = new Supplier($db);
$proj = new Project($db);
$dept = new Department($db);
$bank = new Banks($db);
$check = new CheckDetails($db);

$po->id = $_POST['id'];
$get = $po->get_po_by_id();

while($row = $get->fetch(PDO::FETCH_ASSOC))
{
  //get the Manila time by timezone
  date_default_timezone_set('Asia/Manila');
  //format the date for display
  $bill_date = date('F d, Y', strtotime($row['bill_date']));
  $due_date = date('F d, Y', strtotime($row['due_date']));

  //get the difference between bill_date & due_date
  $date1 = time();
  $date2 = strtotime($row['due_date']);
  $datediff = $date2 - $date1;
  $days_left = floor($datediff/(60*60*24))." day/s";

  //get the check details of the request if exist
  $cv_num = '';
  $check_no = '';
  $vbank = '';
  $check_date = '';
  $wtax = '';
  $vamount = '';
  $get_check = $check->get_details_byID($row['po-id']);
  while($row6 = $get_check->fetch(PDO:: FETCH_ASSOC))
  {
    $cv_num = $row6['cv_no'];
    $check_no = $row6['check_no'];
    $vbank = $row6['bank'];
    $check_date = date('F d, Y', strtotime($row6['check_date']));
    $wtax = $row6['tax'];
    $vamount = $row6['cv_amount'];
    $check_po_id = $row6['po_id']; 
    $check_id = $row6['check-id']; 
  }

  echo '
        <div id="check-details">
            <small><b><i>Check Information</i></b></small>
            <div class="row">
                <div class="col-lg-6">
                    <label><i style="color: red">*</i> CV Number:</label>
                    <input id="cv-no" class="form-control mb-3" type="text" placeholder="Enter CV Number" value="'.$cv_num.'">
                </div>
                <div class="col-lg-6">
                    <label><i style="color: red">*</i> Check Number:</label>
                    <input id="check-no" class="form-control mb-3" type="text" placeholder="Enter Check Number" value="'.$check_no.'">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label><i style="color: red">*</i> Bank:</label>
                    <select id="bank" class="form-control mb-3 select2" style="width: 100%;">
                      <option selected disabled>Select a Bank</option>';
                      $get = $bank->get_all_banks();
                      while($row5 = $get->fetch(PDO::FETCH_ASSOC))
                      {
                        if($row5['id'] == $vbank){
                          echo '<option value="'.$row5['id'].'" selected><b>'.$row5['account'].'</option>';
                        }else{  
                          echo '<option value="'.$row5['id'].'"><b>'.$row5['account'].'</option>';
                        }
                      }
                    echo '</select>
                </div>
                <div class="col-lg-6">
                <label><i style="color: red">*</i> Check Date:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input id="checkdate" class="form-control datepicker" placeholder="Enter Check Date" value="'.$check_date.'">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                  <label><i style="color: red">*</i> Withholding Tax:</label>
                  <input id="cv-tax" class="form-control mb-3" type="text" placeholder="Enter Withholding Tax Amount" value="'.$wtax.'">
              </div>
              <div class="col-lg-6">
                  <label><i style="color: red">*</i> Voucher Amount:</label>
                  <input id="cv-amount" class="form-control mb-3" type="text" placeholder="Enter Voucher Amount" value="'.$vamount.'">
              </div>
            </div>
        </div>
    <hr> 
      <div class="row">
        <div class="col-lg-6">
          <label>Invoice/Billing No:</label>
          <input id="upd-id" class="form-control mb-3" type="text" placeholder="po-id" value="'.$row['po-id'].'" hidden>
          <input id="upd-check-po-id" class="form-control mb-3" type="text" placeholder="check-po-id" value="'.$check_po_id.'" hidden>
          <input id="upd-check-id" class="form-control mb-3" type="text" placeholder="check-id" value="'.$check_id.'" hidden>
          <input id="upd-status" class="form-control mb-3" type="text" placeholder="status" value="'.$row['status'].'" hidden>
          <input id="upd-bill-no" class="form-control mb-3" type="text" placeholder="Enter Billing number" value="'.$row['bill_no'].'" disabled>
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
          <label>Sales Invoice No.</label>
          <input id="upd-sales-invoice" class="form-control mb-3" type="text" placeholder="Sales Invoice here.." value="'.$row['si_num'].'" disabled>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <label>Company:</label>
          <select id="upd-company" class="form-control mb-3 select2" style="width: 100%;" disabled>
            <option selected disabled>Select a Company</option>';
              $get1 = $company->get_active_company();
              while($row1 = $get1->fetch(PDO::FETCH_ASSOC))
              {
                  if($row['comp-id'] == $row1['id'])
                  {
                    echo '<option value="'.$row1['id'].'" selected>'.$row1['company'].'</option>';
                  }else{
                    echo '<option value="'.$row1['id'].'">'.$row1['company'].'</option>';
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
          <label style="margin-top: 16px">Project:</label>
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
          <label style="margin-top: 16px">Department:</label>
          <select id="upd-department" class="form-control mb-3 select2"  style="width: 100%;" disabled>
            <option selected disabled>Select a Department</option>';
              $get = $dept->get_active_department();
              while($row4 = $get->fetch(PDO::FETCH_ASSOC))
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
          <label style="margin-top: 16px">Billing/Invoice Date:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="upd-bill-date" class="form-control datepicker" placeholder="Enter Billing Date" onchange="getDueDate()" value="'.$bill_date.'" disabled>
          </div>
        </div>
        <div class="col-lg-4">
          <label style="margin-top: 16px">Terms:</label>
          <input id="upd-terms" class="form-control mb-3" type="text" placeholder="Enter Terms" onchange="getDueDate()" value="'.$row['terms'].'" disabled>
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
        <div class="col-lg-4">
          <label>Days before Due</label>
          <input id="upd-days-due" class="form-control mb-3" type="text" placeholder="No. of Days" disabled value="'.$days_left.'">
          <input id="action" class="form-control mb-3" type="text" style="display:none">
        </div>
      </div>   
      <div id="upd-success" class="alert alert-success" role="alert" style="display: none"></div>
      <div id="upd-warning" class="alert alert-danger" role="alert" style="display: none"></div>';
}
?>

<script>
$(".select2").select2();

//datepicker
$('.datepicker').datepicker({
clearBtn: true,
format: "MM dd, yyyy",
//startDate: new Date(),
autoClose: true
});
</script>