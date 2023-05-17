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

//get the Manila time by timezone
date_default_timezone_set('Asia/Manila');

$po->id = $_POST['id'];
$get = $po->get_po_by_id();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
  //format the date for display
  $bill_date = date('F d, Y', strtotime($row['bill_date']));
  $due_date = date('F d, Y', strtotime($row['due_date']));
  $date_submit = date('F d, Y', strtotime($row['date_submit']));

  //get the difference between bill_date & due_date
  $date1 = time();
  $date2 = strtotime($row['due_date']);
  $datediff = $date2 - $date1;
  $days_left = floor($datediff/(60*60*24))." day/s";

  echo '
      <div class="row">
        <div class="col-lg-6">
          <label><i style="color: red">*</i> Invoice/Billing No:</label>
          <input id="upd-id" class="form-control mb-3" type="text" placeholder="Enter Billing number" value="'.$row['po-id'].'" hidden>
          <input id="upd-status" class="form-control mb-3" type="text" placeholder="Enter Billing number" value="'.$row['status'].'" hidden>
          <input id="upd-bill-no" class="form-control mb-3" type="text" placeholder="Enter Billing number" value="'.$row['bill_no'].'" disabled>
        </div>
        <div class="col-lg-6">
          <label><i style="color: red">*</i> PO/JO Number:</label>
          <input id="upd-po-no" class="form-control mb-3" type="text" placeholder="Enter PO/JO number" value="'.$row['po_num'].'" disabled>
        </div>
      </div>
      <div class="row">
          <div class="col-lg-6">
            <label><i style="color: red">*</i> Amount</label>
            <input id="upd-amount" class="form-control mb-3" type="text" placeholder="Amount" value="'.number_format(floatval($row['amount']), 2).'" disabled>
          </div>
          <div class="col-lg-6">
            <label><i style="color: red">*</i> Sales Invoice No.</label>
            <input id="upd-sales-invoice" class="form-control mb-3" type="text" placeholder="Sales Invoice here.." value="'.$row['si_num'].'" disabled>
          </div>
        </div>
      <div class="row">
        <div class="col-lg-6">
          <label><i style="color: red">*</i> Company:</label>
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
          <label><i style="color: red">*</i> Supplier:</label>
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
          <label style="padding-top: 15px"><i style="color: red">*</i> Project:</label>
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
          <label style="padding-top: 15px"><i style="color: red">*</i> Billing/Invoice Date:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="upd-bill-date" class="form-control datepicker" placeholder="Enter Billing Date" onchange="getDueDateEdit()" value="'.$bill_date.'" disabled>
          </div>
        </div>
        <div class="col-lg-4">
          <label style="padding-top: 15px"><i style="color: red">*</i> Terms:</label>
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
        <div class="col-lg-4">
          <label>Days before Due</label>
          <input id="upd-days-due" class="form-control mb-3" type="text" placeholder="No. of Days" disabled value="'.$days_left.'">
          <input id="action" class="form-control mb-3" type="text" style="display:none">
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8">
            <label style="font-size: 13px"><b><i>Date Created/Submitted: '.$date_submit.'</i></b></label>
        </div>
      </div>
      <div id="btnReport" class="row" style="display:none">
        <div class="col-lg-8">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitch2" onchange="addReport()" name="report[]">
            <label class="custom-control-label" for="customSwitch2"> Add Incident Report</label>
          </div>
        </div>
      </div>
      <div class="row report" style="display:none">
        <div class="col-lg-12">
          <label style="padding-top: 15px"><i style="color: red">*</i> Incident Report</label>
          <textarea id="report" class="form-control mb-3" type="text" placeholder="Report here.."></textarea>
        </div>
      </div>';
      //get the MEMO NO(MARK AS CREDIT MEMO)
      if($row['memo_no'] != null || $row['memo_no'] != '')
      {
        echo '<div class="report">
                <hr>
                <div class="row">
                  <div class="col-lg-6">
                    <input id="memo-no" class="form-control mb-3" type="text" placeholder="Input Memo No. here" value="'.$row['memo_no'].'">
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <input id="debit-memo" class="form-control mb-3" type="text" placeholder="Input Debit Memo No. here" value="'.$row['debit_memo'].'">
                  </div>
                  <div class="col-lg-6">
                  <input id="memo-amount" class="form-control mb-3" type="text" placeholder="Input Memo Amount here" value="'.$row['memo_amount'].'">
                  </div>
                </div>
                <hr>
              </div>';
      }
      //get the REASON OF RETURNED (IF MARK AS RETURNED)
      if($row['status'] == 2)
      {
        echo '<div class="row remarks">
                <div class="col-lg-12">
                  <label><i style="color: red">*</i> Remarks</label>
                  <textarea id="remarks" class="form-control mb-3" type="text" placeholder="Reason of return" disabled>'.$row['remarks'].'</textarea>
                </div>
              </div>';
      }else{
        echo '<div class="row remarks" style="display:none">
                <div class="col-lg-12">
                  <label><i style="color: red">*</i> Remarks</label>
                  <textarea id="remarks" class="form-control mb-3" type="text" placeholder="Reason of return"></textarea>
                </div>
              </div>';
      }      
      echo '
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