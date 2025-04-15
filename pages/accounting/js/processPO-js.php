<script>
$(document).ready(function () {
  $('#submitted-table').DataTable({
    scrollX: true
  }); // ID From dataTable 
  $(".sidebar").toggleClass("toggled");
  $('#date-to-manila').prop('disabled', false);
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
      else if(response >= 5 || response == 10)
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
            $('#viewProcessReq').modal('show');
            $('#process-body').html(html);
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

function mark_stale()
{
  var id = $('#upd-po-id').val();
  $.ajax({
    type: 'POST',
    url: '../../controls/mark_stale_check.php',
    data: {id:id},
    success: function(response){
      if(response > 0){
        toastr.success('Request successfully mark as Stale Check.')
        setTimeout(function(){
          location.reload();
        }, 1500)
      }else{
        toastr.error('Failed! Please contact the system administrator at local 124.')
      }
    }
  })
}

function mark_cancel()
{
  var id = $('#upd-po-id').val();
  var po_num = $('#upd-po-no').val();
  var supplier = $('#upd-supplier').val();
  var myData = 'id=' + id + '&po_num=' + po_num + '&supplier=' + supplier;
  alert(myData);
  $.ajax({
    type: 'POST',
    url: '../../controls/mark_cancel_check.php',
    data: myData,
    success: function(response){
      alert(response);
      if(response > 0){
        toastr.success('Request successfully mark as cancelled.')
        setTimeout(function(){
          location.reload();
        }, 1500)
      }else{
        toastr.error('Failed! Please contact the system administrator at local 124.')
      }
    }
  })
}
//show modal for Manila
function showManilaModal(){
  $('#viewProcessReq').modal('hide');
  $('#forwardManila').modal('show');
}
//forwarded to manila
function forward_manila(){
  var id = $('#upd-po-id').val();
  var date_manila = $('#date-to-manila').val();
  $.ajax({
    type: 'POST',
    url: '../../controls/mark_forward_manila.php',
    data: {id:id, date_manila:date_manila},
    success: function(response){
      if(response > 0){
        toastr.success('Request successfully mark as forwarded to Manila.')
        setTimeout(function(){
          location.reload();
        }, 1500)
      }else{
        toastr.error('Failed! Please contact the system administrator at local 124.')
      }
    }
  })
}

function markPrio()
{
  var id = $('#upd-po-id').val();

  $.ajax({
    type: 'POST',
    url: '../../controls/mark_prio.php',
    data: {id:id},
    success: function(response)
    {
      if(response > 0){
        toastr.success('Request successfully mark as priority.');
        setTimeout(function(){
          location.reload();
        }, 1500)
      }else{
        toastr.error('Failed! Please contact the system administrator at local 124.')
      }
    }
  })
}
</script>