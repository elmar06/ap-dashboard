<script>
$(document).ready(function () {
  $('.DataTable').DataTable({
    scrollX: true
  }); // ID From dataTable 
})
//toast function
function showToast(){
  var title = 'Loading...';
  var duration = 500;
  $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
}
function hideLoading(){
  $.Toast.hideToast();
}

//view details
$(document).on('dblclick', '.DataTable tr', function(){
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

//resubmit
function upd_po_details()
{
  var po_id = $('#po-id').val();
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
  var reports = '';
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
  
  var myData = 'po_id=' + po_id + '&po_num=' + po_num + '&po_amount=' + po_amount + '&po_date=' + po_date + '&si_num=' + si_num + '&amount=' + amount + '&company=' + company + '&supplier=' + supplier + '&project=' + project + '&department=' + department + '&bill_date=' + bill_date + '&terms=' + terms + '&due_date=' + due_date + '&reports=' + reports + '&remark=' + remark + '&memo_no=' + memo_no;

  if(po_num != '' && po_amount != '' && si_num != '' && amount != '' && company != null && supplier != null && bill_date != '' && due_date != '')
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
          $('#upd-success').html('<center><i class="fas fa-check"></i> Request Successfully resubmitted.</center>');
          $('#upd-success').show();
          $('#btnEdit').prop('disabled', false);
          DisableFields();
          setTimeout(function(){
            $('#upd-success').fadeOut();
          }, 3000)
          //get the updated list
          $.ajax({
              url: '../../controls/view_all_submit_po.php',
              success: function(html)
              {
                $('#po-submit-body').fadeOut();
                $('#po-submit-body').fadeIn();
                $('#po-submit-body').html(html);
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

//Edit button
function EnableFields()
{
  $('input[type=text]').prop('disabled', false);
  $('.select2').prop('disabled', false);
  $('.datepicker').prop('disabled', false);
  $('#btnEdit').attr('disabled', true);
  $('#btnClose').hide();
  $('#btnCancel').show();
}

//Cancel button
function DisableFields()
{
  $('input[type=text]').prop('disabled', true);
  $('.select2').prop('disabled', true);
  $('.datepicker').prop('disabled', true);
  $('#btnEdit').attr('disabled', false);
  $('#btnClose').show();
  $('#btnCancel').hide();
}
</script>