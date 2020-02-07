<?php
include '../config/clsConnection.php';
include '../objects/clsDepartment.php';

$database = new clsConnection();
$db = $database->connect();

$dept = new Department($db);

$dept->id = $_POST['id'];
$get = $dept->get_department_details();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
    echo '
        <div class="form-group">
            <input type="text" class="form-control" style="display: none" id="upd-id" value="'.$row['id'].'">
            <input type="text" class="form-control" id="upd-name" placeholder="Company Name" value="'.$row['department'].'">
        </div>
        <div id="upd-success" class="alert alert-success" role="alert" style="display: none"></div>
        <div id="upd-warning" class="alert alert-danger" role="alert" style="display: none"></div>';
}
?>