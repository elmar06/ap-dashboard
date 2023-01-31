<!-- search box in drop down menu -->
<script>
$(document).ready(function () {
  $('.DataTable').DataTable({
    scrollX: true
  });
  $('#tblSearch1').hide();
  $('#tblSearch2').hide();
  $('#tblSearch3').hide();
  $('#tblSearch4').hide();
})

//select2 js
$(".select2").select2();

//toast
function showToast(){
  var title = 'Loading...';
  var duration = 500;
  $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
}
function hideLoading(){
  $.Toast.hideToast();
}

//datepicker
$('.datepicker').datepicker({
  clearBtn: true,
  format: "MM dd, yyyy",
  setDate: new Date(),
  autoClose: true
});

//details 
$('.details').click(function(e){
  e.preventDefault();

  var id = $(this).attr('value');

  $.ajax({
    type: 'POST',
    url: '../../controls/view_po_details_byID.php',
    data: {id: id},
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

//delete button
$('.remove').on('click', function(e){
  e.preventDefault();
  var id = $(this).attr('value');
  $('#notificationModal').modal('show');
  $('#po-id').val(id);
})

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

//get the terms per supplier
$('#supplier').on('change', function(){
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
        $('#terms').val('0');
      }else{
        $('#terms').val(term);
      }
    }
  })
})
//upload file
function uploadFile()
{
  //initialize the form data for further validation
  var file_data = $('#filecover').prop('files')[0];
  var form_data = new FormData();
  form_data.append('files', file_data);

  if(file_data)
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/upload.php',
      data: form_data,
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function()
      {
        $('#loading').show();
      },
      success: function(response)
      {
        if(response > 0)
        {
          $('#loading').hide();
          $('#upload-success').html("Request Details successfully uploaded in database.");
          $('#upload-success').show();
          setTimeout(function(){
            $('#upload-success').hide();
            window.location = 'dashboard.php';
          }, 2000);
        }
        else
        {
          $('#upload-warning').html("Upload Failed. Please contact the system administrator at local 124 for assistance.");
          $('#upload-warning').show();
          setTimeout(function(){
            $('#upload-warning').hide();
          }, 5000);
        }
      }
    })
  }
  else
  {
    $('#upload-warning').html("Please select a CSV file to upload.");
    $('#upload-warning').show();
    setTimeout(function(){
      $('#upload-warning').hide();
    }, 3000);
  }
}
//submit po
function SubmitPO()
{
  var po_num = $('#po-no').val();
  var po_amount = $('#po-amount').val();
  var po_date = $('#po-date').val();
  var si_num = $('#si-num').val();
  var amount = $('#si-amount').val();
  var company = $('#company').val();
  var supplier = $('#supplier').val();
  var project = $('#project').val();
  var department = $('#department').val();
  var bill_date = $('#bill-date').val();
  var terms = $('#terms').val();
  var due_date = $('#due-date').val();
  var memo_no = $('#memo-no').val();
  var reports = $('#report').val();
  var remark = '';
  //check if it is shared
  var check = $('#remarks').is(':checked');
  if(check){
    var remark = 1;
  }else{
    var remark = 0;
  }
  //check the department if null
  if(department == 0 || department == null)
  {
    var department = 0;
  }
  //check the department if null
  if(project == 0 || project == null)
  {
    var project = 0;
  }

  var myData = 'po_num=' + po_num + '&po_amount=' + po_amount + '&po_date=' + po_date + '&si_num=' + si_num + '&amount=' + amount + '&company=' + company + '&supplier=' + supplier + '&project=' + project + '&department=' + department + '&bill_date=' + bill_date + '&terms=' + terms + '&due_date=' + due_date + '&reports=' + reports + '&remark=' + remark + '&memo_no=' + memo_no;

  if(po_num != '' && po_amount != '' && si_num != '' && amount != '' && company != null && supplier != null && bill_date != '' && due_date != '')
  {
    //save the details
    $.ajax({
      type: 'POST',
      url: '../../controls/add_po.php',
      data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(response)
      {
        if(response > 0)
        {
          //get the updated list
          $.ajax({
            url: '../../controls/view_submit_po.php',
            success: function(html)
            {
              $('#page-body').fadeOut();
              $('#page-body').fadeIn();
              $('#page-body').html(html);
              $('#PO-Modal').modal('hide');
            }
          })
        }
        else
        {
          $('#add-warning').html('<center><i class="fas fa-ban"></i> Submitting of Request Failed. Please contact the Administrator at local 124.</center>');
          $('#add-warning').show();
          setTimeout(function(){
            $('#add-warning').fadeOut();
          }, 5000)
        }
      }
    })
    //check if PO/JO number is already exist
    // $.ajax({
    //   type: 'POST',
    //   url: '../../controls/check_po_num.php',
    //   data: {po_num: po_num},
    //   success: function(response)
    //   {
    //     if(response > 0)
    //     {
    //       //display error if number is already exist
    //       $('#add-warning').html('<center><i class="fas fa-ban"></i> Submitting of Request Failed. PO/JO number already exist in database.</center>');
    //       $('#add-warning').show();
    //       setTimeout(function(){
    //         $('#add-warning').fadeOut();
    //       }, 5000)
    //     }
    //     else
    //     {
          
    //     }
    //   }
    // })
  }
  else
  {
    $('#add-warning').html('<center><i class="fas fa-ban"></i> Submit Failed. Please input all the data needed.</center>');
    $('#add-warning').show();
    setTimeout(function(){
      $('#add-warning').hide();
    }, 3000)
  }
}

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

