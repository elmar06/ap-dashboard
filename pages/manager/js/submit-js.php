<script>
$(document).ready(function(){
  $('#req-table').DataTable({
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

$('.btnAdd').on('click', function(e){
  e.preventDefault();

  var id = $(this).val();
  
  $.ajax({
    type: 'POST',
    url: '../../controls/get_check_details.php',
    data: {id:id},
    success: function(html)
    {
      $('#AddORModal').modal('show');
      $('#release-body').html(html);
    }
  })
})
//submit/save OR Number
function submit_OR()
{
  var id = $('#po-id').val();
  var or_num = $('#or-num').val();
  var myData = 'id=' + id + '&or_num=' + or_num;

  if(or_num != '' || or_num != null){
    $.ajax({
      type: 'POST',
      url: '../../controls/upd_or_num.php',
      data: myData,
      success: function(response)
      {
        if(response > 0)
        {
          //get the latest list
          $.ajax({
            url: '../../controls/view_all_released.php',
            success: function(html)
            {
              $('#success').html('<center><i class="fas fa-check"></i> OR/CR successfully added.</center>');
                $('#success').show();
                setTimeout(function(){
                  $('#success').fadeOut();
                }, 1500)
              $('#released-body').fadeOut();
              $('#released-body').fadeIn();
              $('#released-body').html(html);
            }
          })
        }
        else
        {
          $('#warning').html('<center><i class="fas fa-ban"></i> Submit Failed! Please contact the system administrator at local 124 for assistance.</center>');
          $('#warning').show();
          setTimeout(function(){
            $('#warning').fadeOut();
          }, 3000)
        }
      }
    })
  }else{
    $('#warning').html('<center><i class="fas fa-ban"></i> Submit Failed! Please input OR/CR No.</center>');
    $('#warning').show();
    setTimeout(function(){
      $('#warning').fadeOut();
    }, 3000)
  }
}
</script>