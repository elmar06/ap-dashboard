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
  $bill_date = date('F d, Y', strtotime($row['bill_date']));
  $due_date = date('F d, Y', strtotime($row['due_date']));
  $po_date = '';
  if($row['po_date'] != null || $row['po_date'] != ''){
    $po_date = date('F d, Y', strtotime($row['po_date']));
  }
  $counter_date = '';
  if($row['counter_date'] != null || $row['counter_date'] != ''){
    $counter_date = date('F d, Y', strtotime($row['counter_date']));
  }
  //number format
  $po_amount = number_format($row['po_amount'],2);
  $si_amount = number_format($row['amount'],2);
  $memo_amount = number_format($row['memo_amount'],2);
  //get the difference between bill_date & due_date
  $date1 = time();
  $date2 = strtotime($row['due_date']);
  $datediff = $date2 - $date1;
  $days_left = floor($datediff/(60*60*24))." day/s";

  echo '
      <div class="row">
        <div class="col-lg-6">
          <label><i style="color: red">*</i> PO/JO Number:</label>
          <input id="upd-po-no" class="form-control mb-3" type="text" placeholder="Enter PO/JO number" value="'.$row['po_num'].'">
          <input id="upd-po-id" class="form-control mb-3" type="text" placeholder="Enter PO/JO number" value="'.$row['po-id'].'" hidden>
        </div>
        <div class="col-lg-6">
          <label><i style="color: red">*</i> RR/IR Number:</label>
          <input id="upd-ir-no" class="form-control mb-3" type="text" placeholder="Enter RR/IR number" value="'.$row['ir_rr_no'].'">
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <label><i style="color: red">*</i> PO/Contract Amount:</label>
          <input id="upd-po-amount" class="form-control mb-3 amount" type="text" placeholder="Enter Amount" value="'.$po_amount.'">
        </div>
        <div class="col-lg-6">
          <label></i> PO Date:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="upd-po-date" class="form-control datepicker" placeholder="Enter PO Date" value="'.$po_date.'">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <label><i style="color: red">*</i> SI No/Type of Billing:</label>
          <input id="upd-si-num" class="form-control mb-3" type="text" placeholder="Enter Billing number" value="'.$row['si_num'].'">
        </div>
        <div class="col-lg-6">
          <label><i style="color: red">*</i> SI/Billing Amount</label>
          <input id="upd-si-amount" class="form-control mb-3 amount" type="text" placeholder="Enter Amount" value="'.$si_amount.'">
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <label><i style="color: red">*</i> Company:</label>
          <select id="upd-company" class="form-control mb-3 select2" style="width: 100%;">
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
          <select id="upd-supplier" class="form-control mb-3 select2"  style="width: 100%;">
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
          <select id="upd-project" class="form-control mb-3 select2" style="width: 100%;">
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
          <select id="upd-department" class="form-control mb-3 select2"  style="width: 100%;">
            <option value="0" selected disabled>Select a Department</option>';
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
        <div class="col-lg-6" style="margin-top: 17px">
          <label><i style="color: red">*</i> Billing/SI Date:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="upd-bill-date" class="form-control datepicker" placeholder="Enter Billing Date" onchange="getDueDate()" value="'.$bill_date.'">
          </div>
        </div>
        <div class="col-lg-6" style="margin-top: 17px">
          <label><i style="color: red">*</i> Received/Counter Date:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="upd-counter-date" class="form-control datepicker" placeholder="Enter Received/Counter Date" value="'.$counter_date.'">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <label><i style="color: red">*</i> Due Date:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="upd-due-date" class="form-control datepicker" placeholder="Due Date" value="'.$due_date.'">
          </div>
        </div>
        <div class="col-lg-6">
          <label><i style="color: red">*</i> Terms:</label>
          <input id="upd-terms" class="form-control mb-3" type="text" placeholder="Enter Terms" onchange="getDueDate()" value="'.$row['terms'].'">
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <label>Remarks</label>
          <textarea id="upd-scm-remark" class="form-control mb-3" type="text" placeholder="Remarks / Additional Details" disabled>'.$row['scm_remark'].'</textarea>
        </div>
      </div>';
      if($row['status'] == 2)
      {
        echo '<div class="row remarks">
                <div class="col-lg-12">
                  <label>Remarks</label>
                  <textarea class="form-control mb-3" type="text" placeholder="Reason of return" disabled>'.$row['remarks'].'</textarea>
                </div>
              </div>';
      }else{
        echo '<div class="row remarks" style="display:none">
                <div class="col-lg-12">
                  <label>Remarks</label>
                  <textarea class="form-control mb-3" type="text" placeholder="Reason of return"></textarea>
                </div>
              </div>';
      } 
      if($row['memo_no'] != null || $row['memo_no'] != ''){
        echo '
            <div class="row">
              <div class="col-lg-4">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="upd-customSwitch1" onchange="mark_as_credit_memo()" checked>
                  <label class="custom-control-label" for="upd-customSwitch1"> Credit Memo</label>
                </div>
              </div>
            </div>
            <div class="report">
              <hr>
              <div class="row">
                <div class="col-lg-6">
                  <input id="upd-memo-no" class="form-control mb-3" type="text" placeholder="Input Memo No. here" value="'.$row['memo_no'].'">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <input id="upd-debit-memo" class="form-control mb-3" type="text" placeholder="Input Debit Memo No. here" value="'.$row['debit_memo'].'">
                </div>
                <div class="col-lg-6">
                <input id="upd-memo-amount" class="form-control mb-3" type="text" placeholder="Input Memo Amount here" value="'.$memo_amount.'">
                </div>
              </div>
              <hr>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="upd-remarks">
                  <label class="custom-control-label" for="remarks"> Share this records with SCM/PMC</label>
                </div>
              </div>
            </div>';
      }else{
        echo '
            <div class="row">
              <div class="col-lg-4">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="upd-customSwitch1" onchange="mark_as_credit_memo()">
                  <label class="custom-control-label" for="upd-customSwitch1"> Credit Memo</label>
                </div>
              </div>
            </div>
            <div class="report" style="display: none">
              <hr>
              <div class="row">
                <div class="col-lg-6">
                  <input id="upd-memo-no" class="form-control mb-3" type="text" placeholder="Input Memo No. here">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <input id="upd-debit-memo" class="form-control mb-3" type="text" placeholder="Input Debit Memo No. here">
                </div>
                <div class="col-lg-6">
                <input id="upd-memo-amount" class="form-control mb-3 amount" type="text" placeholder="Input Memo Amount here">
                </div>
              </div>
              <hr>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="upd-remarks">
                  <label class="custom-control-label" for="upd-remarks"> Share this records with SCM/PMC</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">';
                if($row['yrEnd_stat'] == 1){
                  echo '<div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="upd-year-end" checked>
                          <label class="custom-control-label" for="upd-year-end"> Check for Year-End Report</label>
                        </div>';
                }else{
                  echo '<div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="upd-year-end">
                          <label class="custom-control-label" for="upd-year-end"> Check for Year-End Report</label>
                        </div>';
                }
              echo '</div>
            </div>';
            if($row['status'] == 18)
            {
              echo '<div class="row remarks">
                      <div class="col-lg-12">
                        <label><b>Year-End Returned Reason</b></label>
                        <textarea id="upd-yearEnd-remarks" class="form-control mb-3" type="text" placeholder="Reason of return" disabled>'.$row['yearEnd_remark'].'</textarea>
                      </div>
                    </div>';
            }
      }     
      echo '
      <div id="upd-success" class="alert alert-success" role="alert" style="display: none"></div>
      <div id="upd-warning" class="alert alert-danger" role="alert" style="display: none"></div>';
}
?>
<script>
  $(document).ready(function(){
    //disable all input
    $('input[type=text]').prop('disabled', true);
    $('.select2').prop('disabled', true);
    $('.datepicker').prop('disabled', true);
    $('#date-to-manila').prop('disabled', false);
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
//set request for Credit Memo
function mark_as_credit_memo()
{
  $('.report').toggle();
}
</script>