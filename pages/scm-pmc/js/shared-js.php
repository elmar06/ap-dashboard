<script>
$(document).ready(function () {
  getNewDataListShared();
})
//get the new list using server side datatable
function getNewDataListShared()
{
  $('#sharedTable').DataTable({
      'scrollX': 'true',
      'serverSide': 'true',
      'processing': 'true',
      'paging': 'true',
      'order': [],
      'ajax': {
          'url': '../../controls/dataTable/submit_shared.php',
          'type': 'post',
      },
      'aoColumnDefs': [{
          'bSortable': 'true',
          'aTargets': [9]
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
$(document).on('dblclick', '#shared-table tr', function(){
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
              $('#viewDetails').modal('show');
              $('#view-body').html(html);
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
  var status = 1;

  var myData = 'id=' + id + '&bill_date=' + bill_date + '&terms=' + terms + '&due_date=' + due_date + '&days_due=' + days_due + '&bill_no=' + bill_no + '&po_num=' + po_num + '&company=' + company + '&supplier=' + supplier + '&project=' + project + '&department=' + department + '&status=' + status + '&amount=' + amount + '&si_num=' + si_num;

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
          $('#upd-success').html('<center><i class="fas fa-check"></i> Request Successfully resubmitted.</center>');
          $('#upd-success').show();
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
}

//Cancel button
function DisableFields()
{
  $('#upd-bill-date').attr('disabled', true);
  $('#upd-bill-no').attr('disabled', true);
  $('#upd-po-no').attr('disabled', true);
  $('#upd-company').attr('disabled', true);
  $('#upd-supplier').attr('disabled', true);
  $('#upd-project').attr('disabled', true);
  $('#upd-department').attr('disabled', true);
  $('#upd-terms').attr('disabled', true);
  $('#upd-amount').attr('disabled', false);
  $('#upd-sales-invoice').attr('disabled', false);
  $('#btnEdit').attr('disabled', false);
  $('#btnClose').show();
  $('#btnCancel').hide();
}
</script>