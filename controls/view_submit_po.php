<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
echo'
<div class="row mb-3">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Pending PO/JO</div>';
              $po->submitted_by = $_SESSION['id'];
              $count = $po->count_pending_by_user();
              if($row = $count->fetch(PDO::FETCH_ASSOC))
              {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['pending-count'].'</div>';
              }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
              }
            echo '
            <div class="mt-2 mb-0 text-muted text-xs">
            <a class="text-success mr-2" href="#" onclick="get_pending_po()"><i class="fas fa-arrow-up"></i> More Details</a>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-times-circle fa-2x text-danger"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Returned</div>';
              $po->submitted_by = $_SESSION['id'];
              $count = $po->count_return_by_user();
              if($row = $count->fetch(PDO::FETCH_ASSOC))
              {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['return-count'].'</div>';
              }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
              }
            echo '
            <div class="mt-2 mb-0 text-muted text-xs">
            <a class="text-success mr-2" href="#" onclick="get_returned_po()"><i class="fas fa-arrow-up"></i> More Details</a>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-retweet fa-2x text-warning"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">On Process</div>';
              $po->submitted_by = $_SESSION['id'];
              $count = $po->count_on_process_by_user();
              if($row = $count->fetch(PDO::FETCH_ASSOC))
              {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['process-count'].'</div>';
              }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
              }
            echo '
            <div class="mt-2 mb-0 text-muted text-xs">
            <a class="text-success mr-2" href="#" onclick="get_process_po()"><i class="fas fa-arrow-up"></i> More Details</a>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-history fa-2x text-info"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">For Releasing</div>';
              $po->submitted_by = $_SESSION['id'];
              $count = $po->count_releasing_by_user();
              if($row = $count->fetch(PDO::FETCH_ASSOC))
              {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['releasing-count'].'</div>';
              }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
              }
            echo'
            <div class="mt-2 mb-0 text-muted text-xs">
              <a class="text-success mr-2" href="#" onclick="get_releasing_po()"><i class="fas fa-arrow-up"></i> More Details</a>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-check-circle fa-2x text-success"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="req-btn" class="row mb-3">
  <div class="col-md-12">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PO-Modal" id="#myBtn"> Submit PO/JO</button>
    <button type="button" class="btn btn-danger" id="btnClear" style="display: none" onclick="clear_list()"> Clear Search</button>
  </div>
</div>

<div id="po-details-body" class="row">';
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