//remove or delete PO
function remove_po()
{  
  var id = $('#po-id').val();
  
  $.ajax({
    type: 'POST',
    url: '../../controls/delete_po.php',
    data: {id: id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(response)
    {
      if(response > 0)
      {
        //get the updated list
        $.ajax({
          url: '../../controls/view_submit_po.php',
          success: function(html)
          {
            $('#page-body').fadeOut();
            $('#page-body').fadeIn();
            $('#page-body').html(html);
            $('#notificationModal').modal('hide');
          }
        })
      }
      else
      {
        //show Error message in modal
        $('#notf-msg').html('<i class="fas fa-ban"></i> Remove Failed. Please contact the System Administrator at local 124.');
      }
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
}

//set date format for due date
function formatDate(date)
{
  var monthName = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  var d = new Date(date),
      month = d.getMonth(),
      day = d.getDate(),
      year = d.getFullYear();

  if(month.length < 2)
    month = '0' + month;
  if(day.length < 2)
    day = '0' + day;
  //return [year, month, day].join('-');
  return monthName[month] + ' ' + day + ', ' + year;
}

//format date for calculation
function formatDateCal(date)
{
  var d = new Date(date),
      month = d.getMonth() + 1,
      day = d.getDate(),
      year = d.getFullYear();

  if(month.length < 2)
    month = '0' + month;
  if(day.length < 2)
    day = '0' + day;
  return [year + '/' + month + '/' + day];
}

//add days base on term
Date.prototype.addDays = function(days)
{
  this.setDate(this.getDate() + parseInt(days));
  return this;
}

//get the due date base on terms(Add Request)
function getDueDate()
{
  var bill_date = formatDateCal($('#bill-date').val());
  var days = $('#terms').val();
  var date = new Date(bill_date);

  if(days == null || days == '')
  {
    var days = '0';
    var due = date.addDays(days)
    var due_date = formatDate(due);
    $('#due-date').val('');
  }else{
    var due = date.addDays(days)
    var due_date = formatDate(due);
    $('#due-date').val(due_date);
  }
}

//get the due date base on terms(Edit Request)
function getDueDateEdit()
{
  var bill_date = formatDateCal($('#upd-bill-date').val());
  var days = $('#upd-terms').val();
  var date = new Date(bill_date);

  if(days == null || days == '')
  {
    var days = '0';
    var due = date.addDays(days)
    var due_date = formatDate(due);
    $('#upd-due-date').val('');
  }else{
    var due = date.addDays(days)
    var due_date = formatDate(due);
    $('#upd-due-date').val(due_date);
  }
}

//get all the pending
function get_pending_po()
{  
  $('#po-details-body').hide();
  $('#tblSearch1').fadeIn();
  $('#tblSearch2').hide();
  $('#tblSearch3').hide();
  $('#tblSearch4').hide();
}

//get all the returned po
function get_returned_po()
{
  $('#po-details-body').hide();
  $('#tblMain').fadeOut();
  $('#tblSearch1').hide();
  $('#tblSearch2').fadeIn();
  $('#tblSearch3').hide();
  $('#tblSearch4').hide();
}

//get in process po
function get_process_po()
{
  $('#po-details-body').hide();
  $('#tblMain').fadeOut();
  $('#tblSearch1').hide();
  $('#tblSearch2').hide();
  $('#tblSearch3').fadeIn();
  $('#tblSearch4').hide();
}

//get po for releasing
function get_releasing_po()
{
  $('#po-details-body').hide();
  $('#tblMain').fadeOut();
  $('#tblSearch1').hide();
  $('#tblSearch2').hide();
  $('#tblSearch3').hide();
  $('#tblSearch4').fadeIn();
}

//set request for Credit Memo
function mark_as_credit_memo()
{
  $('.report').toggle();
}

//view details
$(document).on('dblclick', '#submitted-table tr', function(){
  var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();

  //check the status of a po
  $.ajax({
    type: 'POST',
    url: '../../controls/check_po_stat.php',
    data: {id:id},
    success: function(response)
    {
      if(response == 1 || response == 2)
      {
        //show the edit modal
        $.ajax({
          type: 'POST',
          url: '../../controls/view_po_details_byID.php',
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
      }
      else
      {
        //show the view only modal
        $.ajax({
          type: 'POST',
          url: '../../controls/view_po_details_byID.php',
          data: {id:id},
          beforeSend: function()
          {
            showToast();
          },
          success: function(html)
          {
            $('#viewDetails').modal('show');
            $('#view-body').html(html);
          }
        })
      }
    }
  })
})

//clear results list
function clear_list()
{
  $('#req-list').hide();
  $('#po-details-body').fadeIn();
  $('#btnClear').hide();
}

//format currency value of Amount
$('.amount').on('blur', function() {
  const value = this.value.replace(/,/g, '');
  this.value = parseFloat(value).toLocaleString('en-US', {
    style: 'decimal',
    maximumFractionDigits: 2,
    minimumFractionDigits: 2
  });
});

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