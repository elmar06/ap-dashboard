<script>
$(document).ready(function () {
  // $('.DataTable').DataTable({
  //   scrollX: true
  // }); // ID From dataTable 
  //execeute the server side datatable
  getNewDataListPending();
  getNewDataListReturn();
  getNewDataListInProcess();
  getNewDataListReleasing();
  getNewDataListReleased()
})
//get the new list using server side datatable
function getNewDataListPending()
{
    $('#pendingTable').DataTable({
        'scrollX': 'true',
        'serverSide': 'true',
        'processing': 'true',
        'paging': 'true',
        'order': [],
        'ajax': {
            'url': '../../controls/dataTable/submit_scm_pending.php',
            'type': 'post',
        },
        'aoColumnDefs': [{
            'bSortable': 'true',
            'aTargets': [8]
        }]
    });
}
//get the returned po/jo list 
function getNewDataListReturn()
{
  $('#returnTable').DataTable({
      'scrollX': 'true',
      'serverSide': 'true',
      'processing': 'true',
      'paging': 'true',
      'order': [],
      'ajax': {
          'url': '../../controls/dataTable/submit_scm_return.php',
          'type': 'post',
      },
      'aoColumnDefs': [{
          'bSortable': 'true',
          'aTargets': [8]
      }]
  });
}
//get the inProcess po/jo
function getNewDataListInProcess()
{
  $('#processTable').DataTable({
      'scrollX': 'true',
      'serverSide': 'true',
      'processing': 'true',
      'paging': 'true',
      'order': [],
      'ajax': {
          'url': '../../controls/dataTable/submit_scm_process.php',
          'type': 'post',
      },
      'aoColumnDefs': [{
          'bSortable': 'true',
          'aTargets': [13]
      }]
  });
}
//get the for Releasing po/jo
function getNewDataListReleasing()
{
  $('#forReleasingTable').DataTable({
      'scrollX': 'true',
      'serverSide': 'true',
      'processing': 'true',
      'paging': 'true',
      'order': [],
      'ajax': {
          'url': '../../controls/dataTable/submit_scm_releasing.php',
          'type': 'post',
      },
      'aoColumnDefs': [{
          'bSortable': 'true',
          'aTargets': [12]
      }]
  });
}
//get the for Released po/jo
function getNewDataListReleased()
{
  $('#releasedTable').DataTable({
      'scrollX': 'true',
      'serverSide': 'true',
      'processing': 'true',
      'paging': 'true',
      'order': [],
      'ajax': {
          'url': '../../controls/dataTable/submit_scm_released.php',
          'type': 'post',
      },
      'aoColumnDefs': [{
          'bSortable': 'true',
          'aTargets': [12]
      }]
  });
}
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
  //check the submitted request for users restriction
  $.ajax({
    type: 'POST',
    url: '../../controls/check_users_request.php',
    data: {id:id},
    success: function(response)
    {
      //CHECK BASED ON STATUS
      if(response == 1)
      {
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
      }
      else
      {
        //VIEWING ONLY
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
  var id = $('#upd-po-id').val();
  var po_num = $('#upd-po-no').val();
  var ir_no = $('#upd-ir-no').val();
  var po_date = $('#upd-po-date').val();
  var amount = $('#upd-po-amount').val();
  var si_num = $('#upd-si-num').val();
  var si_amount = $('#upd-si-amount').val();
  var company = $('#upd-company').val();
  var supplier = $('#upd-supplier').val();
  var project = $('#upd-project').val();
  var department = $('#upd-department').val();
  var bill_date = $('#upd-bill-date').val();
  var terms = $('#upd-terms').val();
  var due_date = $('#upd-due-date').val();
  var counter_date = $('#upd-counter-date').val();
  var scm_remarks = $('#upd-scm-remark').val();
  //credit memo section 
  var memo_no = $('#upd-memo-no').val();
  var debit_memo = $('#upd-debit-memo').val();
  var memo_amount = $('#upd-memo-amount').val();
  var remark = '';
  //check if it is shared
  var check = $('#remarks').is(':checked');
  if(check){
    var remark = 1;
  }else{
    var remark = 0;
  }
 //check the department if null
 if(department == '' || department == null)
  {
    var department = 0;
  }
  //check the department if null
  if(project == '' || project == null)
  {
    var project = 0;
  }
  var myData = 'id=' + id + '&po_num=' + po_num + '&ir_no=' + ir_no + '&po_date=' + po_date + '&po_amount=' + amount + '&si_num=' + si_num + '&si_amount=' + si_amount + '&company=' + company + '&supplier=' + supplier + '&project=' + project + '&department=' + department + '&bill_date=' + bill_date + '&terms=' + terms + '&due_date=' + due_date + '&counter_date=' + counter_date + '&scm_remark=' + scm_remarks + '&memo_no=' + memo_no + '&debit_memo=' + debit_memo + '&memo_amount=' + memo_amount + '&remark=' + remark;

  if(po_num != '' && si_num != '' && amount != '' && company != null && supplier != null && bill_date != '' && due_date != '')
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
            location.reload();
          }, 1500)
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

//remove or delete PO
function remove_po()
{  
  var id = $('#upd-po-id').val();

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
        toastr.warning('PO/JO Successfully mark as void and will be removed from the list');           
        setTimeout(function(){
          location.reload();
        }, 1500)
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

//show returned table
$('#pills-returned-tab').click(function(){
  $('#returnTable').show();
})
</script>