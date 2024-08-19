<!-- Page level custom scripts -->
<script>
$(document).ready(function () {
  $('.select2').select2();
  $('#submitted-table').DataTable({
    scrollX: true
  }); // ID From dataTable with Hover
  $('.DataTable').DataTable({
    scrollX: true
  }); // ID From dataTable with Hover
});

//toast
function showToast(){
  var title = 'Loading...';
  var duration = 500;
  $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
}
function hideLoading(){
  $.Toast.hideToast();
}

//get all the pending
function get_pending_po()
{  
  var status = 1;

  $.ajax({
    type: 'POST',
    url: '../../controls/get_list.php',
    data: {status: status},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}

//get all the returned po
function get_returned_po()
{
  var status = 2;
  
  $.ajax({
    type: 'POST',
    url: '../../controls/get_list.php',
    data: {status: status},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}

//get in process po
function get_process_po()
{
  var status = 3;
  
  $.ajax({
    type: 'POST',
    url: '../../controls/get_list.php',
    data: {status: status},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}

//get po for releasing
function get_releasing_po()
{
  var status = 8;
  
  $.ajax({
    type: 'POST',
    url: '../../controls/get_list.php',
    data: {status: status},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}

//view details
$(document).on('dblclick', '#submitted-table tr', function(){
  var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();

  //show the edit modal
  $.ajax({
    type: 'POST',
    url: '../../controls/view_po_details_admin.php',
    data: {id:id},
    beforeSend: function()
    {
      showToast();
    },
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
//Void event handler
function void_po()
{
  var id = $('#po-id').val();

  $.ajax({
    type: 'POST',
    url: '../../controls/delete_po.php',
    data: {id: id},
    success: function(response)
    {
      if(response > 0){
        toastr.success('PO/JO successfully marked as Void.');
        setTimeout(function(){
          location.reload();
        }, 1400)
      }else{
        alert(response);
      }
    }
  })
}
//Cancel Check event Handler
function cancel_po()
{
  var id = $('#po-id').val();

  $.ajax({
    type: 'POST',
    url: '../../controls/admin/cancel_po.php',
    data: {id: id},
    success: function(response)
    {
      if(response > 0){
        toastr.success('PO/JO successfully marked as Void.');
        setTimeout(function(){
          location.reload();
        }, 1400)
      }else{
        alert(response);
      }
    }
  })
}
//mark the po as stale check
function stale_check()
{
  var id = $('#po-id').val();

  $.ajax({
    type: 'POST',
    url: '../../controls/admin/stale_check.php',
    data: {id: id},
    success: function(response)
    {
      if(response > 0){
        toastr.success('PO/JO successfully marked as Void.');
        setTimeout(function(){
          location.reload();
        }, 1400)
      }else{
        alert(response);
      }
    }
  })
}
//Mark as Released event Handler
function release_po()
{
  var id = $('#po-id').val();
  var or_num = $('#or-num').val();
  var receipt = $('#receipt-num').val();
  var date_release = $('#release-date').val();
  var release_by = $('#released-by').val();
  var myData = 'id=' + id + '&or_num=' + or_num + '&receipt=' + receipt + '&date_release=' + date_release + '&release_by=' + release_by;

  if(release_by == null && date_release == null){
    toastr.error('ERROR! Add a date released and Released by to proceed.');
  }else{
    $.ajax({
      type: 'POST',
      url: '../../controls/admin/mark_released.php',
      data: myData,
      success: function(response)
      {
        if(response > 0){
          toastr.success('PO/JO successfully marked as Void.');
          setTimeout(function(){
            location.reload();
          }, 1400)
        }else{
          toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
        }
      }
    })
  }
}
//update details event handler 
function update_details()
{
  //po details
  var id = $('#po-id').val();
  var status = $('#status').val();
  var po_num = $('#po-no').val();
  var ir_num = $('#ir-no').val();
  var po_amount = $('#po-amount').val();
  var po_date = $('#po-date').val();
  var si_num = $('#si-num').val();
  var si_amount = $('#si-amount').val();
  var company = $('#company').val();
  var supplier = $('#supplier').val();
  var project = $('#project').val();
  var department = $('#department').val();
  var bill_date = $('#bill-date').val();
  var counter_date = $('#counter-date').val();
  var terms = $('#terms').val();
  var due_date = $('#due-date').val();
  var remark = $('#remarks').val();
  var scm_remark = $('#scm-remarks').val();
  var status = $('#status').val();
  //credit memo
  var memo_no = $('#memo-no').val();
  var debit_memo = $('#debit-memo').val();
  var memo_amount = $('#memo-amount').val();
  //check details
  var check_id = $('#check-id').val();
  var cv_no = $('#cv-num').val();
  var check_no = $('#check-no').val();
  var bank = $('#bank').val();
  var check_date = $('#check-date').val();
  var or_num = $('#or-num').val();
  var receipt_num = $('#receipt-num').val();
  var date_release = $('#release-date').val();
  var released_by = $('#released-by').val();

  var myData = 'id=' + id + '&po_num=' + po_num + '&ir_num=' + ir_num + '&po_amount=' + po_amount + '&po_date=' + po_date + '&si_num=' + si_num + '&si_amount=' + si_amount + '&company=' + company + '&supplier=' + supplier + '&project=' + project + '&department=' + department + '&bill_date=' + bill_date + '&counter_date=' + counter_date + '&terms=' + terms + '&due_date=' + due_date + '&status=' + status + '&remarks=' + remark + '&scm_remark=' + scm_remark + '&memo_no=' + memo_no + '&debit_memo=' + debit_memo + '&memo_amount=' + memo_amount + '&check_id=' + check_id + '&cv_no=' + cv_no + '&check_no=' + check_no + '&bank=' + bank + '&check_date=' + check_date + '&or_num=' + or_num + '&receipt_num=' + receipt_num + '&date_release=' + date_release + '&released_by=' + released_by + '&check_id=' + check_id + '&cv_no=' + cv_no + '&check_no=' + check_no + '&bank=' + bank + '&check_date=' + check_date;

  $.ajax({
    type: 'POST',
    url: '../../controls/admin/upd_po_details.php',
    data: myData,
    success: function(response)
    {
      if(response > 0){
        toastr.success('PO/JO details successfully updated.');
        setTimeout(function(){
          location.reload();
        }, 1400)
      }else{
        toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
      }
    }
  })
}

//check if logcount is zero
$(document).ready(function(){
  
  var id = $('#user-id').val();
  var logcount = $('#logcount').val();

  if(logcount == 0){
    $.ajax({
      type: 'POST',
      url: '../../controls/get_user_data.php',
      data: {id: id},
      success: function(html)
      {
        $('#changePassModal').modal({backdrop: 'static', keyboard: false});
        $('#pass-body').html(html);
      }
    })
  }
})
//set request for Credit Memo
function mark_as_credit_memo()
{
  $('.report').toggle();
}

//save new password
function changePassword()
{
  var id = $('#pass-id').val();
  var password = $('#password').val();
  var myData = 'id=' + id + '&password=' + password;

  if(password != '')
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/change_password.php',
      data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(response)
      {
        if(response > 0)
        {
          $('#changePassModal').modal('hide');
          $('#noticeModal').modal({backdrop: 'static', keyboard: false});
        }else{
          $('#pass-warning').html('<center><i class="fas fa-ban"></i> Update Failed. Please contact the system administrator at local 124 for assistance.</center>');
          $('#pass-warning').show();
          setTimeout(function(){
            $('#pass-warning').fadeOut();
          }, 3000)
        }
      }
    })
  }else{
    $('#pass-warning').html('<center><i class="fas fa-ban"></i> Update Failed. Please fill out the data needed.</center>');
    $('#pass-warning').show();
    setTimeout(function(){
      $('#pass-warning').fadeOut();
    }, 3000)
  }
}

//change password later
function changePassLater()
{
  var id = $('#pass-id').val();

  $.ajax({
    type: 'POST',
    url: '../../controls/change_pass_later.php',
    data: {id: id},

    beforeSend: function()
    {
      showToast();
    },
    success: function(response)
    {
      if(response > 0)
        {
          $('#changePassModal').modal('hide');
        }else{
          $('#pass-warning').html('<center><i class="fas fa-ban"></i> ERROR! Please contact the system administrator at local 124 for assistance.</center>');
          $('#pass-warning').show();
          setTimeout(function(){
            $('#pass-warning').fadeOut();
          }, 3000)
        }
    }
  })
}
</script>