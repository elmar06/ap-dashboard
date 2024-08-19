<script>
$(document).ready(function(){
    $('.DataTable').DataTable({
        scrollX: true
    });
    $(".sidebar").toggleClass("toggled");
    $('#pills-received').hide();
    $('#pills-returned').hide();
    $('#pills-forwarded').hide();
    $('#pills-release-btn').addClass('active');
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
      setTimeout(function(){
        location.reload();
      }, 1500)
    }
    else
    {
      toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
    } 
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  } 
}

//buttons event handler
//RELEASE
$(document).on('click', '#pills-release-btn', function(e){
  e.preventDefault();

  $('#pills-released').show();
  $('#pills-received').hide();
  $('#pills-returned').hide();
  $('#pills-forwarded').hide();
  //set active button
  $(this).addClass('active');
  $('#pills-received-btn').removeClass('active');
  $('#pills-returned-btn').removeClass('active');

})
//RECEIVED
$(document).on('click', '#pills-received-btn', function(e){
  e.preventDefault();

  $('#pills-released').hide();
  $('#pills-received').show();
  $('#pills-returned').hide();
  $('#pills-forwarded').hide();
  //set active button
  $(this).addClass('active');
  $('#pills-release-btn').removeClass('active');
  $('#pills-returned-btn').removeClass('active');
})
//RETURNED
$(document).on('click', '#pills-returned-btn', function(e){
  e.preventDefault();

  $('#pills-released').hide();
  $('#pills-received').hide();
  $('#pills-returned').show();
  $('#pills-forwarded').hide();
  //set active button
  $(this).addClass('active');
  $('#pills-received-btn').removeClass('active');
  $('#pills-release-btn').removeClass('active');
})
//FORWARDED
$(document).on('click', '#pills-forwarded-btn', function(e){
  e.preventDefault();

  $('#pills-released').hide();
  $('#pills-received').hide();
  $('#pills-returned').hide();
  $('#pills-forwarded').show();
  //set active button
  $(this).addClass('active');
  $('#pills-received-btn').removeClass('active');
  $('#pills-release-btn').removeClass('active');
})
</script>