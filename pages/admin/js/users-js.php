<!-- Page level custom scripts -->
<script>
  $(document).ready(function () {
    $('#user-table').DataTable(); // ID From dataTable with Hover
  });
</script>

<!-- Adding new users -->
<script>
$('#btnSaveUser').click(function(e){
    e.preventDefault();

    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var email = $('#email').val();
    var department = $('#department').val();
    var username = $('#username').val();
    var myData = 'firstname=' + firstname + '&lastname=' + lastname + '&email=' + email + '&department=' + department + '&username=' + username;
    
    if(firstname != '' && lastname != '' && email != '' && department != null)
    {
        $.ajax({
            type: 'POST',
            url: '../../controls/add_user.php',
            data: myData,
            beforeSend: function()
            {
                showToast();
            },  
            success: function(response)
            {
                if(response > 0)
                {
                    $.ajax({
                        url: '../../controls/view_all_user.php',
                        success: function(html)
                        {
                            $('#user-body').html(html);
                            $('#add-success').html('<center><i class="fas fa-check"></i> New User Successfully added. </center>');
                            $('#add-success').show().fadeOut(8000);
                        }
                    })
                }
                else
                {
                    $('#add-warning').html('<center><i class="fas fa-ban"></i> Adding Failed. Please call the IT administrator in local 124 for assistance.</center>');
                    $('#add-warning').show();
                    setTimeout(function(){
                        $('#add-warning').fadeOut();
                    }, 5000)
                }
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                alert(thrownError);
            }
        })
    }
    else
    {
        $('#add-warning').html('<center><i class="fas fa-ban"></i> Submit Failed. Please input all the data needed.</center>');
        $('#add-warning').show();
        setTimeout(function(){
            $('#add-warning').fadeOut();
        }, 5000)
    }
})
</script>
<!-- update user details function -->
<script>
$('#btnUpdUser').click(function(e){
    e.preventDefault();

    var id = $('#upd-id').val();
    var firstname = $('#upd-firstname').val();
    var lastname = $('#upd-lastname').val();
    var email = $('#upd-email').val();
    var department = $('#upd-department').val();
    var username = $('#upd-username').val();
    var myData = 'id=' + id + '&firstname=' + firstname + '&lastname=' + lastname + '&email=' + email + '&department=' + department + '&username=' + username;

    if(firstname != '' && lastname != '' && email != '' && department != null)
    {
        $.ajax({
            type: 'POST',
            url: '../../controls/upd_user.php',
            data: myData,
            beforeSend: function()
            {
                showToast();
            },
            success: function(response)
            {
                if(response > 0)
                {
                    $.ajax({
                        url: '../../controls/view_all_user.php',
                        success: function(html)
                        {
                            $('#user-body').html(html);
                            $('#upd-success').html('<center><i class="fas fa-check"></i> User details successfully updated. </center>');
                            $('#upd-success').show().fadeOut(8000);
                        }
                    })
                }
                else
                {
                    $('#upd-warning').html('<center><i class="fas fa-ban"></i> Update Failed. Please call the IT administrator in local 124 for assistance.</center>');
                    $('#upd-warning').show();
                    setTimeout(function(){
                        $('#upd-warning').fadeOut();
                    }, 5000)
                }
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                alert(thrownError);
            }
        })
    }
    else
    {
        $('#upd-warning').html('<center><i class="fas fa-ban"></i> Update Failed. Please input all the data needed.</center>');
        $('#upd-warning').show();
        setTimeout(function(){
            $('#upd-warning').fadeOut();
        }, 5000)
    }    
})
</script>

<!-- set the user active -->
<script>
$('#btnActivate').click(function(e){
    e.preventDefault();

    var id = []
    $('input:checkbox[name=checklist]:checked').each(function() {
         id.push($(this).val())
    });

    if(id == 0)
    {
        $('#error-msg').html('<i class="fas fa-times-circle"></i> ERROR! Please select a user to proceed.<i>');
        $('#error-msg').show();
        $('#success-msg').hide();
        $('#errorModal').modal('show');
    }
    else
    {
        $.ajax({
            type: 'POST',
            url: '../../controls/activate_user.php',
            data: 'id=' + id,
            beforeSend: function()
            {
                showToast();
            },
            success: function(response)
            {
                if(response > 0)
                {
                    $.ajax({
                        url: '../../controls/view_all_user.php',
                        success: function(html)
                        {
                            $('#user-body').html(html);
                            $('#upd-success').html('<center><i class="fas fa-check"></i> User successfully marked as inactive. </center>');
                            $('#upd-success').show().fadeOut(10000);
                        }
                    })
                }
                else
                {
                    $('#upd-warning').html('<center><i class="fas fa-ban"></i> Removing Failed. Please call the IT administrator in local 124 for assistance.</center>');
                    $('#upd-warning').show().fadeOut(10000);
                }
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                alert(thrownError);
            }
        })
    }
})
</script>

