<script>
$(document).ready(function () {
  $('#process-table').DataTable({
    scrollX: true
  });// ID From dataTable with Hover
  $(".sidebar").toggleClass("toggled");
  $('.select2').select2();
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

//create new cv for the cancelled check
$('.create').on('click', function(e){
  e.preventDefault();
  
  var id = $(this).val();

  $.ajax({
    type: 'POST',
    url: '../../controls/view_for_cancel.php',
    data: {id: id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#cancelModal').modal('show');
      $('#details-body').html(html);
    }
  })
})

//submit cancellation function
function submit_cancellation()
{
  var id = $('#po-id').val();
  //old data
  var old_cv_no = $('#old-cv-no').val();
  var old_check_no = $('#old-check-no').val();
  var old_bank = $('#old-bank').val();
  var old_check_date = $('#old-checkdate').val();
  //new data
  var new_cv_no = $('#new-cv-no').val();
  var new_check_no = $('#new-check-no').val();
  var new_bank = $('#new-bank').val();
  var new_check_date = $('#new-checkdate').val();
  var tax = $('#cv-tax').val();
  var cv_amount = $('#cv-amount').val();
  var myData = 'id=' + id + '&old_cv_no=' + old_check_no + '&old_check_no=' + old_check_no + '&old_bank=' + old_bank + '&old_check_date=' + old_check_date + '&new_cv_no=' + new_cv_no + '&new_check_no=' + new_check_no + '&new_bank=' + new_bank + '&new_check_date=' + new_check_date + '&tax=' + tax + '&cv_amount=' + cv_amount;

  if(new_cv_no != null && new_check_no != null && new_bank != null && new_check_date != null && tax != null && cv_amount != null)
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/cancel_check.php',
      data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(html)
      {
        if(html != 0)
        {
          toastr.success('<center>Cancellation of check successfully process.</center>');
          $('#process-body').fadeOut();
          $('#process-body').fadeIn();
          $('#process-body').html(html);
        }else{
          toastr.error('<center>ERROR! Please contact the system administrator at local 124 for assistance.</center>');
        }
      }
    })
  }else{
    toastr.error('<center>ERROR! Please fill out all the data needed to proceed.</center>');
  }
}

//Checkbox All
$('.checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value});
      if(selected.length > 1)
      { 
        $('#bulk-action').fadeIn();
        $('.action').attr('disabled', true);
        $('.apply').attr('disabled', true);
      }
      else
      {
        $('#bulk-action').fadeOut();
        $('.action').attr('disabled', false);
        $('.apply').attr('disabled', false);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#bulk-action').fadeOut();
      $('.action').attr('disabled', false);
      $('.apply').attr('disabled', false);
    })
  }
});

//check list
$('.checklist').change(function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
    $('#bulk-action').fadeIn();
    $('.action').attr('disabled', true);
    $('.apply').attr('disabled', true);
  }
  else
  {
    $('#bulk-action').fadeOut();
    $('.action').attr('disabled', false);
    $('.apply').attr('disabled', false);
  }
})
</script>