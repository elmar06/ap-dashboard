<script>
$(document).ready(function () {
  $('#releasing-table').DataTable({
    scrollX: true
  });
  //datepicker
  $('.datepicker').datepicker({
    clearBtn: true,
    format: "MM dd, yyyy",
    setDate: new Date(),
    autoClose: true
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

//RELEASED BUTTON EVENT HANDLER
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
// $(document).on('dblclick', '#releasing-table tr', function(){
//   var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();

//   $.ajax({
//     type: 'POST',
//     url: '../../controls/view_po_for_release.php',
//     data: {id:id},
//     beforeSend: function()
//     {
//       showToast();
//     },
//     success: function(html)
//     {
//       $('#POmodalDetails').modal('show');
//       $('#details-body').html(html);
//     },
//     error: function(xhr, ajaxOptions, thrownError)
//     {
//       alert(thrownError);
//     }
//   })
// })

//submit and mark request released
function submit()
{
  var id = $('#po-id').val();
  //var array = JSON.parse ("["+id+"]");
  var or_num = $('#or-num').val();
  var receipt = $('#receipt-no').val();
  var release_date = $('#release-date').val();

  $.ajax({
    type: 'POST',
    url: '../../controls/mark_released.php',
    data: {id: id, or_num: or_num, receipt: receipt, release_date: release_date},
    success: function(response)
    {
      if(response > 0)
      {
        showToast();
        toastr.success('PO/JO successfully marked as Released.');
          //set time out to refresh
          setTimeout(function(){
            location.reload();
          }, 1000)
      }else{
        toastr.error('ERORR! Please contact the system administrator for assistance at local 124.');
      }
    },
    error: function(xhr, ajaxOption, thrownError)
    {
      alert(thrownError);
    }
  })

  // if(array.length > 0)
  // {
  //   $.each(array, function( key, value ) {
      
  //   })
    
  // }
  // else
  // {
  //   toastr.error('ERROR! Please select a request to release.')
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