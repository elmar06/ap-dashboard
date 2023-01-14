<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);
$supplier = new Supplier($db);
$company = new Company($db);

echo '
  <div class="row mb-3">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
      <div class="card-body">
          <div class="row align-items-center">
          <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">For BO Processing</div>';
              $po->submitted_by = $_SESSION['id'];
              $count = $po->count_for_process_bo();
              if($row = $count->fetch(PDO::FETCH_ASSOC))
              {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['pending-count'].'</div>';
              }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
              }
              echo '<div class="mt-2 mb-0 text-muted text-xs">
              <a class="text-success mr-2" href="process_po.php"><i class="fas fa-arrow-up"></i> More Details</a>
              </div>
          </div>
          <div class="col-auto">
              <i class="fas fa-file-contract fa-2x text-danger"></i>
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
              <div class="text-xs font-weight-bold text-uppercase mb-1">For Signature</div>';
              $po->submitted_by = $_SESSION['id'];
              $count = $po->count_for_signature();
              if($row = $count->fetch(PDO::FETCH_ASSOC))
              {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
              }else{
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
              }
              echo '<div class="mt-2 mb-0 text-muted text-xs">
              <a class="text-success mr-2" href="process_po.php" onclick="get_returned_po()"><i class="fas fa-arrow-up"></i> More Details</a>
              </div>
          </div>
          <div class="col-auto">
              <i class="fas fa-file-signature fa-2x text-warning"></i>
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
              <div class="text-xs font-weight-bold text-uppercase mb-1">For Verification</div>';
              $po->submitted_by = $_SESSION['id'];
              $count = $po->count_on_hold();
              if($row = $count->fetch(PDO::FETCH_ASSOC))
              {
                  echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
              }else{
                  echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
              }
              echo '<div class="mt-2 mb-0 text-muted text-xs">
              <a class="text-success mr-2" href="#" onclick="get_process_po()"><i class="fas fa-arrow-up"></i> More Details</a>
              </div>
          </div>
          <div class="col-auto">
              <i class="fas fa-check-double fa-2x text-info"></i>
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
              $count = $po->count_releasing();
              if($row = $count->fetch(PDO::FETCH_ASSOC))
              {
                echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['releasing-count'].'</div>';
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

  </div> <!-- end of card row -->
  <div class="row mb-3">
  <div class="col-lg-12">
    <button id="btnCreate" class="btn btn-primary mb-1" data-toggle="modal" data-target="#createCV"><i class="fas fa-plus-square"></i> Create Multi CV</button>
    <button id="btnAllReceive" class="btn btn-success mb-1" onclick="mark_all_received()" disabled><i class="fas fa-check-circle"></i> Mark Receive</button>
  </div>
  </div>
  <!-- DataTable with Hover -->
  <div class="row mb-3">
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="table-responsive p-3">
        <table class="table1 align-items-center table-flush table-hover" id="req-table">
          <thead class="thead-light">
            <tr>
              <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
              <th>Company</th>
              <th>PO/JO #</th>
              <th>SI #</th>
              <th>Supplier</th>
              <th>Billing Date</th>
              <th>Amount</th>
              <th><center>Action</center></th>
            </tr>
          </thead>
          <tbody id="req-body">';
            //get the user company access
            $access->user_id = $_SESSION['id'];
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
                $po->company = $comp_id;
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
                  //get the COMPANY name if exist
                  $comp_name = '-';
                  $company->id = $row['comp-id'];
                  $get2 = $company->get_company_detail();
                  while($rowComp = $get2->fetch(PDO::FETCH_ASSOC))
                  {
                    if($row['comp-id'] == $rowComp['id']){
                      $comp_name = $rowComp['company'];
                    }
                  }
                  //get the SUPPLIER name if exist
                  $sup_name = '-';
                  $supplier->id = $row['supp-id'];
                  $get3 = $supplier->get_supplier_details();
                  while($rowSupp = $get3->fetch(PDO::FETCH_ASSOC))
                  {
                    if($row['supp-id'] == $rowSupp['id']){
                      $sup_name = $rowSupp['supplier_name'];
                    }
                  }
                  echo '
                  <tr>
                    <td style="max-width: 2%"><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                    <td style="max-width: 15%">'.$comp_name.'</td>
                    <td>'.$row['po_num'].'</td>
                    <td>'.$row['si_num'].'</td>
                    <td>'.$sup_name.'</td>
                    <td style="max-width: 20%">'.$bill_date.'</td>
                    <td>'.number_format(floatval($row['amount']), 2).'</td>
                    <td><center>'.$action.'</center></td>
                  </tr>';
                }  
              }
            }
          echo '  
          </tbody>
        </table> 
      </div>
    </div>
  </div>
  </div>';
?>

<script>
$(document).ready(function () {
  $('#req-table').DataTable();// ID From dataTable with Hover
  //select2 js
  $(".select2").select2();
  //select2 multiple
  $('.basic-multiple').select2();
  //datepicker
  $('.datepicker').datepicker({
    clearBtn: true,
    format: "MM dd, yyyy",
    setDate: new Date(),
    autoClose: true
  });
})
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
            $('#page-body').fadeOut();
            $('#page-body').fadeIn();
            $('#page-body').html(html);
          }
        })
      }else{
        toastr.error('Receiving Failed. Please contact the system administrator at local 124 for assistance.');
      }
    }
  })
})
//CHECKBOXALL
$('.checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value});
      if(selected.length > 1)
      { 
        $('#btnAllReceive').attr('disabled', false);
        //$('#btnCreate').attr('disabled', false);
      }
      else
      {
        $('#btnAllReceive').attr('disabled', true);
        //$('#btnCreate').attr('disabled', true);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#btnAllReceive').attr('disabled', true);
      //$('#btnCreate').attr('disabled', true);
    })
  }
});

//check list
$('.checklist').change(function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
    $('#btnAllReceive').attr('disabled', false);
    //$('#btnCreate').attr('disabled', false);
  }
  else
  {
    $('#btnAllReceive').attr('disabled', true);
    //$('#btnCreate').attr('disabled', true);
  }
})
</script>