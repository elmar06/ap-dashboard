<!-- Page level custom scripts -->
<script>
$(document).ready(function () {
  $('.DataTable').DataTable({
    scrollX: true
  });
  //toggled sidebar
  $(".sidebar").toggleClass("toggled");
  //auto adjust the datatable header  
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
   $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust();
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

//mark as received by ea
$('.btnReceived').on('click', function(e){
  e.preventDefault();

  var id = $(this).val();
  var action = 1;
  $.ajax({
    type: 'POST',
    url: '../../controls/mark_received_ea.php',
    data: {id:id},
    success: function(html)
    {
      toastr.success('Request successfully mark as Received.');
      //get the latest list
      $('#page-body').fadeOut();
      $('#page-body').fadeIn();
      $('#page-body').html(html);
    }
  })
})
//MARK RECEIVED MULTIPLE
function mark_multi_received_ea()
{
  var id = [];
  $('input:checkbox[name=checklist]:checked').each(function(){
    id.push($(this).val())
  })

  $.each(id, function(key, value){
    $.ajax({
      type: 'POST',
      url: '../../controls/mark_received_ea.php',
      data: {id:value},
      success: function(html)
      {
        toastr.success('Request successfully mark as Received.');
        $('#page-body').html(html);
      }
    })
  })
}
//mark signed
function mark_signed()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() {
    id.push($(this).val())
  });

  if(id.length > 0){
    $.each( id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_as_signed.php',
        data: {id:value},
        success: function(response)
        {
          if(response > 0)
          {
            //display the new list
            $.ajax({
              url: '../../controls/get_list_ea.php',
              success: function(html)
              {
                toastr.success('Request successfully mark as signed.');
                $('#page-body').html(html);
              }
            })
          }else{
            toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
          }
        },
        error: function(xhr, ajaxOption, thrownError)
        {
          alert(thrownError);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  } 
}
//mark returned to EA
function mark_returned()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() {
    id.push($(this).val())
  });

  if(id.length > 0){
    $.each( id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_return_to_ap.php',
        data: {id:value},
        success: function(response)
        {
          if(response > 0)
          {
            toastr.success('Request successfully mark as Returned to AP Team.');
            //display the new list
            $.ajax({
              url: '../../controls/get_list_ea.php',
              success: function(html)
              {
                $('#page-body').fadeOut();
                $('#page-body').fadeIn();
                $('#page-body').html(html);
              }
            })
          }else{
            toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
          }
        },
        error: function(xhr, ajaxOption, thrownError)
        {
          alert(thrownError);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  } 
}

//get all req for signature
function get_for_receiving()
{
  var status = 5;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_stat_list_ea.php',
    data: {status: status},
    beforeSend: function(){
      showToast();
    },
    success: function(html)
    {
      $('#receiving-body').fadeOut();
      $('#receiving-body').fadeIn();
      $('#receiving-body').html(html);
    }
  })
} 

//get all req for signature
function get_for_signature()
{
  var status = 6;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_stat_list_ea.php',
    data: {status: status},
    beforeSend: function(){
      showToast();
    },
    success: function(html)
    {
      alert(html);
      $('#received-body').fadeOut();
      $('#received-body').fadeIn();
      $('#received-body').html(html);
    }
  })
}

//get all signed request
function get_signed()
{
  var status = 7;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_stat_list_ea.php',
    data: {status: status},
    beforeSend: function(){
      showToast();
    },
    success: function(html)
    {
      $('#received-body').fadeOut();
      $('#received-body').fadeIn();
      $('#received-body').html(html);
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
        $('#btnMultiReceived').fadeIn();
      $('.btnReceived').attr('disabled', true);
      }
      else
      {
        $('#btnMultiReceived').fadeOut();
        $('.btnReceived').attr('disabled', false);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#btnMultiReceived').fadeOut();
      $('.btnReceived').attr('disabled', false);
    })
  }
})
</script>

<!-- checklist -->
<script>
$('.checklist').change(function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
    $('#btnMultiReceived').fadeIn();
    $('.btnReceived').attr('disabled', true);
  }
  else
  {
    $('#btnMultiReceived').fadeOut();
    $('.btnReceived').attr('disabled', false);
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