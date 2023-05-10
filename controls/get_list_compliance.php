<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCompany.php';
include '../objects/clsSupplier.php';
include '../objects/clsProject.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$supplier = new Supplier($db);
$project = new Project($db);

echo '<div class="row mb-3">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">For Receiving</div>';
                            $po->submitted_by = $_SESSION['id'];
                            $count = $po->count_for_receive_comp();
                            if($row = $count->fetch(PDO::FETCH_ASSOC))
                            {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                            }else{
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                            }
                    echo '<div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#" onclick="get_for_receiving()"><i class="fas fa-arrow-up"></i> More Details</a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding fa-2x text-info"></i>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Returned</div>';
                        $po->submitted_by = $_SESSION['id'];
                        $count = $po->count_returned_comp();
                        if($row = $count->fetch(PDO::FETCH_ASSOC))
                        {
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                        }else{
                        echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                        }
                    echo '<div class="mt-2 mb-0 text-muted text-xs">
                        <a class="text-success mr-2" href="#" onclick="get_returned()"><i class="fas fa-arrow-up"></i> More Details</a>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-undo-alt fa-2x text-danger"></i>
                </div>
            </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-uppercase mb-1">Received</div>';
                    $po->submitted_by = $_SESSION['id'];
                    $count = $po->count_received_comp();
                    if($row = $count->fetch(PDO::FETCH_ASSOC))
                    {
                      echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['count'].'</div>';
                    }else{
                      echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                    }
                  echo '<div class="mt-2 mb-0 text-muted text-xs">
                    <a class="text-success mr-2" href="received.php"><i class="fas fa-arrow-up"></i> More Details</a>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-check-double fa-2x text-success"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="btnDiv" style="display: none;">
        <a type="button" class="btn btn-success mb-1" href="#" onclick="mark_all_received()"><i class="fas fa-check-square"></i> Mark All Received</a>
        <a type="button" class="btn btn-danger mb-1" href="#" onclick="mark_all_return()"><i class="fas fa-undo-alt"></i> Mark All for Returned</a>
      </div><br>
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover DataTable">
                        <thead class="thead-light">
                        <tr>
                            <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                            <th><center>Action</center></th>
                            <th>Released Date</th>
                            <th>CV #</th>
                            <th>Check #</th>
                            <th>CV Amount</th>
                            <th>Company</th>
                            <th>PO/JO #</th>
                            <th>Suppplier</th>
                            <th>Due Date</th>
                            <th>Project</th>
                        </tr>
                        </thead>
                        <tbody id="req-body">';
                            $view = $po->get_list_compliance();
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
                            $proj_name = '';
                            //get the PROJECT name if exist
                            $project->id = $row['proj-id'];
                            $get1 = $project->get_proj_details();
                            while($rowProj = $get1->fetch(PDO::FETCH_ASSOC))
                            {
                                if($row['proj-id'] == $rowProj['id']){
                                $proj_name = $rowProj['project'];
                                }
                            }
                            //date format
                            $date_release = date('m/d/Y', strtotime($row['date_release']));                              
                            $due = date('m/d/Y', strtotime($row['due_date']));                              
                            $action = '<button class="btn-sm btn-success received" value="'.$row['po-id'].'"><i class="fas fa-check"></i></button>
                            <button class="btn-sm btn-danger return" value="'.$row['po-id'].'"><i class="fas fa-times-circle"></i></button>';
                            echo '
                            <tr>
                                <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                                <td>'.$action.'</td>
                                <td>'.$date_release.'</td>
                                <td>'.$row['cv_no'].'</td>
                                <td>'.$row['check_no'].'</td>
                                <td>'.number_format(floatval($row['cv_amount']), 2).'</td>
                                <td>'.$comp_name.'</td>
                                <td>'.$row['po_num'].'</td>
                                <td style="width: 180px">'.$sup_name.'</td>
                                <td>'.$due.'</td>
                                <td>'.$proj_name.'</td>
                            </tr>';
                            }
                        // //get the user company access
                        // $access->user_id = $user_id;
                        // $get = $access->get_company();
                        // while($row1 = $get->fetch(PDO::FETCH_ASSOC))
                        // {
                        //   //get the access company id
                        //   $id = $row1['comp-access'];
                        //   $array_id = explode(',', $id);
                        //   foreach($array_id as $value)
                        //   {
                        //     $comp_id =  $value; 
                        //     //display all the data by access
                        //     $po->company = $comp_id;
                            
                        //   }
                        // }
                        echo '</tbody>
                    </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>';
