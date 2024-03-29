<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';
include '../objects/clsCheckDetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);
$check = new CheckDetails($db);

$new_date = date('Y-m-d', strtotime($_POST['new_check_date']));
$old_date = date('Y-m-d', strtotime($_POST['old_check_date']));

//new data(update the check_details)
$check->po_id = $_POST['id'];
$check->cv_no = $_POST['new_cv_no'];
$check->bank = $_POST['new_bank'];
$check->check_no = $_POST['new_check_no'];
$check->tax = $_POST['tax'];
$check->cv_amount = $_POST['cv_amount'];
$check->check_date = $new_date;
$upd_po_details = $check->upd_details();

//update status in po_details
$po->id = $_POST['id'];
$po->status = 5;
$upd_stat = $po->update_details_status();

//old data(save the old check details into db)
$po->po_id = $_POST['id'];
$po->cv_no = $_POST['old_cv_no'];
$po->bank = $_POST['old_bank'];
$po->check_no = $_POST['old_check_no'];
$po->check_date = $old_date;

$save_details = $po->save_old_details();

if($upd_po_details)
{
  if($upd_stat)
  {
    if($save_details)
    {
        echo 1;
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
                $view = $po->get_all_cancel($comp_id);
                while($row = $view->fetch(PDO::FETCH_ASSOC))
                {
                    //date format
                    $bill_date = date('m/d/Y', strtotime($row['bill_date']));
                    echo '
                    <tr>
                      <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                      <td>'.$row['cv_no'].'</td>
                      <td>'.$row['check_no'].'</td>
                      <td>'.$row['supplier_name'].'</td>
                      <td>'.$bill_date.'</td>
                      <td>'.$row['fullname'].'</td>
                      <td style="width: 115px"><center>
                        <button class="btn-sm btn-success create" value="'.$row['po-id'].'"><i class="fas fa-check"></i> Create new CV</button>
                      </td>
                    </tr>';
                }  
            }
        }
    }else{
        echo 0;
    }
  }
  else
  {
    echo 0;
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

//cancel check function
$('.cancel').on('click', function(e){
  e.preventDefault();

  var id = $(this).val();
  
  $.ajax({
    type: 'POST',
    url: '../../controls/view_for_cancel.php',
    data: {id: id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#cancelModal').modal('show');
      $('#details-body').html(html);
    }
  })
})
</script>