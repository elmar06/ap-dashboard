$(document).ready(function(){
  $('.DataTable').dataTable({
    scrollX: true
  })
  $('#btnSubmit').prop('disabled', true);
})
//accept event handler
$('.btnReceive').on('click', function(e){
  e.preventDefault();

   var id = $(this).val();
   $('#po-id').val(id);
   $('#receivedModal').modal('show');
})
//return event handler
$('.btnReturn').on('click', function(e){
  e.preventDefault();

   var id = $(this).val();
   $('#return-id').val(id);
   $('#returnedModal').modal('show');
})
//edit requirements submitted
$('#btnEditReq').on('click', function(e){
  e.preventDefault();

  var id = $('#po-id').val();
  $('#yrEnd-po-id').val(id);
  //show & hide modal
  $('#POmodalDetails').modal('hide');
  $('#receivedModal').modal('show');
})
//check if checkbox is checked
$('.req :checkbox').on('change', function() {
  $('.req :checkbox').prop('checked', false);
  $(this).prop('checked', true);

  var orig = $('#original').is(':checked');
  var dup = $('#duplicate').is(':checked');
  var ctc = $('#ctc').is(':checked');
  if(orig || dup || ctc){
    $('#btnSubmit').prop('disabled', false);
  }else{
    $('#btnSubmit').prop('disabled', true);
  }
})
//received Request
function received_yearend()
{
  var id = $('#po-id').val();
  var req = [];
  $('#req-checkbox input:checked').each(function() {
    req.push($(this).attr('value'));
  })
  var action = 1;
  $.ajax({
    type: 'POST',
    url: '../../controls/process_yearend.php',
    data: {id:id, action:action, req:req},
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
}

//returned request
function return_yearEnd()
{
  var id = $('#return-id').val();
  var remark = $('#reason').val();
  var action = 2;

  if(remark == ''){
    toastr.error('ERROR! Please provide a necessary reason above.');
  }else{
    $.ajax({
      type: 'POST',
      url: '../../controls/process_yearend.php',
      data: {id:id, remark:remark, action:action},
      success: function(response){
        if(response > 0){
          toastr.success('Request successfully mark as returned.');
          setTimeout(function(){
            location.reload();
          }, 1500)
        }else{
          toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
        }
      }
    })
  }
}

//save new requirement submitted
function update_req()
{
  var id = $('#po-id').val();
  var req = [];
  $('#req-checkbox input:checked').each(function() {
    req.push($(this).attr('value'));
  })

  $.ajax({
    type: 'POST',
    url: '../../controls/upd_requirement.php',
    data: {id:id, req:req},
    success: function(response){
      if(response > 0){
        toastr.success('Requirements successfully updated.');
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