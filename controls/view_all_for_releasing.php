<?php
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

$view = $po->get_for_releasing_fo();
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
   //date format
   $bill_date = date('m/d/Y', strtotime($row['bill_date']));
   echo '
   <tr>
     <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['po-id'].'"></td>
     <td>'.$comp_name.'</td>
     <td>'.$row['po_num'].'</td>
     <td style="width: 180px">'.$sup_name.'</td>
     <td>'.$bill_date.'</td>
     <td>'.$row['fullname'].'</td>
     <td>
     <center>
       <button class="btn btn-success btn-sm btnRelease" value="'.$row['po-id'].'"><i class="fas fa-check-circle"></i> Released</button>
     </center></td>
   </tr>';
}
?>
<script>
//mark release per po
$('.btnRelease').on('click', function(e){
  e.preventDefault();

  var id = $(this).val();
  
    $.ajax({
      type: 'POST',
      url: '../../controls/get_check_details.php',
      data: {id:id},
      success: function(html)
      {
        $('#ReleasingDetails').modal('show');
        $('#release-body').html(html);
      }
    })
})

//view details
$(document).on('dblclick', '#releasing-table tr', function(){
  var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();

  $.ajax({
    type: 'POST',
    url: '../../controls/view_po_for_release.php',
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

//submit and mark request released
function submit()
{
  var id = $('#po-id').val();
  var or_num = $('#or-num').val();
  var receipt = $('#receipt-no').val();
  var myData = 'id=' + id + '&or_num=' + or_num + '&receipt=' + receipt;

  $.ajax({
    type: 'POST',
    url: '../../controls/mark_released.php',
    data: myData,
    beforeSend: function()
    {
      showToast();
    },
    success: function(response)
    {
      if(response != 0)
      {
        //get the latest list
        $.ajax({
          url: '../../controls/view_all_for_releasing.php',
          success: function(html)
          {
            $('#success').html('<center><i class="fas fa-check"></i> PO/JO is successfully marked as Release.</center>');
              $('#success').show();
              setTimeout(function(){
                $('#success').fadeOut();
              }, 1500)
            $('#released-body').fadeOut();
            $('#released-body').fadeIn();
            $('#released-body').html(html);
          }
        })
      }else{
        $('#warning').html('<center><i class="fas fa-ban"></i> Submit Failed! Please contact the system administrator at local 124 for assistance.</center>');
        $('#warning').show();
        setTimeout(function(){
          $('#warning').fadeOut();
        }, 3000)
      }
    }
  })
  // }else{
  //   $('#warning').html('<center><i class="fas fa-ban"></i> Please input OR/CR Number.</center>');
  //   $('#warning').show();
  //   setTimeout(function(){
  //     $('#warning').fadeOut();
  //   }, 2000)
  // }
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
        $('#btnAllRelease').attr('disabled', false);
      }
      else
      {
        $('#btnAllRelease').attr('disabled', true);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#btnAllRelease').attr('disabled', true);
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
    $('#btnAllRelease').attr('disabled', false);
  }
  else
  {
    $('#btnAllRelease').attr('disabled', true);
  }
})
</script>