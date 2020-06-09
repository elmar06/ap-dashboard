<!-- Page level custom scripts -->
<script>
$(document).ready(function () {
  $('#req-table').DataTable();// ID From dataTable with Hover
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
          toastr.warning('Request successfully mark as On Hold.');
          $('#req-body').html(html);
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
          toastr.success('Request is mark as For Releasing.');
          $('#req-body').html(html);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  }
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