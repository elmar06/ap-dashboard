<script>
$(document).ready(function(){
  $('.DataTable').DataTable({
    scrollX: true
  });
  $(".sidebar").toggleClass("toggled");
  $('#pills-received').hide();
  $('#pills-returned').hide();
  $('#pills-release-btn').addClass('active');
})
//toast function
function showToast(){
  var title = 'Loading...';
  var duration = 500;
  $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
}
function hideLoading(){
  $.Toast.hideToast();
}

//view details
$(document).on('dblclick', '#submitted-table tr', function(){
    var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();

    //check the status of a po
    $.ajax({
      type: 'POST',
      url: '../../controls/check_po_stat.php',
      data: {id:id},
      success: function(response)
      {
        if(response == 1 || response == 2)
        {
          //show the edit modal
          $.ajax({
            type: 'POST',
            url: '../../controls/view_po_details_byID.php',
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
        }
        else
        {
          //show the view only modal
          $.ajax({
            type: 'POST',
            url: '../../controls/view_po_details_byID.php',
            data: {id:id},
            beforeSend: function()
            {
              showToast();
            },
            success: function(html)
            {
              $('#viewDetails').modal('show');
              $('#view-body').html(html);
            }
          })
        }
      }
    })
})

//buttons event handler
//RELEASE
$(document).on('click', '#pills-release-btn', function(e){
  e.preventDefault();

  $('#pills-released').show();
  $('#pills-received').hide();
  $('#pills-returned').hide();
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
  //set active button
  $(this).addClass('active');
  $('#pills-received-btn').removeClass('active');
  $('#pills-release-btn').removeClass('active');
})
</script>