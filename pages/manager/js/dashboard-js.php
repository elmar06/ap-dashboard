<!-- search box in drop down menu -->
<script>
$(document).ready(function () {
  $('#submitted-table').DataTable(); // ID From dataTable 
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

//view details
$(document).on('dblclick', '#submitted-table tr', function(){
    var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();

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
})

//get list of pending po
function get_pending_po()
{
  $.ajax({
    url: '../../controls/get_pending_po.php',
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#po-body').fadeOut();
      $('#po-body').fadeIn();
      $('#po-body').html(html);
    }
  })
}

//get list of returned po
function get_returned_po()
{
  $.ajax({
    url: '../../controls/get_returned_po.php',
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#po-body').fadeOut();
      $('#po-body').fadeIn();
      $('#po-body').html(html);
    }
  })
}

//get list of on process po
function get_process_po()
{
  $.ajax({
    url: '../../controls/get_process_po.php',
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#po-body').fadeOut();
      $('#po-body').fadeIn();
      $('#po-body').html(html);
    }
  })
}

//get list of for releasing po
function get_releasing_po()
{
  $.ajax({
    url: '../../controls/get_releasing_po.php',
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#po-body').fadeOut();
      $('#po-body').fadeIn();
      $('#po-body').html(html);
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