<!-- Page level custom scripts -->
<script>
$(document).ready(function () {
  $('#req-table').DataTable();// ID From dataTable with Hover
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

//hold check
function mark_on_hold()
{
    var id = []
    $('input:checkbox[name=checklist]:checked').each(function() {
        id.push($(this).val())
    });

    if(id.length > 0){
    $.each(id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_on_hold.php',
        data: {id: value},
        success: function(html)
        {
          toastr.warning('Request successfully put On Hold.');
          $('#page-body').fadeOut();
          $('#page-body').fadeIn();
          $('#page-body').html(html);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  }
}

//release check
function mark_for_releasing()
{
    var id = []
    $('input:checkbox[name=checklist]:checked').each(function() {
      id.push($(this).val())
    });

    if(id.length > 0){
    $.each(id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_for_releasing.php',
        data: {id: value},
        success: function(html)
        {
          toastr.success('Request successfully mark as For Releasing.');
          $('#page-body').fadeOut();
          $('#page-body').fadeIn();
          $('#page-body').html(html);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  }
}

//get po for verification
function get_for_verification()
{
  var stat = 8;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_for_verification.php',
    data: {stat: stat},
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

//get po on hold
function get_on_hold()
{
  var stat = 9;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_on_hold.php',
    data: {stat: stat},
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
function get_releasing()
{
  var stat = 10;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_for_releasing.php',
    data: {stat: stat},
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

//get po for released
function get_released()
{
  var stat = 10;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_released.php',
    data: {stat: stat},
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
</script>

<script>
$('.checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value});
      if(selected.length > 1)
      { 
        $('#btnAllReceived').attr('disabled', false);
        $('#btnAllReleased').attr('disabled', false);
      }
      else
      {
        $('#btnAllReceived').attr('disabled', false);
        $('#btnAllReleased').attr('disabled', false);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

        $('#btnAllReceived').attr('disabled', false);
        $('#btnAllReleased').attr('disabled', false);
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
    $('#btnAllReceived').attr('disabled', false);
    $('#btnAllReleased').attr('disabled', false);
  }
  else
  {
    $('#btnAllReceived').attr('disabled', false);
    $('#btnAllReleased').attr('disabled', false);
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