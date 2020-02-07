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
            <input type="text" class="form-control" id="upd-id" placeholder="Firstname" value="'.$row['id'].'" hidden>
            <input type="text" class="form-control firstname" id="upd-firstname" placeholder="Firstname" value="'.$row['firstname'].'" disabled>
        </div>
        <div class="form-group">
            <input type="text" class="form-control lastname" id="upd-lastname" placeholder="Lastname" value="'.$row['lastname'].'" disabled>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" id="upd-email" placeholder="Email Address" value="'.$row['email'].'" disabled>
        </div>
        <div class="form-group">
            <select id="upd-department" class="form-control mb-3" disabled>';
            if($row['access'] == 1)
            {
                echo '<option value="0" selected disabled>Please select a Department</option>
                <option value="1" selected>Administrator</option>
                <option value="2">Accounts Payable</option>
                <option value="3">Purchasing</option>';
            }
            elseif($row['access'] == 2)
            {
                echo '<option value="0" selected disabled>Please select a Department</option>
                <option value="1">Administrator</option>
                <option value="2" selected>Accounts Payable</option>
                <option value="3">Purchasing</option>';
            }
            else
            {
                echo '<option value="0" selected disabled>Please select a Department</option>
                <option value="1">Administrator</option>
                <option value="2">Accounts Payable</option>
                <option value="3" selected>Purchasing</option>';
            }
            echo '</select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control username" id="upd-username" placeholder="Username" value="'.$row['username'].'" disabled>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="upd-password" placeholder="Username" value="123456" disabled>
        </div>
            <div id="upd-success" class="alert alert-success" role="alert" style="display: none"></div>
            <div id="upd-warning" class="alert alert-danger" role="alert" style="display: none"></div>';
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
</script>