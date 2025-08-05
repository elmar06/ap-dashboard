<!-- Page level custom scripts -->
<script>
$(document).ready(function () {
  $(".sidebar").toggleClass("toggled");
  $('.tableData').DataTable({
    scrollX: true
  });
  $('#createTable').DataTable({
    scrollX: true
  });
  //select2 js
  $(".select2").select2();
  //select2 multiple
  $('.basic-multiple').select2();
  //datepicker
  $('.datepicker').datepicker({
    clearBtn: true,
    format: "MM dd, yyyy",
    //startDate: new Date(),
    minDate: 0,
    autoClose: true,
  });
})
//toast
function showToast(){
  var title = 'Loading...';
  var duration = 500;
  $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
}
function hideLoading(){
  $.Toast.hideToast();
}

//process request(create cv)
$('.edit').click(function(e){
  e.preventDefault();

  var id = $(this).attr('value');

  $.ajax({
    type: 'POST',
    url: '../../controls/view_process_byID.php',
    data: {id:id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#POmodalDetails').modal('show');
      $('#details-body').html(html);
      $('#cv-number').focus();
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})

//process request(create cv)
$('.upd-cv').click(function(e){
  e.preventDefault();

  var id = $(this).attr('value');

  $.ajax({
    type: 'POST',
    url: '../../controls/view_process_byID.php',
    data: {id:id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#editPOmodalDetails').modal('show');
      $('#update-body').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})
//MARK AS RETURN TO FRONT OFFICE EVENT HANDLER
$('.return').on('click', function(e){
  e.preventDefault();

  var id = $(this).attr('value');
  
  $.ajax({
    type: 'POST',
    url: '../../controls/mark_return_toFO.php',
    data: {id: id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(response)
    {
      if(response)
      {
        toastr.success('Request successfully mark as Returned to Front Office.')
        //display the new list
        $.ajax({
            type: 'POST',
            url: '../../controls/view_all_process_po.php',
            success: function(html)
            {
              $('#page-body').fadeOut();
              $('#page-body').fadeIn();
              $('#page-body').html(html);
            }
          })
      }
      else
      {
        toastr.warning('Returned Failed. Please contact the System Administrator at local 124.')
      }
    }
  })
})
//view details
$(document).on('dblclick', '#mainTable tr', function(){
  var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();
  
  $.ajax({
    type: 'POST',
    url: '../../controls/view_process_byID.php',
    data: {id:id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#POmodalDetails').modal('show');
      $('#details-body').html(html);
      $('#cv-number').focus();
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})
//mark as process by BackOffice
function submitForSignature()
{
  var id = $('#upd-id').val();
  var cv_no = $('#cv-no').val();
  var bank = $('#bank').val();
  var check_no = $('#check-no').val();
  var checkdate = $('#checkdate').val();
  var amount = $('#upd-amount').val();
  var tax = $('#cv-tax').val();
  var cv_amount = $('#cv-amount').val();
  var action = 1;
  //check if cheque is mark as priority
  var prio = $('#prio-check').is(':checked');
  if(prio){
    var prio = 1;
  }else{
    var prio = 0;
  }
  //check if it is mark as "STAGGARED PAYMENT"
  var check = $('#staggared').is(':checked');
  if(check){
    var staggared = 1;
  }else{
    var staggared = 0;
  }
  var myData = 'id=' + id + '&cv_no=' + cv_no + '&bank=' + bank + '&check_no=' + check_no + '&checkdate=' + checkdate + '&amount=' + amount + '&tax=' + tax + '&cv_amount=' + cv_amount + '&action=' + action + '&staggared=' + staggared + '&prio_stat=' + prio;

  if(cv_no != '' && bank != null && check_no != '' && checkdate != '' && tax != '' && cv_amount != '')
  {
    $.ajax({
    type: 'POST',
    url: '../../controls/mark_for_signature.php',
    data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(response)
      {
        if(response > 0)
        {
          //check if this payment is mark as staggared
          if(staggared == 1){
            toastr.success('Request successfully submitted and mark as for staggared payment.');
            //clear the following input fields
            $('#cv-no').val('');
            $('#bank').val(0).trigger('change');
            $('#check-no').val('');
            $('#checkdate').val('');
            $('#cv-tax').val('');
            $('#cv-amount').val('');
          }else{
            toastr.success('Request successfully submitted and mark as for signature.');
            setTimeout(function(){
              location.reload();
            }, 1000)
          }
        }
        else
        {
          toastr.error('Submit Failed! Please contact the system administrator at local 124 for assistance.');
        }
      }
    })
  }else{
    toastr.error('Submit Failed! Please fill out all the check details needed.');
  }
}
//mark request FORWARDED TO CEBU
function forwardToCebu()
{
  var id = $('#upd-id').val();
  var cv_no = $('#cv-no').val();
  var bank = $('#bank').val();
  var check_no = $('#check-no').val();
  var checkdate = $('#checkdate').val();
  var amount = $('#upd-amount').val();
  var tax = $('#cv-tax').val();
  var cv_amount = $('#cv-amount').val();
  var action = 2;
  //check if cheque is mark as priority
  var prio = $('#prio-check').is(':checked');
  if(prio){
    var prio = 1;
  }else{
    var prio = 0;
  }
  var myData = 'id=' + id + '&cv_no=' + cv_no + '&bank=' + bank + '&check_no=' + check_no + '&checkdate=' + checkdate + '&amount=' + amount + '&tax=' + tax + '&cv_amount=' + cv_amount + '&prio_stat=' + prio + '&action=' + action;

  if(cv_no != '' && bank != null && checkdate != '' && tax != '' && cv_amount != '')
  {
    $.ajax({
    type: 'POST',
    url: '../../controls/mark_for_signature.php',
    data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(response)
      {
        if(response > 0)
        {
          toastr.success('Request successfully forwarded to Cebu for Printing.');
        }
        else
        {
          toastr.error('Submit Failed. Please contact the system Administrator for assistance at local 124.');
        }
      }
    })
  }else{
    toastr.error('Submit Failed. Please fill-out all the data needed to proceed.');
  }
}
//forward Multiple CV
function forwardToCebuMulti()
{
  var id = $('#multiReq').val();
  var cv_no = $('#multi-cv-no').val();
  var bank = $('#multi-bank').val();
  var check_no = $('#multi-check-no').val();
  var checkdate = $('#multi-checkdate').val();
  var amount = $('#multi-Amount').val();
  var tax = $('#multi-Tax').val();
  var cv_amount = $('#multi-cvAmount').val();
  var action = 2;
  var myData = 'id=' + id + '&cv_no=' + cv_no + '&bank=' + bank + '&check_no=' + check_no + '&checkdate=' + checkdate + '&amount=' + amount + '&tax=' + tax + '&cv_amount=' + cv_amount + '&action=' + action;

  if(amount != '')
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/mark_for_signature.php',
      data: myData,
      async: false,
      dataType: 'html',
      success: function(response)
      {
        result = response;
      },
      error: function(xhr, ajaxOption, thrownError)
      {
        alert(thrownError);
      }
    })
    //check if process is successful
    if(result > 0)
    {
      toastr.success('Request successfully forwarded to Cebu for printing.');
      setTimeout(function(){
        location.reload();
      }, 1500)
    }else{
      toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
    }
  }else{
    toastr.error('Submit Failed. Please fill-out all the data needed to proceed.');
  }
}
//MARK AS RECIEVED BY BO FROM MANILA
function receivedFromManila()
{
  var id = $('#upd-id').val();
  var action = 4;
  //check if cheque is mark as priority
  var prio = $('#prio-check').is(':checked');
  if(prio){
    var prio = 1;
  }else{
    var prio = 0;
  }
  //check if it is mark as "STAGGARED PAYMENT"
  var check = $('#staggared').is(':checked');
  if(check){
    var staggared = 1;
  }else{
    var staggared = 0;
  }
  $.ajax({
    type: 'POST',
    url: '../../controls/mark_for_signature.php',
    data: {id: id, action: action, prio_stat: prio, staggared: staggared},
    beforeSend: function()
    {
      showToast();
    },
    success: function(response)
    {
      toastr.success('Request successfully mark as received. You can now create a cv for this request.');
      setTimeout(function(){
        location.reload();
      }, 1500)
    }
  })
}
//UPDATE & mark as process by BackOffice
function updForSignature()
{
  var id = $('#upd-id').val();
  var check_po_id = $('#upd-check-po-id').val();
  var check_id = $('#upd-check-id').val();
  var cv_no = $('#cv-no').val();
  var bank = $('#bank').val();
  var check_no = $('#check-no').val();
  var checkdate = $('#checkdate').val();
  var amount = $('#upd-amount').val();
  var tax = $('#cv-tax').val();
  var cv_amount = $('#cv-amount').val();
  var action = 3;
  //check if cheque is mark as priority
  var prio = $('#prio-check').is(':checked');
  if(prio){
    var prio = 1;
  }else{
    var prio = 0;
  }
  //check if it is mark as "STAGGARED PAYMENT"
  var check = $('#staggared').is(':checked');
  if(check){
    var staggared = 1;
  }else{
    var staggared = 0;
  }

  var myData = 'id=' + id + '&check_id=' + check_id + '&check_po_id=' + check_po_id + '&cv_no=' + cv_no + '&bank=' + bank + '&check_no=' + check_no + '&checkdate=' + checkdate + '&amount=' + amount + '&tax=' + tax + '&cv_amount=' + cv_amount + '&action=' + action + '&staggared=' + staggared + '&prio_stat=' + prio;

  if(cv_no != '' && bank != null && check_no != '' && checkdate != '' && tax != '' && cv_amount != '')
  {
    $.ajax({
    type: 'POST',
    url: '../../controls/mark_for_signature.php',
    data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(response)
      {
        if(response > 0)
        {
          //check if this payment is mark as staggared
          if(staggared == 1){
            toastr.success('Request successfully submitted and mark as for staggared payment.');
            //clear the following input fields
            $('#cv-no').val('');
            $('#bank').val(0).trigger('change');
            $('#check-no').val('');
            $('#checkdate').val('');
            $('#cv-tax').val('');
            $('#cv-amount').val('');
          }else{
            toastr.success('Request successfully submitted and mark as for signature.');
            setTimeout(function(){
              location.reload();
            }, 1500)
          }
        }
        else
        {
          $('#upd-warning').html('<center><i class="fas fa-ban"></i> Submit Failed! Please contact the system administrator at local 124 for assistance.</center>');
          $('#upd-warning').show();
          setTimeout(function(){
            $('#upd-warning').fadeOut();
          }, 3000)
        }
      }
    })
  }else{
    $('#upd-warning').html('<center><i class="fas fa-ban"></i> Submit Failed! Please fill out all the check details needed.</center>');
    $('#upd-warning').show();
    setTimeout(function(){
      $('#upd-warning').fadeOut();
    }, 3000)
  }
}
//mark as received by Back Office
function mark_received_bo(id)
{
  $.ajax({
    type: 'POST',
    url: '../../controls/mark_received_bo.php',
    data: {id: id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(response)
    {
      if(response > 0)
      {
        toastr.success('Request successfully mark as received.');
        setTimeout(function(){
            location.reload();
          }, 1300)
      }else{
        toastr.error('Receiving Failed. Please contact the system administrator at local 124 for assistance.');
      }
    }
  })
}

//mark all as received by Back Office
function mark_all_received()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() {
    id.push($(this).val())
  });

  if(id.length > 0){
    $.each(id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_received_bo.php',
        data: {id: value},
        success: function(response)
        {
          if(response > 0)
          {
            toastr.success('Request successfully mark as received.');
            //display the new list
            $.ajax({
              type: 'POST',
              url: '../../controls/view_all_process_po.php',
              success: function(html)
              {
                $('#page-body').html(html);
              }
            })
          }else{
            toastr.error('Receiving Failed. Please contact the system administrator at local 124 for assistance.');
          }
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  }
}
//get the amount per selection in creating multiple cv
function get_amount()
{
  var id = $('#multiReq').val();
  var myData = 'id=' + id;

  $.ajax({
    type: 'POST',
    url: '../../controls/get_amount.php',
    data: myData,
    success: function(html)
    {
      $('#multi-Amount').val(html);
    }
  })
}

//submit multiple cv
function submit_cv()
{
  var id = $('#multiReq').val();
  var cv_no = $('#multi-cv-no').val();
  var bank = $('#multi-bank').val();
  var check_no = $('#multi-check-no').val();
  var checkdate = $('#multi-checkdate').val();
  var amount = $('#multi-Amount').val();
  var cv_amount = $('#multi-cvAmount').val();
  var tax = $('#multi-Tax').val();
  var myData = 'id=' + id + '&cv_no=' + cv_no + '&bank=' + bank + '&check_no=' + check_no + '&checkdate=' + checkdate + '&amount=' + amount + '&tax=' + tax + '&cv_amount=' + cv_amount;

  //validation check
  if(id != '' && cv_no != null && bank != null && check_no != null && checkdate != '' && amount != null && tax != null && cv_amount != null)
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/add_multi_cv.php',
      data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(response)
      {
        if(response > 0)
        {
          $('#success').html('<center><i class="fas fa-check"></i> PO/JO are ready Signature.</center>');
          $('#success').show();
          setTimeout(function(){
            $('#success').fadeOut();
          }, 3000)
          //get the new/latest list
          $.ajax({
            url: '../../controls/view_all_process_po.php',
            success: function(html)
            {
              $('#page-body').fadeOut();
              $('#page-body').fadeIn();
              $('#page-body').html(html);
            }
          })
        }
        else
        {
          $('#warning').html('<center><i class="fas fa-ban"></i> Submit Failed! Please contact the system administrator at local 124 for assistance.</center>');
          $('#warning').show();
          setTimeout(function(){
            $('#warning').fadeOut();
          }, 3000)
        }
      }
    })
  }
  else
  {
    $('#warning').html('<center><i class="fas fa-ban"></i> Submit Failed! Please complete all the data needed to proceed.</center>');
    $('#warning').show();
    setTimeout(function(){
      $('#warning').fadeOut();
    }, 3000)
  }
}

//get all request for processing(More Details button)
function get_for_processing()
{
  $.ajax({
    url: '../../controls/get_for_processing_bo.php',
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}

//get all the po on Hold
function get_for_verification()
{
  $.ajax({
    url: '../../controls/get_for_verification.php',
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}
//get all the PO/JO forwarded from MANILA
function get_from_manila()
{
  $.ajax({
    url: '../../controls/get_from_manila.php',
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}

//get all request for Releasing(More Details button)
function get_for_receiving()
{
  $.ajax({
    url: '../../controls/get_for_receiving_bo.php',
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}
</script>

<!-- CHECKBOXALL-->
<script>
$('.checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value});
      if(selected.length > 1)
      { 
        $('#btnAllReceive').attr('disabled', false);
        //$('#btnCreate').attr('disabled', false);
      }
      else
      {
        $('#btnAllReceive').attr('disabled', true);
        //$('#btnCreate').attr('disabled', true);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#btnAllReceive').attr('disabled', true);
      //$('#btnCreate').attr('disabled', true);
    })
  }
});

//check list
$('.checklist').change(function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
    $('#btnAllReceive').attr('disabled', false);
    //$('#btnCreate').attr('disabled', false);
  }
  else
  {
    $('#btnAllReceive').attr('disabled', true);
    //$('#btnCreate').attr('disabled', true);
  }
})

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

//retrict user input in numbers & special char only
function isNumber(evt)
{
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if ((charCode < 48 || charCode > 57) && charCode != 45) {
    return false;
  }
  return true;
}

//restrict user in number only
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
    && (charCode < 48 || charCode > 57))
      return false;

  return true;
}
</script>