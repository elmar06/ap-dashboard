<script>
$(document).ready(function () {
  $('#process-table').DataTable();// ID From dataTable with Hover
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

//submit or apply function
$('.apply').on('click', function(e){
  e.preventDefault();
  var id = $(this).val();
  var action =$(this).closest('tr').find('.action').val();

  //update date_to_ea in po_other_details(MARK AS SENT TO EA)
  if(action == 1)
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/mark_sent_to_ea.php',
      data: {id:id},
      success: function(html)
      {
        alert(html);
        toastr.success('Request successfully mark as forwarded to EA Team.');
        $('#process-body').html(html);
      }
    })
  }
  //update date_from_ea in po_other_details(MARK AS RETURNED FROM EA)
  if(action == 2)
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/mark_return_from_ea.php',
      data: {id:id},
      success: function(html)
      {
        toastr.success('Request successfully mark as Returned from EA Team.');
        $('#process-body').html(html);
      }
    })
  }
})

function apply()
{
  var action = $('#action').val();
  
  if(action != null)
  {
    if(action == 1)
    {
      sent_all_to_ea();
    }else{
      received_all_from_ea();
    }
  }else{
    toastr.error('Please select bulk action to proceed.');
  }
}

//bulk action(sent to EA all checked request)
function sent_all_to_ea()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() {
    id.push($(this).val())
  });

  if(id.length > 0){
    $.each(id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_sent_to_ea.php',
        data: {id: value},
        success: function(html)
        {
          toastr.success('Request successfully mark as forwarded to EA Team.');
          $('#process-body').html(html);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  }
}

//bulk action(received all checks from EA)
function received_all_from_ea()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() {
    id.push($(this).val())
  });

  if(id.length > 0){
    $.each(id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_return_from_ea.php',
        data: {id: value},
        success: function(html)
        {
          toastr.success('Request successfully mark as Returned from EA Team.');
          $('#process-body').html(html);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  }
}

function cancel_bulk()
{
  $('#bulk-action').fadeOut();
  $('.action').attr('disabled', false);
  $('.apply').attr('disabled', false);
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