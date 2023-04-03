<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);

$po->id = $_POST['id'];
$po->po_id = $_POST['id'];
$po->date_release = date('Y-m-d', strtotime($_POST['release_date']));
$po->or_num = $_POST['or_num'];
$po->receipt = $_POST['receipt'];
$po->released_by = $_SESSION['id'];

$upd = $po->mark_released();

if($upd)
{
    $view = $po->get_for_releasing_fo();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {                      
      //date format
      $bill_date = date('m/d/Y', strtotime($row['bill_date']));
      echo '
      <tr>
        <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
        <td>'.$row['comp-name'].'</td>
        <td>'.$row['po_num'].'</td>
        <td>'.$row['supplier_name'].'</td>
        <td>'.$bill_date.'</td>
        <td>'.$row['fullname'].'</td>
        <td><center>
          <button class="btn btn-success btn-sm btnRelease" value="'.$row['po-id'].'"><i class="fas fa-check-circle"></i> Released</button>
        </center></td>
      </tr>';
    }
}else{
    echo 0;
}
?>
<script>
//mark release per po
$('.btnRelease').on('click', function(e){
    e.preventDefault();
  
    var id = $(this).val();
  
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_released.php',
        data: {id:id},
        success: function(html)
        {
          $('#released-body').fadeOut();
          $('#released-body').fadeIn();
          $('#released-body').html(html);
        }
      })
  })
</script>