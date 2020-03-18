<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);

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
    $view = $po->get_all_process_bo();
    while($row = $view->fetch(PDO::FETCH_ASSOC))
    {
      //date format
      $bill_date = date('m/d/Y', strtotime($row['bill_date']));
      if($row['status'] == 3)
      {
        $action = '<a href="#" class="btn-sm btn-success btnReceived" value="'.$row['po-id'].'"><i class="fas fa-hand-holding"></i> Received</a>';
      }else{
        $action = '<a href="#" class="btn-sm btn-primary edit" value="'.$row['po-id'].'"><i class="fas fa-edit"></i> Create CV</a>';
      }
      echo '
      <tr>
        <td style="max-width: 2%"><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
        <td style="max-width: 15%">'.$row['comp-name'].'</td>
        <td>'.$row['po_num'].'</td>
        <td>'.$row['supplier_name'].'</td>
        <td>'.$bill_date.'</td>
        <td>'.$row['fullname'].'</td>
        <td><center>'.$action.'</center></td>
      </tr>';
    }  
  }
}
?>

<script>
//process request
$('.edit').click(function(e){
  e.preventDefault();

  var id = $(this).attr('value');

  $.ajax({
    type: 'POST',
    url: '../../controls/view_process_byID.php',
    data: {id:id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#POmodalDetails').modal('show');
      $('#details-body').html(html);
      $('#cv-number').focus();
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})

//mark as received by Back Office
$('.btnReceived').on('click', function(e){
  e.preventDefault();

  var id = $(this).attr('value');
  
  $.ajax({
    type: 'POST',
    url: '../../controls/mark_received_bo.php',
    data: {id: id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(response)
    {
      if(response > 0)
      {
        toastr.success('Request successfully mark as received.');
        //display the new list
        $.ajax({
          type: 'POST',
          url: '../../controls/view_all_process_po.php',
          success: function(html)
          {
            $('#req-body').fadeOut();
            $('#req-body').fadeIn();
            $('#req-body').html(html);
          }
        })
      }else{
        toastr.error('Receiving Failed. Please contact the system administrator at local 124 for assistance.');
      }
    }
  })
})
</script>