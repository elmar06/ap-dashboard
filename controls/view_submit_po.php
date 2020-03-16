<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$po->submitted_by = $_SESSION['id'];
$get = $po->get_details_pending();
while($row=$get->fetch(PDO::FETCH_ASSOC))
{
    echo '
    <div class="col-lg-4">
      <div class="card mb-5">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">PO/JO Number: '.$row['po_num'].'</h6>
          </div>
          <div class="card-body">
          <p>Company: '.$row['company-name'].'<br>
              Supplier: '.$row['supplier_name'].'
          </p>
          <div class="mt-2 mb-0 text-xs" align="right">
              <a class="text-success details" href="#" value="'.$row['po-id'].'" data-toggle="modal"><i class="fas fa-plus"></i> More Details</a>
          </div>
          </div>
      </div>
    </div>';
}
?>

<script>
$('.details').click(function(e){
  e.preventDefault();

  var id = $(this).attr('value');

  $.ajax({
    type: 'POST',
    url: '../../controls/view_po_details_byID.php',
    data: {id: id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#POmodalDetails').modal('show');
      $('#details-body').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})
</script>