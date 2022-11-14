<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$supplier = new Supplier($db);
$company = new Company($db);

echo '<div class="row mb-3">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Pending PO/JO</div>';
                        $count = $po->count_pending();
                        if($row2 = $count->fetch(PDO::FETCH_ASSOC))
                        {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row2['pending-count'].'</div>';
                        }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                        echo '<div class="mt-2 mb-0 text-muted text-xs">
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
                        $count = $po->count_return();
                        if($row3 = $count->fetch(PDO::FETCH_ASSOC))
                        {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row3['return-count'].'</div>';
                        }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                        echo '<div class="mt-2 mb-0 text-muted text-xs">
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
                        $count = $po->count_on_process();
                        if($row4 = $count->fetch(PDO::FETCH_ASSOC))
                        {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row4['process-count'].'</div>';
                        }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }

                        echo '<div class="mt-2 mb-0 text-muted text-xs">
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
                        $count = $po->count_releasing();
                        if($row5 = $count->fetch(PDO::FETCH_ASSOC))
                        {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row5['releasing-count'].'</div>';
                        }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                        echo '<div class="mt-2 mb-0 text-muted text-xs">
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
        <div>
            <a id="btnAllReceived" type="button" class="btn btn-primary mb-1" href="#" style="display: none" onclick="received_all()">Mark All Received</a>
            <a id="btnAllReturned" type="button" class="btn btn-warning mb-1" href="#" style="display: none" onclick="returned_all()">Mark All Returned</a>
            <a id="btnAllRelease" type="button" class="btn btn-success mb-1" href="#" style="display: none" onclick="released_all()">Mark All Released</a>
        </div><br>
        <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover DataTable" id="req-table">
                <thead class="thead-light">
                    <tr>
                    <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                    <th>Company</th>
                    <th>PO/JO No</th>
                    <th>SI No</th>
                    <th>Supplier</th>
                    <th>Billing Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    </tr>
                </thead>
                <tbody id="req-body">';
                  $view = $po->get_submitted_po();
                  while($row = $view->fetch(PDO::FETCH_ASSOC))
                  {
                    //get the COMPANY name if exist
                    $company->id = $row['comp-id'];
                    $get2 = $company->get_company_detail();
                    while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
                    {
                      if($row['comp-id'] == $rowComp['id']){
                        $comp_name = $rowComp['company'];
                      }else{
                        $comp_name = '-';
                      }
                    }
                    //get the SUPPLIER name if exist
                    $supplier->id = $row['supp-id'];
                    $get3 = $supplier->get_supplier_details();
                    while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
                    {
                      if($row['supp-id'] == $rowSupp['id']){
                        $sup_name = $rowSupp['supplier_name'];
                      }else{
                        $sup_name = '-';
                      }
                    }
                    //format of status
                    if($row['status'] == 1){
                      $status = '<label style="color: red"><b> Pending</b></label>';
                    }else if($row['status'] == 2){
                      $status = '<label style="color: orange"><b> Returned</b></label>';
                    }elseif($row['status'] == 5){
                      $status = '<label style="color: blue"><b> For Signature</b></label>';
                    }elseif($row['status'] == 6){
                      $status = '<label style="color: blue"><b> Sent to EA</b></label>';
                    }elseif($row['status'] == 8){
                      $status = '<label style="color: blue"><b> For Verification</b></label>';
                    }elseif($row['status'] == 9){
                      $status = '<label style="color: red"><b> On Hold</b></label>';
                    }else if($row['status'] == 10){
                      $status = '<label style="color: green"><b> For Releasing</b></label>';
                    }else if($row['status'] == 11){
                      $status = '<label style="color: green"><b> Released</b></label>';
                    }else{
                      $status = '<label style="color: blue"><b> On Process</b></label>';
                    }
                    //date format
                    $bill_date = date('m/d/Y', strtotime($row['bill_date']));
                    echo '
                    <tr>
                      <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                      <td>'.$comp_name.'</td>
                      <td>'.$row['po_num'].'</td>
                      <td>'.$row['si_num'].'</td>
                      <td>'.$sup_name.'</td>
                      <td>'.$bill_date.'</td>
                      <td>'.$row['amount'].'</td>
                      <td><center>'.$status.'</center></td>
                    </tr>';
                  }
                echo '</tbody>
                </table> 
            </div>
            </div>
        </div><!-- /column -->
        </div>';
?>

<!-- Page level custom scripts -->
<script>
$(document).ready(function () {
  $('#dataTable').DataTable(); // ID From dataTable 
  $('#req-table').DataTable(); // ID From dataTable with Hover
})

//view details
$(document).on('dblclick', '.DataTable tr', function(){
  var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();
  
  $.ajax({
    type: 'POST',
    url: '../../controls/view_po_details_fo.php',
    data: {id:id},
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

$('.checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value});
      if(selected.length > 1)
      { 
        $('#btnAllReceived').fadeIn();
        $('#btnAllReturned').fadeIn();
        $('#btnAllReleased').attr('disabled', false);
      }
      else
      {
        $('#btnAllReceived').fadeOut();
        $('#btnAllReturned').fadeOut();
        $('#btnAllReleased').attr('disabled', true);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#btnAllReceived').fadeOut();
      $('#btnAllReturned').fadeOut();
      $('#btnAllReleased').attr('disabled', true);
    })
  }
});

$('.checklist').change(function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
    $('#btnAllReceived').fadeIn();
    $('#btnAllReturned').fadeIn();
    $('#btnAllReleased').attr('disabled', false);
  }
  else
  {
    $('#btnAllReceived').fadeOut();
    $('#btnAllReturned').fadeOut();
    $('#btnAllReleased').attr('disabled', true);
  }
})
</script>