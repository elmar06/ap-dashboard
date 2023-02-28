<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';
include '../objects/clsProject.php';

$database = new clsConnection();
$db = $database->connect();

$supplier = new Supplier($db);
$company = new Company($db);
$po = new PO_Details($db);
$project = new Project($db);

echo '<div id="btnDiv">
        <a type="button" class="btn btn-success mb-1" href="#" onclick="forward_all()"><i class="fas fa-arrow-alt-circle-right"></i> Forward to Compliance</a>
      </div><br>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table1-responsive p-3">
                    <table class="table1 align-items-center table-flush table-hover DataTable">
                    <thead class="thead-light">
                        <tr>
                        <th style="max-width: 2%"><input type="checkbox" class="checkboxall"/><span class="checkmark"></span></th>
                        <th><center>OR #</center></th>
                        <th>Project</th>
                        <th>SI #</th>
                        <th>Check No</th>
                        <th>Company</th>
                        <th>PO/JO No</th>
                        <th>Payee</th>
                        <th>Amount</th>
                        <th><center>Date Released</center></th>
                        </tr>
                    </thead>
                        <tbody id="released-body">';
                            $po->submitted_by = $_SESSION['id'];
                            $view = $po->get_released_fo();
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
                            $proj_name = '';
                            //get the PROJECT name if exist
                            $project->id = $row['proj-id'];
                            $get1 = $project->get_proj_details();
                            while($rowProj = $get1->fetch(PDO::FETCH_ASSOC))
                            {
                                if($row['proj-id'] == $rowProj['id']){
                                $proj_name = $rowProj['project'];
                                }else{
                                $proj_name = '-';
                                }
                            }
                            //date format
                            $release = date('m/d/Y', strtotime($row['date_release']));
                            $amount = number_format($row['cv_amount'], 2);
                            //initialize action button
                            $action = '<button class="btn btn-success btn-sm btnForward" value="'.$row['po-id'].'"><i class="fas fa-plus-circle"></i> Forward to Compliance</button>';
                            if($row['or_num'] == '' || $row['or_num'] == null){
                                $or_num = '-';
                            }else{
                                $or_num = $row['or_num'];
                            }
                            echo '
                            <tr>
                                <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
                                <td><center>'.$or_num.'</center></td>
                                <td>'.$proj_name.'</td>
                                <td>'.$row['si_num'].'</td>                          
                                <td>'.$row['check_no'].'</td>
                                <td>'.$comp_name.'</td>
                                <td>'.$row['po_num'].'</td>
                                <td style="width: 150px">'.$sup_name.'</td>
                                <td>'.$amount.'</td>
                                <td><center>'.$release.'</center></td>
                            </tr>';
                            }
                        echo '</tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>';
?>
<script>
$(document).ready(function(){
  $('.DataTable').DataTable({
    scrollX: true
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
//Mark multi request as receive
function forward_all()
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
        url: '../../controls/mark_forward_compliance.php',
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
        url: '../../controls/get_list_for_compliance.php',
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
</script>
