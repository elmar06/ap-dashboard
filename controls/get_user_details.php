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
            <input type="text" class="form-control" id="user-id" placeholder="Firstname" value="'.$row['id'].'" hidden>
            <input type="text" class="form-control firstname" id="user-firstname" placeholder="Firstname" value="'.$row['firstname'].'">
        </div>
        <div class="form-group">
            <input type="text" class="form-control lastname" id="user-lastname" placeholder="Lastname" value="'.$row['lastname'].'">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" id="user-email" placeholder="Email Address" value="'.$row['email'].'">
        </div>
        <div class="form-group">
            <select id="user-department" class="form-control mb-3" disabled>';
            if($row['access'] == 1)
            {
                echo '<option value="0" selected disabled>Please select a Department</option>
                <option value="1" selected>Administrator</option>
                <option value="2">Accounting Front Office</option>
                <option value="3">Accounting Back Office</option>
                <option value="4">SCM/PMC</option>
                <option value="5">EA</option>
                <option value="6">Treasury</option>
                <option value="7">Manager</option>';
            }
            elseif($row['access'] == 2)
            {
                echo '<option value="0" selected disabled>Please select a Department</option>
                <option value="1">Administrator</option>
                <option value="2" selected>Accounting Front Office</option>
                <option value="3">Accounting Back Office</option>
                <option value="4">SCM/PMC</option>
                <option value="5">EA</option>
                <option value="6">Treasury</option>
                <option value="7">Manager</option>';
            }
            elseif($row['access'] == 3)
            {
                echo '<option value="0" selected disabled>Please select a Department</option>
                <option value="1">Administrator</option>
                <option value="2">Accounting Front Office</option>
                <option value="3" selected>Accounting Back Office</option>
                <option value="4">SCM/PMC</option>
                <option value="5">EA</option>
                <option value="6">Treasury</option>
                <option value="7">Manager</option>';
            }
            elseif($row['access'] == 4)
            {
                echo '<option value="0" selected disabled>Please select a Department</option>
                <option value="1">Administrator</option>
                <option value="2">Accounting Front Office</option>
                <option value="3">Accounting Back Office</option>
                <option value="4" selected>SCM/PMC</option>
                <option value="5">EA</option>
                <option value="6">Treasury</option>
                <option value="7">Manager</option>';
            }
            elseif($row['access'] == 5)
            {
                echo '<option value="0" selected disabled>Please select a Department</option>
                <option value="1">Administrator</option>
                <option value="2">Accounting Front Office</option>
                <option value="3">Accounting Back Office</option>
                <option value="4">SCM/PMC</option>
                <option value="5" selected>EA</option>
                <option value="6">Treasury</option>
                <option value="7">Manager</option>';
            }
            elseif($row['access'] == 6)
            {
                echo '<option value="0" selected disabled>Please select a Department</option>
                <option value="1">Administrator</option>
                <option value="2">Accounting Front Office</option>
                <option value="3">Accounting Back Office</option>
                <option value="4">SCM/PMC</option>
                <option value="5">EA</option>
                <option value="6" selected>Treasury</option>
                <option value="7">Manager</option>';
            }
            elseif($row['access'] == 7)
            {
                echo '<option value="0" selected disabled>Please select a Department</option>
                <option value="1">Administrator</option>
                <option value="2">Accounting Front Office</option>
                <option value="3">Accounting Back Office</option>
                <option value="4">SCM/PMC</option>
                <option value="5">EA</option>
                <option value="6">Treasury</option>
                <option value="7" selected>Manager</option>';
            }
            else
            {
                echo '<option value="0" selected disabled>Please select a Department</option>
                <option value="1">Administrator</option>
                <option value="2">Accounting Front Office</option>
                <option value="3">Accounting Back Office</option>
                <option value="4">SCM/PMC</option>
                <option value="5">EA</option>
                <option value="6">Treasury</option>
                <option value="7" selected>Manager</option>';
            }
            echo '</select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control username" id="user-username" placeholder="Username" value="'.$row['username'].'" disabled>
        </div>
        <div class="form-group">
            <small style="color: green;">Leave the password BLANK if you dont want to change it.</small>
            <input type="password" class="form-control" id="user-password" placeholder="Password">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="user-password2" placeholder="Retype Password">
            <small id="pass-alert" style="color: green;"></small>
        </div>
        <div id="user-success" class="alert alert-success" role="alert" style="display: none"></div>
        <div id="user-warning" class="alert alert-danger" role="alert" style="display: none"></div>';
}
?>

<!-- auto generate username -->
<script>
$('#upd-firstname').blur(function(e){
  e.preventDefault();
  var str = $('#upd-firstname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('#upd-lastname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var username = f.concat('.').concat(l);
  $('#upd-username').val(username);
})

$('#upd-lastname').blur(function(e){
  e.preventDefault();
  var str = $('#upd-firstname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('#upd-lastname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var username = f.concat('.').concat(l);
  $('#upd-username').val(username);
})

//check if password match
$('#user-password2').keyup(function(){
  var newpass = $('#user-password').val();
  var repass = $(this).val();

  if(newpass == repass)
  {
    document.getElementById("pass-alert").innerHTML = "<label style='color:green'>Password match</label>";
    $('#btnUpdate').attr('disabled', false);
  }
  else
  {
    document.getElementById("pass-alert").innerHTML = "<label style='color:red'>ERROR! Password not match</label>";
    $('#btnUpdate').attr('disabled', true);
  }
})  

$('#user-password').keyup(function(){
  var repass = $('#user-password2').val();
  var newpass = $(this).val();

  if(newpass == repass)
  {
    document.getElementById("pass-alert").innerHTML = "<label style='color:green'>Password match</label>";
    $('#btnUpdate').attr('disabled', false);
  }
  else
  {
    document.getElementById("pass-alert").innerHTML = "<label style='color:red'>ERROR! Password not match</label>";
    $('#btnUpdate').attr('disabled', true);
  }
})  
</script>