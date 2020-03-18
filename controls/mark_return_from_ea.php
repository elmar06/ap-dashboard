<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);

$po->status = 8;
$po->date_from_ea = date('Y-m-d');
$po->po_id = $_POST['id'];
$po->id = $_POST['id'];

$upd = $po->mark_return_from_ea();

if($upd)
{
   //get the user company access
   $user_id = $_SESSION['id'];
   $access->user_id = $user_id;
   $get = $access->get_company();
   while($row1 = $get->fetch(PDO::FETCH_ASSOC))
   {
     //get the access company id
     $id = $row1['comp-access'];
     $array_id = explode(',', $id);
     foreach($array_id as $value)
     {
       $comp_id =  $value; 
       //display all the data by access
       $po->id = $comp_id;
       $view = $po->get_all_for_signature_bo($comp_id);
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
             <select class="form-control-sm action" style="width:120px">
               <option value="0" selected disabled>Mark Status</option>';
                if($row['po-stat'] == 5){
                echo '<option value="1">Sent to EA</option>
                      <option value="2">Returned from EA</option>';
                }elseif($row['po-stat'] == 6){
                  echo '<option value="1" disabled selected>Sent to EA</option>
                        <option value="2">Returned from EA</option>';
                }elseif($row['po-stat'] == 7){
                  echo '<option value="1" disabled>Sent to EA</option>
                        <option value="1" disabled selected>For Pick Up in EA</option>
                        <option value="2">Returned from EA</option>';
                }elseif($row['po-stat'] == 8){
                  echo '<option value="1" disabled>Sent to EA</option>
                        <option value="2" disabled selected>Returned from EA</option>';
                }else{
                  echo '<option value="1">Sent to EA</option>
                        <option value="2">Returned from EA</option>';
                }
             echo '</select>
             <button class="btn-sm btn-success apply" value="'.$row['po-id'].'"><i class="fas fa-check"></i></button></center>
           </td>
         </tr>';
       }  
     }
   }
}else{
    echo 0;
}
?>

<script>
//submit or apply function
$('.apply').on('click', function(e){
  e.preventDefault();
  var id = $(this).val();
  var action =$(this).closest('tr').find('.action').val();

  //update date_to_ea in po_other_details
  if(action == 1)
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/mark_sent_to_ea.php',
      data: {id:id},
      success: function(html)
      {
        toastr.success('Request successfully mark as forwarded to EA Team.');
        $('#process-body').html(html);
      }
    })
  }
  //update date_from_ea in po_other_details
  if(action == 2)
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/mark_return_from_ea.php',
      data: {id:id},
      success: function(html)
      {
        toastr.success('Request successfully mark as Returned from EA Team.');
        $('#process-body').html(html);
      }
    })
  }
})
</script>