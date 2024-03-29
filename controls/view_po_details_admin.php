<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';
include '../objects/clsProject.php';
include '../objects/clsDepartment.php';
include '../objects/clsCheckDetails.php';
include '../objects/clsBank.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$supplier = new Supplier($db);
$proj = new Project($db);
$dept = new Department($db);
$check = new CheckDetails($db);
$bank = new Banks($db);

$po->id = $_POST['id'];

$get = $po->get_po_by_id();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
  //get the Manila time by timezone
  date_default_timezone_set('Asia/Manila');
  //format the date for display
  $po_date = '';
  $bill_date = date('F d, Y', strtotime($row['bill_date']));
  $due_date = date('F d, Y', strtotime($row['due_date']));
  if($row['po_date'] != null || $row['po_date'] != ''){
    $po_date = date('F d, Y', strtotime($row['po_date']));
  }
  //number format
  $po_amount = number_format($row['po_amount'],2);
  $si_amount = number_format($row['amount'],2);
  //get the difference between bill_date & due_date
  $date1 = time();
  $date2 = strtotime($row['due_date']);
  $datediff = $date2 - $date1;
  $days_left = floor($datediff/(60*60*24))." day/s";

  echo '
      <div class="row">
        <div class="col-lg-6">
          <label><i style="color: red">*</i> PO/JO Number:</label>
          <input id="po-no" class="form-control mb-3" type="text" placeholder="Enter PO/JO number" value="'.$row['po_num'].'">
          <input id="po-id" class="form-control mb-3" type="text" placeholder="Enter PO/JO number" value="'.$row['po-id'].'">
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <label><i style="color: red">*</i> PO/Contract Amount:</label>
          <input id="po-amount" class="form-control mb-3 amount" type="text" placeholder="Enter Amount" value="'.$po_amount.'">
        </div>
        <div class="col-lg-6">
          <label></i> PO Date:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="po-date" class="form-control datepicker" placeholder="Enter PO Date" value="'.$po_date.'">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <label><i style="color: red">*</i> SI No/Type of Billing:</label>
          <input id="si-num" class="form-control mb-3" type="text" placeholder="Enter Billing number" value="'.$row['si_num'].'">
        </div>
        <div class="col-lg-6">
          <label><i style="color: red">*</i> SI/Billing Amount</label>
          <input id="si-amount" class="form-control mb-3 amount" type="text" placeholder="Enter Amount" value="'.$si_amount.'">
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <label><i style="color: red">*</i> Company:</label>
          <select id="company" class="form-control mb-3 select2" style="width: 100%;">
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
          <label><i style="color: red">*</i> Supplier:</label>
          <select id="supplier" class="form-control mb-3 select2"  style="width: 100%;">
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
        <div class="col-lg-6"  style="margin-top: 16px">
          <label> Project:</label>
          <select id="project" class="form-control mb-3 select2" style="width: 100%;">
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
        <div class="col-lg-6"  style="margin-top: 16px">
          <label>Department:</label>
          <select id="department" class="form-control mb-3 select2"  style="width: 100%;">
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
        <div class="col-lg-8" style="margin-top: 17px">
          <label><i style="color: red">*</i> Billing/SI Date:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="bill-date" class="form-control datepicker" placeholder="Enter Billing Date" onchange="getDueDate()" value="'.$bill_date.'">
          </div>
        </div>
        <div class="col-lg-4" style="margin-top: 17px">
          <label><i style="color: red">*</i> Terms:</label>
          <input id="terms" class="form-control mb-3" type="text" placeholder="Enter Terms" onchange="getDueDate()" value="'.$row['terms'].'">
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8">
        <label><i style="color: red">*</i> Due Date:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="due-date" class="form-control datepicker" placeholder="Due Date" value="'.$due_date.'">
          </div>
        </div>
      </div>';
      if($row['status'] == 2)
      {
        echo '<div class="row remarks">
                <div class="col-lg-12">
                  <label>Remarks</label>
                  <textarea id="remarks" class="form-control mb-3" type="text" placeholder="Reason of return" disabled>'.$row['remarks'].'</textarea>
                </div>
              </div>';
      }else{
        echo '<div class="row remarks" style="display:none">
                <div class="col-lg-12">
                  <label>Remarks</label>
                  <textarea id="remarks" class="form-control mb-3" type="text" placeholder="Reason of return"></textarea>
                </div>
              </div>';
      }      
    //get the check details
    $check->po_id = $row['po-id'];
    $get = $check->get_details_byID();

    while($row1 = $get->fetch(PDO::FETCH_ASSOC))
    {
        if($row1['receipt'] == null || $row1['receipt'] == ''){
            $receipt = '<input id="receipt-no" class="form-control mb-3" type="text" placeholder="Input Receipt number">';
        }else{
            $receipt = '<input id="receipt-no" class="form-control mb-3" type="text" value="'.$row1['receipt'].'" disabled>';
        }
        //format the date for display
        $check_date = date('F d, yy', strtotime($row1['check_date']));
        echo '<small><b><i>Check Information</i></b></small>
        <div class="row">
            <div class="col-lg-6">
                <label>CV Number:</label>
                <input class="form-control mb-3" type="text" placeholder="Enter CV Number" value="'.$row1['cv_no'].'" disabled>
                <input id="po-id" class="form-control mb-3" type="text" placeholder="Enter CV Number" value="'.$row1['po_id'].'" hidden>
            </div>
            <div class="col-lg-6">
                <label>Check Number:</label>
                <input class="form-control mb-3" type="text" placeholder="Enter Check Number" value="'.$row1['check_no'].'" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <label>Bank:</label>
                <select class="form-control mb-3 select2" style="width: 100%;" disabled>
                    <option selected disabled>Select a Bank</option>';
                    $get = $bank->get_all_banks();
                    while($row2 = $get->fetch(PDO::FETCH_ASSOC))
                    {
                        if($row['bank'] == $row2['id'])
                        {
                            echo '<option value="'.$row2['id'].'" selected>'.$row2['name'].'</option>';
                        }else{
                            echo '<option value="'.$row2['id'].'">'.$row2['name'].'</option>';
                        }
                    }
                echo '</select>
            </div>
            <div class="col-lg-6">
            <label>Billing/Invoice Date:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                </div>
                <input class="form-control datepicker" placeholder="Enter Check Date" value="'.$check_date.'" disabled>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <label><i style="color: red">*</i> OR/CR Number:</label>
                <input id="or-num" class="form-control mb-3" type="text" placeholder="Enter OR/CR Number">
            </div>
            <div class="col-lg-6">
                <label> Probitionary Receipt:</label>
                '.$receipt.'
            </div>
        </div>
        <div id="success" class="alert alert-success" role="alert" style="display: none"></div>
        <div id="warning" class="alert alert-danger" role="alert" style="display: none"></div>';
    }

}
?>
<script>
  $(document).ready(function(){
    //disable all input
    $('input[type=text]').prop('disabled', true);
    $('.select2').prop('disabled', true);
    $('.datepicker').prop('disabled', true);
    //hide po-id input
    $('#po-id').hide();
  })
  //select2
  $(".select2").select2();
  //datepicker
  $('.datepicker').datepicker({
    clearBtn: true,
    format: "MM dd, yyyy",
    setDate: new Date(),
    autoClose: true
  });

  //format amount
  $('#upd-amount').on('blur', function() {
  const value = this.value.replace(/,/g, '');
  this.value = parseFloat(value).toLocaleString('en-US', {
    style: 'decimal',
    maximumFractionDigits: 2,
    minimumFractionDigits: 2
  });
});

//get the terms per supplier
$('#upd-supplier').on('change', function(){
  var id = $(this).val();

  $.ajax({
    type: 'POST',
    url: '../../controls/get_terms.php',
    data: {id:id},
    dataType: 'json',
    cache: false,
    success: function(result)
    {
      var term = result[0];
      if(term == null || term == '')
      {
        $('#upd-terms').val('0');
      }else{
        $('#upd-terms').val(term);
      }
    }
  })
})
</script>