<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCompany.php';
include '../objects/clsSupplier.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$supplier = new Supplier($db);

$po->date_to_ea = date('Y-m-d');
$po->po_id = $_POST['id'];
$po->id = $_POST['id'];

$upd = $po->mark_sent_to_ea();

if($upd)
{
    echo '<div class="row mb-3">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">For Receiving</div>';
                            $count = $po->count_for_receiving_ea();
                            if($row = $count->fetch(PDO::FETCH_ASSOC))
                            {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                            }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                            }
                        echo '<div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#" onclick="get_for_signature()"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                        </div>
                        <div class="col-auto">
                        <i class="fas fa-hand-holding fa-2x text-success"></i>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <!-- FOR SIGNATURE -->
                <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">For Signature</div>';
                            $count = $po->count_for_signature();
                            if($row = $count->fetch(PDO::FETCH_ASSOC))
                            {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                            }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                            }
                        echo '<div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#" onclick="get_for_signature()"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                        </div>
                        <div class="col-auto">
                        <i class="fas fa-file-signature fa-2x text-danger"></i>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <!-- Received by Accounting Payable -->
                <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Signed</div>';
                            $count = $po->count_signed();
                            if($row = $count->fetch(PDO::FETCH_ASSOC))
                            {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                            }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                            }
                        echo '<div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#" onclick="get_signed()"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                        </div>
                        <div class="col-auto">
                        <i class="fas fa-retweet fa-2x text-warning"></i>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <!-- Received by Accounting Payable -->
                <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Return to AP Team</div>';
                            $count = $po->count_return_from_ea();
                            if($row = $count->fetch(PDO::FETCH_ASSOC))
                            {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                            }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                            }
                        echo '<div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#" onclick="get_return_to_ap()"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                        </div>
                        <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-info"></i>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div> <!-- end of card row -->
            <!-- TAB PANELS -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#receivingTab" role="presentation">For Receiving</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#receivedTab" role="presentation">Received</a>
                </li>
            </ul><br>
            <div class="tab-content tabcontent-border">
                <!-- TAB PANEL FOR RECEIVING -->
                <div class="tab-pane active" role="tabpanel" id="receivingTab">
                <div class="row mb-3">
                    <div class="col-lg-12">
                    <div>
                    <a id="btnMultiReceived" type="button" class="btn btn-success mb-1" href="#" onclick="mark_multi_received_ea()" style="display: none;"><i class="fas fa-hand-holding"></i> Mark as Received</a>
                    </div><br>
                    <div class="card mb-4">
                        <div class="table1-responsive p-3">
                        <table class="table1 align-items-center table-flush table-hover DataTable">
                            <thead class="thead-light">
                            <tr>
                                <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                                <th><center>Action</center></th>
                                <th>CV No</th>
                                <th>Check #</th>
                                <th>CV Amount</th>
                                <th>Suppplier</th>
                                <th>Company</th>
                                <th>PO/JO #</th>                                                            
                            </tr>
                            </thead>
                            <tbody>';
                            $view = $po->get_for_receiving_ea();
                            while($row = $view->fetch(PDO::FETCH_ASSOC))
                            {
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
                                //initialize action
                                $action = '<button class="btn-sm btn-success mb-1 btnReceived" type="button" value="'.$row['po-id'].'"><i class="fas fa-hand-holding"></i> Received</button>';                              
                                echo '
                                <tr>
                                <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                                <td style="width: 95px"><center>'.$action.'</center></td>
                                <td>'.$row['cv_no'].'</td>
                                <td>'.$row['check_no'].'</td>
                                <td>'.number_format(floatval($row['cv_amount']),2).'</td>
                                <td style="width: 180px">'.$sup_name.'</td>  
                                <td>'.$comp_name.'</td>
                                <td>'.$row['po_num'].'</td>                                                             
                                </tr>';
                            }
                           echo '</tbody>
                        </table> 
                        </div>
                    </div>
                    </div><!-- /column -->
                </div><!-- /row --> 
                </div>
                <!-- TAB PANEL FOR RECEIVED REQUEST -->
                <div class="tab-pane" role="tabpanel" id="receivedTab">
                <div class="row mb-3">
                    <div class="col-lg-12">
                    <div>
                    <a id="btnSigned" type="button" class="btn btn-success mb-1" href="#" onclick="mark_signed()"><i class="fas fa-check-circle"></i> Mark as Signed</a>
                    <a id="btnReturned" type="button" class="btn btn-primary mb-1" href="#" onclick="mark_returned()"><i class="fas fa-undo-alt"></i> Mark as Returned to AP</a>
                    </div><br>
                    <div class="card mb-4">
                        <div class="table1-responsive p-3">
                        <table class="table1 align-items-center table-flush table-hover DataTable">
                            <thead class="thead-light">
                            <tr>
                                <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                                <th><center>Status</center></th>
                                <th>CV No</th>
                                <th>Check #</th>
                                <th>CV Amount</th>
                                <th>Company</th>
                                <th>PO/JO #</th>
                                <th>Suppplier</th>
                            </tr>
                            </thead>
                            <tbody>';
                            $po->submitted_by = $_SESSION['id'];
                            $view = $po->get_list_for_ea();
                            while($row = $view->fetch(PDO::FETCH_ASSOC))
                            {
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
                                //format of status
                                if($row['status'] == 6)
                                {
                                $status = '<label style="color: red"><b> For Signature</b></label>';
                                }
                                else
                                {
                                $status = '<label style="color: green"><b> Signed</b></label>';
                                }
                                
                                echo '
                                <tr>
                                    <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                                    <td style="width: 95px"><center>'.$status.'</center></td>
                                    <td>'.$row['cv_no'].'</td>
                                    <td>'.$row['check_no'].'</td>
                                    <td>'.number_format(floatval($row['cv_amount']),2).'</td>
                                    <td>'.$comp_name.'</td>
                                    <td>'.$row['po_num'].'</td>
                                    <td style="width: 180px">'.$sup_name.'</td>                                
                                </tr>';
                            }
                            echo '</tbody>
                        </table> 
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>'; 
}
?>
<script>
$(document).ready(function () {
  $('.DataTable').DataTable({
    scrollX: true
  });
  //auto adjust the datatable header  
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
   $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust();
  });
})
//toast
function showToast(){
  var title = 'Loading...';
  var duration = 500;
  $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
}
function hideLoading(){
  $.Toast.hideToast();
}

