<!-- toast function -->
<script>
  function showToast(){
    var title = 'Loading...';
    var duration = 500;
    $.Toast.showToast({title: title,duration: duration, image: 'assets/img/loading.gif'});
  }
  function hideLoading(){
    $.Toast.hideToast();
  }
</script>

<script>
  //login function
  $('#btnlogin').click(function(e){
      e.preventDefault();
  
      var username = $('#username').val();
      var password = $('#password').val();
      var myData = 'username=' + username + '&password=' + password;

      if(username != '' && password != '')
      {
        $.ajax({
          type: 'POST',
          url: 'controls/login.php',
          data: myData,
          beforeSend: function()
          {
            showToast();
          },
          success: function(response)
          {
            if(response > 0)
            {
              window.location = 'controls/checkaccess.php';
            }
            else
            {
              $('#login-warning').html('<center><i class="fas fa-ban"></i> Login Failed. Incorrect Username or Password.</center>');
              $('#login-warning').show();
              setTimeout(function(){
                $('#login-warning').fadeOut();
              }, 1500)
            }
          },
          error: function(xhr, ajaxOptions, thrownError)
          {
            alert(thrownError);
          }
        })
      }else{
        $('#login-warning').html('<center><i class="fas fa-ban"></i> Login Failed. Fillout all fields needed.</center>');
        $('#login-warning').show();
        setTimeout(function(){
          $('#login-warning').fadeOut();
        }, 1500)
      }
  })

  //register function
  $('#register').click(function(e){
    e.preventDefault();

    //other details
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var email = $('#email').val();
    var username = $('#username').val();
    var password = $('#reg-password').val();
    var password2 = $('#reg-password2').val();
    var department = $('#department').val();
    var myData = 'firstname=' + firstname + '&lastname=' + lastname + '&email=' + email + '&username=' + username + '&password=' + password + '&department=' + department;

    if(firstname != null && lastname != null && email != null && password != null)
    {
      //check if the user already exist
      $.ajax({
        type: 'POST',
        url: 'controls/check_user.php',
        data: myData,
        beforeSend: function()
        {
          showToast();
        },
        success: function(response)
        {
          if(response > 0)
          {
            //show error msg if exist
            $('#reg-warning').html('<center><i class="fas fa-ban"></i> Registration Failed. User is already in database.</center>');
            $('#reg-warning').fadeIn();
            setTimeout(function(){
              $('#reg-warning').hide();
            }, 4000)
          }
          else
          {
            //save user information if not exist
            $.ajax({
              type: 'POST',
              url: 'controls/register.php',
              data: myData,
              success: function(response)
              {
                if(response > 0)
                {
                  $('#reg-success').html('<center><i class="fas fa-check"></i> Registration Successfull. You can now Login. </center>');
                  $('#reg-success').fadeIn();
                  setTimeout(function(){
                    $('#reg-success').fadeOut();
                  }, 3000)
                }
                else
                {
                  $('#reg-warning').html('<center><i class="fas fa-ban"></i> Registration Failed. Please call the IT administrator in local 124 for assistance.</center>');
                  $('#reg-warning').fadeIn();
                  setTimeout(function(){
                    $('#reg-warning').hide();
                  }, 4000)
                }
              },
              error: function(xhr, ajaxOptions, thrownError)
              {
                alert(thrownError);
              }
            })
          }
        }
      })
    }
    else
    {
      $('#reg-warning').html('<center><i class="fas fa-ban"></i> Please input all the data needed.</center>');
      $('#reg-warning').fadeIn();
      setTimeout(function(){
        $('#reg-warning').hide();
      }, 4000)  
    }
  })

//border color control
function controlBorderColor() {
  if (this.value.length == 0 || this.value == 0) { this.style.borderColor = "red";}
  else{
   this.style.borderColor = "#d1d3e2";
  }
}

//change the border color when empty
$(document).ready(function(){
  document.getElementById("firstname").addEventListener("keydown", controlBorderColor, false);
  document.getElementById("lastname").addEventListener("keydown", controlBorderColor, false);
  document.getElementById("email").addEventListener("keydown", controlBorderColor, false);
  document.getElementById("department").addEventListener("keydown", controlBorderColor, false);
  document.getElementById("reg-password").addEventListener("keydown", controlBorderColor, false);
  document.getElementById("reg-password2").addEventListener("keydown", controlBorderColor, false);
})
</script>

<script>
//check if the password match
$('#reg-password').keyup(function(){
  var pass1 = $(this).val();
  var pass2 = $('#reg-password2').val();

  if(pass1 != pass2)
  {
    document.getElementById('pass_alert').innerHTML = '<label style="color: red"> ERROR! Password not match. </label>';
    $('#pass_alert').show();
    $('#register').attr('disabled', true);
  }
  else
  {
    document.getElementById('pass_alert').innerHTML = '<label style="color: green"> Password Match. </label>';
    $('#pass_alert').show();
    $('#register').attr('disabled', false);
  }
})

$('#reg-password2').keyup(function(){
  var pass1 = $(this).val();
  var pass2 = $('#reg-password').val();

  if(pass1 != pass2)
  {
    document.getElementById('pass_alert').innerHTML = '<label style="color: red"> ERROR! Password not match. </label>';
    $('#register').attr('disabled', true);
  }
  else
  {
    document.getElementById('pass_alert').innerHTML = '<label style="color: green"> Password Match. </label>';
    $('#register').attr('disabled', false);
  }
})
</script>

<!-- auto generate username -->
<script>
$('#firstname').blur(function(e){
  e.preventDefault();
  var str = $('#firstname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('#lastname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var username = f.concat('.').concat(l);
  $('.username').val(username);
})

$('#lastname').blur(function(e){
  e.preventDefault();
  var str = $('#firstname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('#lastname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var username = f.concat('.').concat(l);
  $('.username').val(username);
})
</script>