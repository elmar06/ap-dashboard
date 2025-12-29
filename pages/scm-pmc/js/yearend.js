$(document).ready(function(){
  $('.DataTable').dataTable({
      scrollX: true
  })
})

//resubmit request
function reSubmit_yearEnd()
{
  var id = $('#upd-po-id').val();
  var action = 3;

  $.ajax({
    type: 'POST',
    url: '../../controls/process_yearend.php',
    data: {id:id, action:action},
    success: function(response){
      if(response > 0){
        toastr.success('Request successfully resubmit.');
        setTimeout(function(){
          location.reload();
        }, 1500)
      }else{
        toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
      }
    }
  }) 
}

//Submit the request to AP and mark as PENDING
function submit_toAP()
{
  var id = $('#upd-po-id').val();
  var action = 4;

  $.ajax({
    type: 'POST',
    url: '../../controls/process_yearend.php',
    data: {id:id, action:action},
    success: function(response){
      if(response > 0){
        toastr.success('Request successfully resubmit.');
        setTimeout(function(){
          location.reload();
        }, 1500)
      }else{
        toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
      }
    }
  }) 
}

//view details
$('.btnView').click(function(e){
  e.preventDefault();

  var id = $(this).val();
  $.ajax({
    type: 'POST',
    url: '../../controls/view_po_details_byID.php',
    data: {id: id},
    success: function(html)
    {
      $('#POmodalDetails').modal('show');
      $('#details-body').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})

//view details
$('.btnReceived').click(function(e){
  e.preventDefault();

  var id = $(this).val();
  $.ajax({
    type: 'POST',
    url: '../../controls/view_po_details_byID.php',
    data: {id: id},
    success: function(html)
    {
      $('#receivedDetails').modal('show');
      $('#received-body').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})

function upd_po_details()
{
  var id = $('#upd-po-id').val();
  var po_num = $('#upd-po-no').val();
  var ir_no = $('#upd-ir-no').val();
  var po_amount = $('#upd-po-amount').val();
  var po_date = $('#upd-po-date').val();
  var si_num = $('#upd-si-num').val();
  var si_amount = $('#upd-si-amount').val();
  var company = $('#upd-company').val();
  var supplier = $('#upd-supplier').val();
  var bill_date = $('#upd-bill-date').val();
  var counter_date = $('#upd-counter-date').val();
  var due_date = $('#upd-due-date').val();
  var terms = $('#upd-terms').val();
  var scm_remark = $('#upd-scm-remark').val(); 
  var memo_no = $('#upd-memo-no').val();
  var debit_memo = $('#upd-debit-memo').val(); 
  var memo_amount = $('#upd-memo-amount').val(); 
  //check if project & department is null/empty
  var project = 0;
  var department = 0;
  if($('#upd-project').val() != null){
    var project = $('#upd-project').val();
  }
  if($('#upd-department').val() != null){
    var project = $('#upd-department').val();
  }
  //check if it is shared
  var check = $('#remarks').is(':checked');
  if(check){
    var remark = 1;
  }else{
    var remark = 0;
  }
  //check if it is for Year-End
  var year_end = 0;
  var yearend = $('#upd-year-end').is(':checked');
  if(yearend){
    var year_end = 17;
  }

  var myData = 'id=' + id + '&po_num=' + po_num + '&ir_no=' + ir_no + '&po_amount=' + po_amount + '&po_date=' + po_date + '&si_num=' + si_num + '&si_amount=' + si_amount + '&company=' + company + '&supplier=' + supplier + '&project=' + project + '&department=' + department + '&bill_date=' + bill_date + '&counter_date=' + counter_date + '&due_date=' + due_date + '&terms=' + terms + '&scm_remark=' + scm_remark + '&remark=' + remark + '&memo_no=' + memo_no + '&debit_memo=' + debit_memo + '&memo_amount=' + memo_amount + '&year_end=' + year_end;

  if(po_num != null && po_amount != null && si_num != null && si_amount != null && company != null && supplier != null && bill_date != null && counter_date != null && due_date != null)
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/upd_po_details.php',
      data: myData,
      success: function(response)
      {
        if(response > 0)
        {
          toastr.success('Request successfully updated.');
          //get the updated list
          $.ajax({
              url: '../../controls/view_submit_po.php',
              success: function(html)
              {
                $('#page-body').fadeOut();
                $('#page-body').fadeIn();
                $('#page-body').html(html);
                $('#req-list').hide();
                $('#btnClear').fadeOut();
              }
            })
        }
        else
        {
          toastr.error('Update Failed. Please contact the Administrator at local 124.');
        }
      }
    })
  }
  else
  {
    toastr.error('Update Failed. Please input all the data needed.');
  }
}

//Edit button
function EnableFields()
{
  $('#upd-bill-date').attr('disabled', false);
  $('#upd-ir-no').attr('disabled', false);
  $('#upd-po-no').attr('disabled', false);
  $('#upd-si-num').attr('disabled', false);
  $('#upd-si-amount').attr('disabled', false);
  $('#upd-po-date').attr('disabled', false);
  $('#upd-counter-date').attr('disabled', false);
  $('#upd-due-date').attr('disabled', false);
  $('#upd-po-amount').attr('disabled', false);
  $('#upd-bill-no').attr('disabled', false);
  $('#upd-po-no').attr('disabled', false);
  $('#upd-company').attr('disabled', false);
  $('#upd-supplier').attr('disabled', false);
  $('#upd-project').attr('disabled', false);
  $('#upd-department').attr('disabled', false);
  $('#upd-terms').attr('disabled', false);
  $('#upd-amount').attr('disabled', false);
  $('#upd-sales-invoice').attr('disabled', false);
  $('#upd-scm-remark').attr('disabled', false);
  $('#btnEdit').attr('disabled', true);
  $('#btnClose').hide();
  $('#btnCancel').show();
  $('#btnSubmit').show();
  $('#btnResubmit').hide();
  
}

//Cancel button
function DisableFields()
{
  $('#upd-bill-date').attr('disabled', true);
  $('#upd-po-no').attr('disabled', true);
  $('#upd-si-num').attr('disabled', true);
  $('#upd-si-amount').attr('disabled', true);
  $('#upd-po-date').attr('disabled', true);
  $('#upd-counter-date').attr('disabled', true);
  $('#upd-due-date').attr('disabled', true);
  $('#upd-po-amount').attr('disabled', true);
  $('#upd-bill-no').attr('disabled', true);
  $('#upd-po-no').attr('disabled', true);
  $('#upd-company').attr('disabled', true);
  $('#upd-supplier').attr('disabled', true);
  $('#upd-project').attr('disabled', true);
  $('#upd-department').attr('disabled', true);
  $('#upd-terms').attr('disabled', true);
  $('#upd-amount').attr('disabled', true);
  $('#upd-sales-invoice').attr('disabled', true);
  $('#upd-scm-remark').attr('disabled', true);
  $('#btnEdit').attr('disabled', false);
  $('#btnClose').show();
  $('#btnCancel').hide();
  $('#btnSubmit').hide();
  $('#btnResubmit').show();
}