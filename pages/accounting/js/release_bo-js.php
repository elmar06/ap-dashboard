<script>
$(document).ready(function(){
  $('.DataTable').DataTable({
    scrollX: true
  });
  $(".sidebar").toggleClass("toggled");
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
      showToast();
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