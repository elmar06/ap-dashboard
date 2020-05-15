<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';
$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$view = $user->view_all_user();
while($row = $view->fetch(PDO::FETCH_ASSOC))
{
    //format of status
    if($row['status'] == 1)
    {
        $status = '<label style="color: green"><b> Active</b></label>';
    }
    else
    {
        $status = '<label style="color: red"><b> Inactive</b></label>';
    }
    //department
    if($row['access'] == 1)
    {
        $dept = 'Administrator';
    }elseif($row['access'] == 2)
    {   
        $dept = 'AP Front Office';
    }elseif($row['access'] == 3)
    {   
        $dept = 'AP Back Office';
    }elseif($row['access'] == 4){
        $dept = 'Purchasing';
    }else{
    $dept = 'EA';
    }
    echo '
        <tr>
            <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['id'].'"></td>
            <td>'.$row['fullname'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['username'].'</td>
            <td><center>'.$dept.'</center></td>
            <td>'.$status.'</td>
        </tr>';
}
?>