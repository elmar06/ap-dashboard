<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsAccess.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';

$database= new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$access = new Access($db);
$supplier = new Supplier($db);
$company = new Company($db);

$po->status = 10;
$po->date_on_hold = date('Y-m-d');
$po->po_id = $_POST['id'];
$po->id = $_POST['id'];

$upd = $po->mark_on_hold();

if($upd)
{
    echo '
        <div class="row mb-3">
            <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">For Verification</div>';
                        $po->submitted_by = $_SESSION['id'];
                        $count = $po->count_for_verification();
                        if($row = $count->fetch(PDO::FETCH_ASSOC))
                        {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                        }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                    echo '<div class="mt-2 mb-0 text-muted text-xs">
                    <a class="text-success mr-2" href="#" onclick="get_for_verification()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-certificate fa-2x text-info"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <!-- For Releasing Card -->
            <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">On Hold</div>';
                        $po->submitted_by = $_SESSION['id'];
                        $count = $po->count_on_hold();
                        if($row = $count->fetch(PDO::FETCH_ASSOC))
                        {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                        }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                    echo'<div class="mt-2 mb-0 text-muted text-xs">
                    <a class="text-success mr-2" href="#" onclick="get_on_hold()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-pause-circle fa-2x text-danger"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <!-- Total Submitted PO/JO Card-->
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
                    echo'<div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#" onclick="get_releasing()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <!-- Total Released PO/JO Card-->
            <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Released</div>';
                        $po->submitted_by = $_SESSION['id'];
                        $count = $po->count_released();
                        if($row = $count->fetch(PDO::FETCH_ASSOC))
                        {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['released-count'].'</div>';
                        }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                    echo'<div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="released.php"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-check-double fa-2x text-success"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div> <!-- end of card row -->
        <div>
            <a type="button" class="btn btn-primary mb-1" href="#" onclick="mark_on_hold()"><i class="fas fa-hand-paper"></i> Hold Check</a>
            <a type="button" class="btn btn-success mb-1" href="#" onclick="mark_for_releasing()"><i class="fas fa-check-square"></i> Mark as for Releasing</a>
        </div><br>
        <!-- DataTable with Hover -->
        <div class="row mb-3">
            <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="req-table">
                    <thead class="thead-light">
                    <tr>
                    <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                        <th>CV #</th>
                        <th>Check #</th>
                        <th>CV Amount</th>
                        <th>Company</th>
                        <th>PO/JO #</th>
                        <th>Suppplier</th>
                        <th><center>Status</center></th>
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
                        $view = $po->get_list_checker();
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
                            if($row['status'] == 8)
                            {
                            $status = '<label style="color: blue"><b>For Verification</b></label>';
                            }
                            elseif($row['status'] == 9)
                            {
                            $status = '<label style="color: red"><b>On Hold</b></label>';
                            }
                            else
                            {
                            $status = '<label style="color: green"><b>For Releasing</b></label>';
                            }
                            echo '
                            <tr>
                            <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                            <td>'.$row['cv_no'].'</td>
                            <td>'.$row['check_no'].'</td>
                            <td>'.number_format($row['cv_amount'], 2).'</td>
                            <td>'.$comp_name.'</td>
                            <td>'.$row['po_num'].'</td>
                            <td style="width: 180px">'.$sup_name.'</td>
                            <td style="width: 100px"><center>'.$status.'</center></td>
                            </tr>';
                        }
                        }
                    }
                    echo'</tbody>
                </table> 
                </div>
            </div>
            </div><!-- /column -->
        </div><!-- /row -->';
}else{
    echo 0;
}
?>
<script>
$(document).ready(function () {
  $('#req-table').DataTable();// ID From dataTable with Hover
})

//hold check
function mark_on_hold()
{
    var id = []
    $('input:checkbox[name=checklist]:checked').each(function() {
        id.push($(this).val())
    });

    if(id.length > 0){
    $.each(id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_on_hold.php',
        data: {id: value},
        success: function(html)
        {
          toastr.warning('Request successfully put On Hold.');
          $('#page-body').fadeOut();
          $('#page-body').fadeIn();
          $('#page-body').html(html);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  }
}

//release check
function mark_for_releasing()
{
    var id = []
    $('input:checkbox[name=checklist]:checked').each(function() {
      id.push($(this).val())
    });

    if(id.length > 0){
    $.each(id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_for_releasing.php',
        data: {id: value},
        success: function(html)
        {
          toastr.success('Request successfully mark as For Releasing.');
          $('#page-body').fadeOut();
          $('#page-body').fadeIn();
          $('#page-body').html(html);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  }
}

//get po for verification
function get_for_verification()
{
  var stat = 8;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_for_verification.php',
    data: {stat: stat},
    beforeSend: function()
    {
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

//get po on hold
function get_on_hold()
{
  var stat = 9;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_on_hold.php',
    data: {stat: stat},
    beforeSend: function()
    {
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

//get po for releasing
function get_releasing()
{
  var stat = 10;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_for_releasing.php',
    data: {stat: stat},
    beforeSend: function()
    {
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

//get po for released
function get_released()
{
  var stat = 10;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_released.php',
    data: {stat: stat},
    beforeSend: function()
    {
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
</script>

<script>
$('.checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value});
      if(selected.length > 1)
      { 
        $('#btnAllReceived').attr('disabled', false);
        $('#btnAllReleased').attr('disabled', false);
      }
      else
      {
        $('#btnAllReceived').attr('disabled', false);
        $('#btnAllReleased').attr('disabled', false);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

        $('#btnAllReceived').attr('disabled', false);
        $('#btnAllReleased').attr('disabled', false);
    })
  }
});
</script>

<!-- checklist -->
<script>
$('.checklist').change(function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
    $('#btnAllReceived').attr('disabled', false);
    $('#btnAllReleased').attr('disabled', false);
  }
  else
  {
    $('#btnAllReceived').attr('disabled', false);
    $('#btnAllReleased').attr('disabled', false);
  }
})
</script>