<!-- Page level custom scripts -->
<script>
$(document).ready(function () {
  $('#req-table').DataTable(); // ID From dataTable with Hover
});

//toast
function showToast(){
  var title = 'Loading...';
  var duration = 500;
  $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
}
function hideLoading(){
  $.Toast.hideToast();
}

//get all the pending
function get_pending_po()
{  
  var status = 1;

  $.ajax({
    type: 'POST',
    url: '../../controls/get_list.php',
    data: {status: status},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}

//get all the returned po
function get_returned_po()
{
  var status = 2;
  
  $.ajax({
    type: 'POST',
    url: '../../controls/get_list.php',
    data: {status: status},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}

//get in process po
function get_process_po()
{
  var status = 3;
  
  $.ajax({
    type: 'POST',
    url: '../../controls/get_list.php',
    data: {status: status},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}

//get po for releasing
function get_releasing_po()
{
  var status = 8;
  
  $.ajax({
    type: 'POST',
    url: '../../controls/get_list.php',
    data: {status: status},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#req-body').fadeOut();
      $('#req-body').fadeIn();
      $('#req-body').html(html);
    }
  })
}
</script>