?>
<script>
// $(document).ready(function(){
//     $('.DataTable').dataTable({
//         scrollX: true
//     })
// })
//toast
function showToast(){
  var title = 'Loading...';
  var duration = 500;
  $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
}
function hideLoading(){
  $.Toast.hideToast();
}
//mark as received by Compliance
$('.received').on('click', function(e){
    e.preventDefault();

    var id = $(this).val();
    
    $.ajax({
        type: 'POST',
        url: '../../controls/mark_received_compliance.php',
        data: {id: id},
        beforeSend: function()
        {
            showToast();
        },
        success: function(response)
        {
            if(response > 0){
                //get the new list
                toastr.success('Request successfully mark as Received.');
                $.ajax({
                    url: '../../controls/get_list_compliance.php',
                    success: function(html)
                    {
                        $('#page-body').fadeOut();
                        $('#page-body').fadeIn();
                        $('#page-body').html(html);
                    }
                })
            }else{
                toastr.error('Receiving Failed! Please contact the system administrator at local 124 for assistance');
            }
        }
    })
})
//mark RETURNED 
$('.return').on('click', function(e){
    e.preventDefault();

    var id = $(this).val();
    
    $.ajax({
        type: 'POST',
        url: '../../controls/mark_return_compliance.php',
        data: {id: id},
        beforeSend: function()
        {
            showToast();
        },
        success: function(response)
        {
          if(response > 0){
              //get the new list
              toastr.success('Request successfully mark as Received.');
              $.ajax({
                  url: '../../controls/get_list_compliance.php',
                  success: function(html)
                  {
                      $('#page-body').fadeOut();
                      $('#page-body').fadeIn();
                      $('#page-body').html(html);
                  }
              })
          }else{
              toastr.error('Receiving Failed! Please contact the system administrator at local 124 for assistance');
          }
        }
    })
})
//Mark multi request as receive
function mark_all_received()
{
    var id = []
    $('input:checkbox[name=checklist]:checked').each(function() {
        id.push($(this).val())
    });

    if(id.length > 0){
        //var result = 0;
        $.each( id, function( key, value ) {
            $.ajax({
                type: 'POST',
                url: '../../controls/mark_received_compliance.php',
                data: {id:value},
                async: false,
                dataType: 'html',
                beforeSend: function()
                {
                    showToast();
                },
                success: function(response)
                {
                    result = response;
                },
                error: function(xhr, ajaxOption, thrownError)
                {
                    alert(thrownError);
                }
            })
        })
        //check if process is successful
        if(result > 0)
        {
            toastr.success('Request successfully mark as Received.');
            //display the new list
            $.ajax({
                url: '../../controls/get_list_compliance.php',
                success: function(html)
                {
                $('#page-body').fadeOut();
                $('#page-body').fadeIn();
                $('#page-body').html(html);
                }
            })
        }
        else
        {
            toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
        } 
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  } 
}
//Mark multi request as returned
function mark_all_returned()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() {
    id.push($(this).val())
  });

  if(id.length > 0){
    $.each( id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_return_compliance.php',
        data: {id:value},
        async: false,
        dataType: 'html',
        success: function(response)
        {
            result = response;
        },
        error: function(xhr, ajaxOption, thrownError)
        {
          alert(thrownError);
        }
      })
    })
    //check if process is successful
    if(result > 0)
    {
        toastr.success('Request successfully mark as Returned to AP Team.');
        //display the new list
        $.ajax({
            url: '../../controls/get_list_compliance.php',
            success: function(html)
            {
            $('#page-body').fadeOut();
            $('#page-body').fadeIn();
            $('#page-body').html(html);
            }
        })
    }
    else
    {
        toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
    } 
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  } 
}
//CHECKBOXALL
$('.checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value});
      if(selected.length > 1)
      { 
        $('#btnDiv').fadeIn();
        //disable the 2 buttons 
        $('.received').attr('disabled', true);
        $('.return').attr('disabled', true);
      }
      else
      {
        $('#btnDiv').fadeOut();
        //enable 2 buttons
        $('.received').attr('disabled', false);
        $('.return').attr('disabled', false);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#btnDiv').fadeOut();
    })
  }
})
//checklist 
$('.checklist').change(function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
    $('#btnDiv').fadeIn();
    //disable the 2 buttons 
    $('.received').attr('disabled', true);
    $('.return').attr('disabled', true);
  }
  else
  {
    $('#btnDiv').fadeOut();
    //enable 2 buttons
    $('.received').attr('disabled', false);
    $('.return').attr('disabled', false);
  }
})
//check if logcount is zero
$(document).ready(function(){
  
  var id = $('#user-id').val();
  var logcount = $('#logcount').val();

  if(logcount == 0){
    $.ajax({
      type: 'POST',
      url: '../../controls/get_user_data.php',
      data: {id: id},
      success: function(html)
      {
        $('#changePassModal').modal({backdrop: 'static', keyboard: false});
        $('#pass-body').html(html);
      }
    })
  }
})
//save new password
function changePassword()
{
  var id = $('#pass-id').val();
  var password = $('#password').val();
  var myData = 'id=' + id + '&password=' + password;

  if(password != '')
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/change_password.php',
      data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(response)
      {
        if(response > 0)
        {
          $('#changePassModal').modal('hide');
          $('#noticeModal').modal({backdrop: 'static', keyboard: false});
        }else{
          $('#pass-warning').html('<center><i class="fas fa-ban"></i> Update Failed. Please contact the system administrator at local 124 for assistance.</center>');
          $('#pass-warning').show();
          setTimeout(function(){
            $('#pass-warning').fadeOut();
          }, 3000)
        }
      }
    })
  }else{
    $('#pass-warning').html('<center><i class="fas fa-ban"></i> Update Failed. Please fill out the data needed.</center>');
    $('#pass-warning').show();
    setTimeout(function(){
      $('#pass-warning').fadeOut();
    }, 3000)
  }
}

//change password later
function changePassLater()
{
  var id = $('#pass-id').val();

  $.ajax({
    type: 'POST',
    url: '../../controls/change_pass_later.php',
    data: {id: id},

    beforeSend: function()
    {
      showToast();
    },
    success: function(response)
    {
      if(response > 0)
        {
          $('#changePassModal').modal('hide');
        }else{
          $('#pass-warning').html('<center><i class="fas fa-ban"></i> ERROR! Please contact the system administrator at local 124 for assistance.</center>');
          $('#pass-warning').show();
          setTimeout(function(){
            $('#pass-warning').fadeOut();
          }, 3000)
        }
    }
  })
}
</script>