//mark as received by ea
$('.btnReceived').on('click', function(e){
  e.preventDefault();

  var id = $(this).val();
  var action = 1;
  $.ajax({
    type: 'POST',
    url: '../../controls/mark_received_ea.php',
    data: {id:id},
    success: function(html)
    {
      toastr.success('Request successfully mark as Received.');
      //get the latest list
      $('#page-body').fadeOut();
      $('#page-body').fadeIn();
      $('#page-body').html(html);
    }
  })
})
//MARK RECEIVED MULTIPLE
function mark_multi_received_ea()
{
  var id = [];
  $('input:checkbox[name=checklist]:checked').each(function(){
    id.push($(this).val())
  })

  $.each(id, function(key, value){
    $.ajax({
      type: 'POST',
      url: '../../controls/mark_received_ea.php',
      data: {id:value},
      success: function(html)
      {
        toastr.success('Request successfully mark as Received.');
        $('#page-body').html(html);
      }
    })
  })
}
//mark signed
function mark_signed()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() {
    id.push($(this).val())
  });

  if(id.length > 0){
    $.each( id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_as_signed.php',
        data: {id:value},
        success: function(response)
        {
          if(response > 0)
          {
            //display the new list
            $.ajax({
              url: '../../controls/get_list_ea.php',
              success: function(html)
              {
                toastr.success('Request successfully mark as signed.');
                $('#page-body').html(html);
              }
            })
          }else{
            toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
          }
        },
        error: function(xhr, ajaxOption, thrownError)
        {
          alert(thrownError);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  } 
}
//mark returned to EA
function mark_returned()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() {
    id.push($(this).val())
  });

  if(id.length > 0){
    $.each( id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_return_to_ap.php',
        data: {id:value},
        success: function(response)
        {
          if(response > 0)
          {
            toastr.success('Request successfully mark as Returned to AP Team.');
            //display the new list
            $.ajax({
              url: '../../controls/get_list_ea.php',
              success: function(html)
              {
                $('#page-body').fadeOut();
                $('#page-body').fadeIn();
                $('#page-body').html(html);
              }
            })
          }else{
            toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
          }
        },
        error: function(xhr, ajaxOption, thrownError)
        {
          alert(thrownError);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  } 
}

//get all req for signature
function get_for_signature()
{
  var status = 6;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_stat_list_ea.php',
    data: {status: status},
    beforeSend: function(){
      showToast();
    },
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}

//get all signed request
function get_signed()
{
  var status = 7;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_stat_list_ea.php',
    data: {status: status},
    beforeSend: function(){
      showToast();
    },
    success: function(html)
    {
      $('#req-body').html(html);
    }
  })
}

//get all returned request to AP
function get_return_to_ap()
{
  var status = 8;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_stat_list_ea.php',
    data: {status: status},
    beforeSend: function(){
      showToast();
    },
    success: function(html)
    {
      $('#req-body').html(html);
    }
  })
}
</script>

<!-- CHECKBOXALL-->
<script>
$('.checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value});
      if(selected.length > 1)
      { 
        $('#btnMultiReceived').fadeIn();
      $('.btnReceived').attr('disabled', true);
      }
      else
      {
        $('#btnMultiReceived').fadeOut();
        $('.btnReceived').attr('disabled', false);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#btnMultiReceived').fadeOut();
      $('.btnReceived').attr('disabled', false);
    })
  }
})
</script>

<!-- checklist -->
<script>
$('.checklist').change(function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
    $('#btnMultiReceived').fadeIn();
    $('.btnReceived').attr('disabled', true);
  }
  else
  {
    $('#btnMultiReceived').fadeOut();
    $('.btnReceived').attr('disabled', false);
  }
})
</script>