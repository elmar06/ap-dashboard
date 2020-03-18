<!-- Page level custom scripts -->
<script>
$(document).ready(function () {
  $('#req-table').DataTable();// ID From dataTable with Hover
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
          toastr.warning('Request successfully mark as On Hold.');
          $('#req-body').html(html);
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
          toastr.success('Request is mark as For Releasing.');
          $('#req-body').html(html);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  }
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