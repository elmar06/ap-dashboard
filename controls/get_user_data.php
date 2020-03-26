<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$user->id = $_POST['id'];
$view = $user->get_user_detail_byid();

while($row = $view->fetch(PDO::FETCH_ASSOC))
{
    echo '
        <div class="form-group">
            <input type="text" class="form-control" id="pass-id" placeholder="Firstname" value="'.$row['id'].'" hidden>
            <input type="text" class="form-control firstname" placeholder="Firstname" value="'.$row['firstname'].'" disabled>
        </div>
        <div class="form-group">
            <input type="text" class="form-control lastname" placeholder="Lastname" value="'.$row['lastname'].'" disabled>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="password" placeholder="Password">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="password2" placeholder="Retype Password">
            <small id="change-pass-alert" style="color: green;"></small>
        </div>
        <div id="pass-warning" class="alert alert-danger" role="alert" style="display: none"></div>';
}
?>
<script>
//check if password match
$('#password2').keyup(function(){
  var newpass = $('#password').val();
  var repass = $(this).val();

  if(newpass == repass)
  {
    document.getElementById("change-pass-alert").innerHTML = "<label style='color:green'>Password match</label>";
    $('#btnChangePassword').attr('disabled', false);
  }
  else
  {
    document.getElementById("change-pass-alert").innerHTML = "<label style='color:red'>ERROR! Password not match</label>";
    $('#btnChangePassword').attr('disabled', true);
  }
})  

$('#password').keyup(function(){
  var repass = $('#password2').val();
  var newpass = $(this).val();

  if(newpass == repass)
  {
    document.getElementById("change-pass-alert").innerHTML = "<label style='color:green'>Password match</label>";
    $('#btnChangePassword').attr('disabled', false);
  }
  else
  {
    document.getElementById("change-pass-alert").innerHTML = "<label style='color:red'>ERROR! Password not match</label>";
    $('#btnChangePassword').attr('disabled', true);
  }
})    
</script>