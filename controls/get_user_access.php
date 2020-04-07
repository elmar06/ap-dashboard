<?php
include '../config/clsConnection.php';
include '../objects/clsAccess.php';
include '../objects/clsCompany.php';

$database = new clsConnection();
$db = $database->connect();

$access = new Access($db);
$company = new Company($db);

$access->user_id = $_POST['id'];
$get = $access->get_company();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{   
    echo '
    <div class="form-group">
        <div class="row">
            <div class="col-lg-10">
                <input id="id" value="'.$_POST['id'].'" hidden></input>
                <select id="company" class="form-control mb-3 select2" style="width: 100%;">
                <option selected disabled>Select a Company</option>';
                    $get = $company->get_active_company();
                    while($row1 = $get->fetch(PDO::FETCH_ASSOC))
                    {
                    echo '<option value="'.$row1['id'].'">'.$row1['company'].'</option>';
                    }
                echo '</select>
            </div>
            <div class="col-lg-2">
                <button class="btn-sm btn-success apply" onclick="add_company_access()"><i class="fas fa-check"></i></button>
            </div>
        </div>
        <div>
            <br><div id="comp-warning" class="alert alert-danger" role="alert" style="display: none"></div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center table-flush table-hover" id="tblcompany-access">
        <thead class="thead-light">
            <tr>
                <th hidden>ID</th>
                <th>Company</th>
                <th><center>Action</center></th>
            </tr>
        </thead>
        <tbody>';
            $comp = $row['comp-access'];
            $array_id = explode(',', $comp);
            foreach($array_id as $value)
            {
                //get the list of company
                $id = $value;
                $company->id = $id;
                $view = $company->get_company_detail();
                while($row2 = $view->fetch(PDO::FETCH_ASSOC))
                {
                    echo '
                    <tr>
                        <td hidden><input type="checkbox" name="access" value="'.$row2['id'].'" checked></td>
                        <td>'.$row2['company'].'</td>
                        <td><center><button class="btn-sm btn-danger remove"><i class="fas fa-times-circle"></i></button></center></td>
                    <tr>';
                }
            }
        echo '</tbody>
        </table>
    </div>
    <div>
        <br><div id="access-success" class="alert alert-success" role="alert" style="display: none"></div>
        <div id="access-warning" class="alert alert-danger" role="alert" style="display: none"></div>
    </div>';
}
?>

<script>
$(".select2").select2();//select 2

$('#tblcompany-access').on('click', '.remove', function(){
    //var id = $(this).closest('tr').data('value');
    //var company = $(this).closest('tr').data('company');
    //$('#company').append('<option value="'+ id +'">'+ company +'</option>');
    $(this).closest('tr').remove();
})
</script>