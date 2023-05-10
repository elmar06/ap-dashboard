<script>
$(document).ready(function(){
  $('.DataTable').dataTable({
      scrollX: true
  })
  $('#tblReturn').hide();
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
//mark as received by Compliance
$('.received').on('click', function(e){
    e.preventDefault();

    //show confirmation modal first
    $('#notificationModal').modal('show');
    //get the ID
    var id = $(this).val();
    $('#po-id').val(id);
})
function received_request()
{
  var id = $('#po-id').val();

  $.ajax({
    type: 'POST',
    url: '../../controls/mark_received_compliance.php',
    data: {id: id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(response)
    {
      if(response > 0){
          //get the new list
          toastr.success('Request successfully mark as Received.');
          $.ajax({
              url: '../../controls/get_list_compliance.php',
              success: function(html)
              {
                $('#page-body').fadeOut();
                $('#page-body').fadeIn();
                $('#page-body').html(html);
              }
          })
      }else{
          toastr.error('Receiving Failed! Please contact the system administrator at local 124 for assistance');
      }
    }
  })
}
  
//mark RETURNED 
$('.return').on('click', function(e){
    e.preventDefault();
    $('#returnedModal').modal('show');
    //get the ID
    var id = $(this).val();
    $('#return-id').val(id);
})

function return_request()
{
  var id = $('#return-id').val();
  var remark = $('#reason').val();
    
  $.ajax({
      type: 'POST',
      url: '../../controls/mark_return_compliance.php',
      data: {id: id, remark: remark},
      beforeSend: function()
      {
          showToast();
      },
      success: function(response)
      {
        if(response > 0){
          //get the new list
          toastr.success('Request successfully mark as Received.');
          $.ajax({
            url: '../../controls/get_list_compliance.php',
            success: function(html)
            {
              $('#page-body').fadeOut();
              $('#page-body').fadeIn();
              $('#page-body').html(html);
            }
          })
        }else{
          toastr.error('Receiving Failed! Please contact the system administrator at local 124 for assistance');
        }
      }
  })
}
//Mark multi request as receive
function mark_all_received()
{
    var id = []
    $('input:checkbox[name=checklist2]:checked').each(function() {
        id.push($(this).val())
    });

    if(id.length > 0){
        //var result = 0;
        $.each( id, function( key, value ) {
            $.ajax({
                type: 'POST',
                url: '../../controls/mark_received_compliance.php',
                data: {id:value},
                async: false,
                dataType: 'html',
                beforeSend: function()
                {
                  showToast();
                },
                success: function(response)
                {
                  result = response;
                },
                error: function(xhr, ajaxOption, thrownError)
                {
                  alert(thrownError);
                }
            })
        })
        //check if process is successful
        if(result > 0)
        {
            toastr.success('Request successfully mark as Received.');
            //display the new list
            $.ajax({
                url: '../../controls/get_list_compliance.php',
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
            toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
        } 
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  } 
}
//mark ALL RETURNED 
$('#btnMarkAllReturn').on('click', function(e){
    e.preventDefault();
    $('#returnedModal').modal('show');
    //get the ID
    var id = []
    $('input:checkbox[name=checklist1]:checked').each(function() {
      id.push($(this).val())
    });
    $('#return-id').val(id);
})

//Mark multi request as returned
function mark_all_returned()
{
  

  if(id.length > 0){
    $.each( id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_return_compliance.php',
        data: {id:value},
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
    })
    //check if process is successful
    if(result > 0)
    {
        toastr.success('Request successfully mark as Returned to AP Team.');
        //display the new list
        $.ajax({
            url: '../../controls/get_list_compliance.php',
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
      toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
    } 
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  } 
}
//get list for receiving
function get_for_receiving()
{
  $('.DataTable').fadeOut();
  $('.DataTable').fadeIn();
  $('#tblReceiving').show();
  $('#tblReturn').hide();
}
//get list returned
function get_returned()
{
  $('.DataTable').fadeOut();
  $('.DataTable').fadeIn();
  $('#tblReceiving').hide();
  $('#tblReturn').show();
}
//CHECKBOXALL (RECEIVING)
$('.checkboxall1').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist1"]:checked'), function(c){return c.value});
      if(selected.length > 1)
      { 
        $('#btnDiv').fadeIn();
        //disable the 2 buttons 
        $('.received').attr('disabled', true);
        $('.return').attr('disabled', true);
      }
      else
      {
        $('#btnDiv').fadeOut();
        //enable 2 buttons
        $('.received').attr('disabled', false);
        $('.return').attr('disabled', false);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#btnDiv').fadeOut();
    })
  }
})
//checklist (RECEIVING)
$('.checklist1').change(function(){
  var selected = $.map($('input[name="checklist1"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
    $('#btnDiv').fadeIn();
    //disable the 2 buttons 
    $('.received').attr('disabled', true);
    $('.return').attr('disabled', true);
  }
  else
  {
    $('#btnDiv').fadeOut();
    //enable 2 buttons
    $('.received').attr('disabled', false);
    $('.return').attr('disabled', false);
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
//CHECKBOXALL (RETURNED)
$('.checkboxall2').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist2"]:checked'), function(c){return c.value});
      if(selected.length > 1)
      { 
        $('#btnDiv').fadeIn();
        //disable the 2 buttons 
        $('.received').attr('disabled', true);
        $('.return').attr('disabled', true);
      }
      else
      {
        $('#btnDiv').fadeOut();
        //enable 2 buttons
        $('.received').attr('disabled', false);
        $('.return').attr('disabled', false);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#btnDiv').fadeOut();
    })
  }
})
//checklist (RETURNED)
$('.checklist2').change(function(){
  var selected = $.map($('input[name="checklist2"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
    $('#btnDiv').fadeIn();
    //disable the 2 buttons 
    $('.received').attr('disabled', true);
    $('.return').attr('disabled', true);
  }
  else
  {
    $('#btnDiv').fadeOut();
    //enable 2 buttons
    $('.received').attr('disabled', false);
    $('.return').attr('disabled', false);
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
</script>