<!-- set the user inactive -->
<script>
$('#btnRemove').click(function(e){
    e.preventDefault();

    var id = []
    $('input:checkbox[name=checklist]:checked').each(function() {
         id.push($(this).val())
    });

    if(id == 0)
    {
        $('#error-msg').html('<i class="fas fa-times-circle"></i> ERROR! Please select a user to proceed.<i>');
        $('#error-msg').show();
        $('#success-msg').hide();
        $('#errorModal').modal('show');
    }
    else
    {
        $.ajax({
            type: 'POST',
            url: '../../controls/delete_user.php',
            data: 'id=' + id,
            beforeSend: function()
            {
                showToast();
            },
            success: function(response)
            {
                if(response > 0)
                {
                    $.ajax({
                        url: '../../controls/view_all_user.php',
                        success: function(html)
                        {
                            $('#user-body').html(html);
                            $('#upd-success').html('<center><i class="fas fa-check"></i> User successfully marked as inactive. </center>');
                            $('#upd-success').show().fadeOut(10000);
                        }
                    })
                }
                else
                {
                    $('#upd-warning').html('<center><i class="fas fa-ban"></i> Removing Failed. Please call the IT administrator in local 124 for assistance.</center>');
                    $('#upd-warning').show().fadeOut(10000);
                }
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                alert(thrownError);
            }
        })
    }
})
</script>

<!-- reset password function -->
<script>
$('#btnReset').click(function(e){
    e.preventDefault();

    var id = []
    $('input:checkbox[name=checklist]:checked').each(function() {
         id.push($(this).val())
    });
    
    if(id == 0)
    {
        $('#error-msg').html('<i class="fas fa-times-circle"></i> ERROR! Please select a user to proceed.<i>');
        $('#error-msg').show();
        $('#success-msg').hide();
        $('#errorModal').modal('show');
    }
    else
    {
        $.ajax({
            type: 'POST',
            url: '../../controls/reset_user.php',
            data: 'id=' + id,
            beforeSend: function()
            {
                showToast();
            },
            success: function(response)
            {
                if(response > 0)
                {
                    $('#success-msg').html('<i class="fas fa-times-circle"></i> Password Successfully Reset. User can now login using the default password.<i>');
                    $('#success-msg').show();
                    $('#error-msg').hide();
                    $('#errorModal').modal('show');
                }
                else
                {
                    $('#error-msg').html('<i class="fas fa-times-circle"></i> ERROR! Please contact the administrator at local 124.<i>');
                    $('#error-msg').show();
                    $('#success-msg').hide();
                    $('#errorModal').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                alert(thrownError);
            }
        })
    }
})
</script>

<!-- edit button function -->
<script>
$('#btnEdit').click(function(e){
    e.preventDefault();

    $('#btnUpdUser').attr('disabled', false);
    $('#upd-firstname').attr('disabled', false);
    $('#upd-lastname').attr('disabled', false);
    $('#upd-email').attr('disabled', false);
    $('#upd-department').attr('disabled', false);
})
</script>

<!-- get the user details when double click -->
<script>
$(document).on('dblclick', '#user-table tr', function(){
    var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();

    $.ajax({
      type: 'POST',
      url: '../../controls/view_user_byID.php',
      data: {id:id},
      beforeSend: function()
      {
        showToast();
      },
      success: function(html)
      {
        $('#userDetailsModal').modal('show');
        $('#details-body').html(html);
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    })
  })
</script>

<!-- auto generate username -->
<script>
$('.firstname').blur(function(e){
  e.preventDefault();
  var str = $('.firstname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('.lastname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var username = f.concat('.').concat(l);
  $('.username').val(username);
})

$('.lastname').blur(function(e){
  e.preventDefault();
  var str = $('.firstname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('.lastname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var username = f.concat('.').concat(l);
  $('.username').val(username);
})
</script>

<!-- toast function -->
<script>
  function showToast(){
    var title = 'Loading...';
    var duration = 500;
    $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
  }
  function hideLoading(){
    $.Toast.hideToast();
  }
</script>