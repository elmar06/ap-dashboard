$(document).ready(function(){
  $('.DataTable').dataTable({
      scrollX: true
  })
})

//received Request
$('.btnReceive').on('click', function(e){
  e.preventDefault();

  var id = $(this).val();
  var action = 1;
  $.ajax({
    type: 'POST',
    url: '../../controls/process_yearend.php',
    data: {id:id, action:action},
    success: function(response){
      if(response > 0){
        toastr.success('Request successfully received.');
        setTimeout(function(){
          location.reload();
        }, 1500)
      }else{
        toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
      }
    }
  }) 
})

//returned request
$('.btnResubmit').on('click', function(e){
  e.preventDefault();

  var id = $(this).val();
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
})

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

function upd_po_details()
{
  var id = $('#upd-id').val();
  var bill_no = $('#upd-bill-no').val();
  var po_num = $('#upd-po-no').val();
  var company = $('#upd-company').val();
  var supplier = $('#upd-supplier').val();
  var project = $('#upd-project').val();
  var department = $('#upd-department').val();
  var bill_date = $('#upd-bill-date').val();
  var terms = $('#upd-terms').val();
  var due_date = $('#upd-due-date').val();
  var days_due = $('#upd-days-due').val();
  var amount = $('#upd-amount').val();
  var si_num = $('#upd-sales-invoice').val();

  var myData = 'id=' + id + '&bill_date=' + bill_date + '&terms=' + terms + '&due_date=' + due_date + '&days_due=' + days_due + '&bill_no=' + bill_no + '&po_num=' + po_num + '&company=' + company + '&supplier=' + supplier + '&project=' + project + '&department=' + department + '&amount=' + amount + '&si_num=' + si_num;

  if(bill_date != null && bill_no != '' && po_num != '' && company != null && supplier != null && project != null && amount != null)
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/upd_po_details.php',
      data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(response)
      {
        if(response > 0)
        {
          $('#upd-success').html('<center><i class="fas fa-check"></i> PO Successfully updated.</center>');
          $('#upd-success').show();
          setTimeout(function(){
            $('#upd-success').fadeOut();
          }, 3000)
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
          $('#upd-warning').html('<center><i class="fas fa-ban"></i> Update Failed. Please contact the Administrator at local 124.</center>');
          $('#upd-warning').show();
          setTimeout(function(){
            $('#upd-warning').fadeOut();
          }, 5000)
        }
      }
    })
  }
  else
  {
    $('#upd-warning').html('<center><i class="fas fa-ban"></i> Update Failed. Please input all the data needed.</center>');
    $('#upd-warning').show();
    setTimeout(function(){
      $('#upd-warning').fadeOut();
    }, 3000)
  }
}

//Edit button
function EnableFields()
{
  $('#upd-bill-date').attr('disabled', false);
  $('#upd-bill-no').attr('disabled', false);
  $('#upd-po-no').attr('disabled', false);
  $('#upd-company').attr('disabled', false);
  $('#upd-supplier').attr('disabled', false);
  $('#upd-project').attr('disabled', false);
  $('#upd-department').attr('disabled', false);
  $('#upd-terms').attr('disabled', false);
  $('#upd-amount').attr('disabled', false);
  $('#upd-sales-invoice').attr('disabled', false);
  $('#btnEdit').attr('disabled', true);
  $('#btnClose').hide();
  $('#btnCancel').show();
  $('#btnSubmit').attr('disabled', false);
}

//Cancel button
function DisableFields()
{
  $('#upd-bill-date').attr('disabled', true);
  $('#upd-bill-no').attr('disabled', true);
  $('#upd-po-no').attr('disabled', true);
  $('#upd-amount').attr('disabled', true);
  $('#upd-sales-invoice').attr('disabled', true);
  $('#upd-company').attr('disabled', true);
  $('#upd-supplier').attr('disabled', true);
  $('#upd-project').attr('disabled', true);
  $('#upd-department').attr('disabled', true);
  $('#upd-terms').attr('disabled', true);
  $('#btnEdit').attr('disabled', false);
  $('#btnClose').show();
  $('#btnCancel').hide();
  $('#btnSubmit').attr('disabled', true);
}