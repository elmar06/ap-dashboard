<!-- Page level custom scripts -->
<script>
$(document).ready(function () {
  $('.DataTable').DataTable(); // class From dataTable 
  $(".sidebar").toggleClass("toggled");
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
//view details
$(document).on('dblclick', '.DataTable tr', function(){
  var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();
  
  $.ajax({
    type: 'POST',
    url: '../../controls/view_po_details_fo.php',
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

//submit
$('#btnSubmit').click(function(e){
    e.preventDefault();

    var action = $('#action').val();

    if(action == 1)//mark as returned
    {
      submit_returned();
    }
    else//received & forward to BO for the next process
    {
      submit_for_process();
    }   
})

//mark for processing
function submit_for_process()
{
  var id = $('#upd-id').val();
  var report = $('#report').val();
  var myData = 'id=' + id + '&reports=' + report;
  
  $.ajax({
    type: 'POST',
    url: '../../controls/mark_process.php',
    data: myData,
    beforeSend: function()
    {
      showToast();
    },
    success: function(response)
    {
      if(response > 0)
      {
        //display the new list
        $.ajax({
            type: 'POST',
            url: '../../controls/view_all_po.php',
            success: function(html)
            {
              $('#upd-success').html('<center><i class="fas fa-check"></i> PO/JO successfully forwarded to back office for processing.</center>');
              $('#upd-success').show();
              setTimeout(function(){
                $('#upd-success').fadeOut();
                $('#POmodalDetails').modal('hide');
              }, 2000)
              $('#page-body').fadeOut();
              $('#page-body').fadeIn();
              $('#page-body').html(html);
            }
          })
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
}
//mark request as returned
function submit_returned()
{
  var id = $('#upd-id').val();
  var remarks = $('#remarks').val();
  var myData = 'id=' + id + '&remarks=' + remarks;
  if(remarks != '')
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/mark_returned.php',
      data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(response)
      {
        if(response > 0)
        {
          $('#upd-success').html('<center><i class="fas fa-check"></i> PO/JO successfully mark as returned.</center>');
          $('#upd-success').show();
          setTimeout(function(){
            $('#upd-success').fadeOut();
          }, 3000)
          //display the new list
          $.ajax({
            type: 'POST',
            url: '../../controls/view_all_po.php',
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
          $('#upd-warning').html('<center><i class="fas fa-ban"></i> Submit Failed! Please contact the system administrator at local 124 for assistance.</center>');
          $('#upd-warning').show();
          setTimeout(function(){
            $('#upd-warning').fadeOut();
          }, 3000)
        }
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    })
  }else{
    $('#upd-warning').html('<center><i class="fas fa-ban"></i> Submit Failed! Please fill out the reason of return.</center>');
    $('#upd-warning').show();
    setTimeout(function(){
      $('#upd-warning').fadeOut();
    }, 3000)
  }
}

//returned all checked
function returned_all()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() { //itemid
    id.push($(this).val())
  })
  var remarks = null;

  $.each(id, function(key, value){
    $.ajax({
      type: 'POST',
      url: '../../controls/mark_returned.php',
      data: {id:value, remarks:remarks},
      success: function(response)
      {
        if(response > 0)
        {
          //display the new list
          $.ajax({
            type: 'POST',
            url: '../../controls/view_all_po.php',
            success: function(html)
            {
              toastr.success('Request successfully mark as Returned.');
              $('#page-body').html(html);
            }
          })
        }
        else
        {
          alert('Error! Please contact the System Administrator at local 124 for assistance.');
        }
      }
    })
  })
}
//received all checked
function received_all()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() { //itemid
    id.push($(this).val())
  })
  var reports = null;

  $.each(id, function(key, value){
    $.ajax({
      type: 'POST',
      url: '../../controls/mark_process.php',
      data: {id: value, reports: reports},
      success: function(response)
      {
        if(response > 0)
        {
          toastr.success('Request successfully mark as Received.');
          //display the new list
          $.ajax({
            type: 'POST',
            url: '../../controls/view_all_po.php',
            success: function(html)
            {
              $('#page-body').html(html);
            }
          })
        }
        else
        {
          toastr.error('Receiving failed. Please contact the system administrator at local 124.');
        }
      }
    })
  })
}

//show remarks
function mark_returned()
{
    $('.remarks').fadeIn();
    $('#remarks').focus();
    $('#btnSubmit').fadeIn();
    $('#cancel').fadeIn();
    $('#received').hide();
    $('#returned').hide();
    $('#action').val(1);
}

function mark_received()
{
    $('.requirements').fadeIn();
    $('#btnSubmit').fadeIn();
    $('#cancel').fadeIn();
    $('#customSwitch1').focus();
    $('#received').hide();
    $('#returned').hide();
    $('#action').val(2);
    $('#btnReport').fadeIn();

}

function cancel_return()
{
    $('.remarks').hide();
    $('.requirements').hide();
    $('#btnSubmit').hide();
    $('#cancel').hide();
    $('#received').fadeIn();
    $('#returned').fadeIn();
    $('#btnReport').hide();
}

//get all the pending
function get_pending_po()
{  
  $('#tblMain').fadeOut();
  $('#tblSearch1').fadeIn();
  $('#tblSearch2').hide();
  $('#tblSearch3').hide();
  $('#tblSearch4').hide();
}

//get all the returned po
function get_returned_po()
{
  $('#tblMain').fadeOut();
  $('#tblSearch1').hide();
  $('#tblSearch2').fadeIn();
  $('#tblSearch3').hide();
  $('#tblSearch4').hide();
}

//get in process po
function get_process_po()
{
  $('#tblMain').fadeOut();
  $('#tblSearch1').hide();
  $('#tblSearch2').hide();
  $('#tblSearch3').fadeIn();
  $('#tblSearch4').hide();
}

//get po for releasing
function get_releasing_po()
{
  $('#tblMain').fadeOut();
  $('#tblSearch1').hide();
  $('#tblSearch2').hide();
  $('#tblSearch3').hide();
  $('#tblSearch4').fadeIn();
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
        $('#btnAllReceived').fadeIn();
        $('#btnAllReturned').fadeIn();
        $('#btnAllReleased').attr('disabled', false);
      }
      else
      {
        $('#btnAllReceived').fadeOut();
        $('#btnAllReturned').fadeOut();
        $('#btnAllReleased').attr('disabled', true);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#btnAllReceived').fadeOut();
      $('#btnAllReturned').fadeOut();
      $('#btnAllReleased').attr('disabled', true);
    })
  }
});
</script>

<!-- checklist -->
<script>
$('.checklist').change(function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
    $('#btnAllReceived').fadeIn();
    $('#btnAllReturned').fadeIn();
    $('#btnAllReleased').attr('disabled', false);
  }
  else
  {
    $('#btnAllReceived').fadeOut();
    $('#btnAllReturned').fadeOut();
    $('#btnAllReleased').attr('disabled', true);
  }
})

//show the incident report input
function addReport()
{
  var checked = $('input[name="report[]"]:checked').length > 0;
  if(checked)
  {
    $('.report').fadeIn();
  }else{
    $('.report').hide();
  }
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