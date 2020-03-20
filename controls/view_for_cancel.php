<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';
include '../objects/clsProject.php';
include '../objects/clsDepartment.php';
include '../objects/clsBank.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$supplier = new Supplier($db);
$proj = new Project($db);
$dept = new Department($db);
$bank = new Banks($db);

$po->id = $_POST['id'];
$get = $po->get_po_by_id_for_cancel();

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
        <div id="check-details">
            <small><b><i>New Check Information</i></b></small>
            <div class="row">
                <div class="col-lg-6">
                    <label><i style="color: red">*</i> CV Number:</label>
                    <input id="new-cv-no" class="form-control mb-3" type="text" placeholder="Enter CV Number">
                </div>
                <div class="col-lg-6">
                    <label><i style="color: red">*</i> Check Number:</label>
                    <input id="new-check-no" class="form-control mb-3" type="text" placeholder="Enter Check Number">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label><i style="color: red">*</i> Bank:</label>
                    <select id="new-bank" class="form-control mb-3 select2" style="width: 100%;">
                    <option selected disabled>Select a Bank</option>';
                    $get = $bank->get_all_banks();
                    while($row5 = $get->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '<option value="'.$row5['id'].'">'.$row5['name'].'</option>';
                    }
                    echo '</select>
                </div>
                <div class="col-lg-6">
                <label><i style="color: red">*</i> Check Date:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input id="new-checkdate" class="form-control datepicker" placeholder="Enter Check Date">
                </div>
                </div>
            </div><hr>
            <small><b><i>Old Check Information</i></b></small>
            <div class="row">
                <div class="col-lg-6">
                    <label>CV Number:</label>
                    <input id="old-cv-no" class="form-control mb-3" type="text" placeholder="Enter CV Number" value="'.$row['cv_no'].'" disabled>
                </div>
                <div class="col-lg-6">
                    <label>Check Number:</label>
                    <input id="old-check-no" class="form-control mb-3" type="text" placeholder="Enter Check Number" value="'.$row['check_no'].'" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label>Bank:</label>
                    <select id="old-bank" class="form-control mb-3 select2" style="width: 100%;" disabled>
                      <option selected disabled>Select a Bank</option>';
                      $get = $bank->get_all_banks();
                      while($row5 = $get->fetch(PDO::FETCH_ASSOC))
                      {
                          if($row['bank-id'] == $row5['id'])
                          {
                            echo '<option value="'.$row5['id'].'" selected>'.$row5['name'].'</option>';
                          }  
                      }
                    echo '</select>
                </div>
                <div class="col-lg-6">
                <label>Check Date:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input id="old-checkdate" class="form-control datepicker" value="'.$check_date.'" disabled>
                </div>
                </div>
            </div>
        </div>
    <hr> 
      <div class="row">
        <div class="col-lg-6">
          <label>Invoice/Billing No:</label>
          <input id="po-id" class="form-control mb-3" type="text" placeholder="Enter Billing number" value="'.$row['po-id'].'" hidden>
          <input class="form-control mb-3" type="text" placeholder="Enter Billing number" value="'.$row['bill_no'].'" disabled>
        </div>
        <div class="col-lg-6">
          <label>PO/JO Number:</label>
          <input class="form-control mb-3" type="text" placeholder="Enter PO/JO number" value="'.$row['po_num'].'" disabled>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
            <label>Company:</label>
                <select class="form-control mb-3 select2" style="width: 100%;" disabled>
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
          <label>Payee:</label>
          <select class="form-control mb-3 select2"  style="width: 100%;" disabled>
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
            <label>Billing/Invoice Date:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                </div>
                <input class="form-control datepicker" placeholder="Enter Billing Date" onchange="getDueDate()" value="'.$bill_date.'" disabled>
            </div>
        </div>
        <div class="col-lg-6">
            <label>Due Date:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                </div>
                <input class="form-control datepicker" placeholder="PO Due Date" disabled value="'.$due_date.'">
            </div>
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
setDate: new Date(),
autoClose: true
});
</script>