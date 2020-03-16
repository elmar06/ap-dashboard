<?php
include '../config/clsConnection.php';
include '../objects/clsProject.php';

$database = new clsConnection();
$db = $database->connect();

$proj = new Project($db);

$proj->id = $_POST['id'];
$get = $proj->get_proj_details();
while($row = $get->fetch(PDO:: FETCH_ASSOC))
{
    echo '
        <div class="form-group">
            <input type="text" class="form-control" style="display: none" id="upd-id" placeholder="Supplier Name" value="'.$row['id'].'">
            <input type="text" class="form-control" id="upd-name" placeholder="Project Name" value="'.$row['project'].'">
        </div>
        <div id="upd-success" class="alert alert-success" role="alert" style="display: none"></div>
        <div id="upd-warning" class="alert alert-danger" role="alert" style="display: none"></div>';
}

?>