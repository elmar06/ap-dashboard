<!-- Page level custom scripts -->
<script>
$(document).ready(function () {
  $('#req-table').DataTable(); // ID From dataTable with Hover
});

//view details
$(document).on('dblclick', '#req-table tr', function(){
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
      }
      else
      {
        //show the view only modal
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
            $('#viewDetails').modal('show');
            $('#view-body').html(html);
          }
        })
      }
    }
  })
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