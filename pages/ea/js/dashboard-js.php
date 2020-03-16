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
//mark signed
function mark_signed()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() {
    id.push($(this).val())
  });

  if(id.length > 0){
    $.each( id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_as_signed.php',
        data: {id:value},
        success: function(response)
        {
          if(response > 0)
          {
            //display the new list
            $.ajax({
              url: '../../controls/get_list_ea.php',
              success: function(html)
              {
                toastr.success('Request successfully mark as signed.');
                $('#req-body').fadeOut();
                $('#req-body').fadeIn();
                $('#req-body').html(html);
              }
            })
          }else{
            toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
          }
        },
        error: function(xhr, ajaxOption, thrownError)
        {
          alert(thrownError);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  } 
}
//mark returned to EA
function mark_returned()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() {
    id.push($(this).val())
  });

  if(id.length > 0){
    $.each( id, function( key, value ) {
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_return_to_ap.php',
        data: {id:value},
        success: function(response)
        {
          if(response > 0)
          {
            toastr.success('Request successfully mark as Returned to AP Team.');
            //display the new list
            $.ajax({
              url: '../../controls/get_list_ea.php',
              success: function(html)
              {
                $('#req-body').fadeOut();
                $('#req-body').fadeIn();
                $('#req-body').html(html);
              }
            })
          }else{
            toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
          }
        },
        error: function(xhr, ajaxOption, thrownError)
        {
          alert(thrownError);
        }
      })
    })
  }else{
    toastr.error('<center>ERROR! Please select a request to process.</center>');
  } 
}

//get all req for signature
function get_for_signature()
{
  var status = 5;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_stat_list_ea.php',
    data: {status: status},
    beforeSend: function(){
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

//get all signed request
function get_signed()
{
  var status = 6;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_stat_list_ea.php',
    data: {status: status},
    beforeSend: function(){
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

//get all returned request to AP
function get_return_to_ap()
{
  var status = 7;
  $.ajax({
    type: 'POST',
    url: '../../controls/get_stat_list_ea.php',
    data: {status: status},
    beforeSend: function(){
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
        $('#btnSigned').attr('disabled', false);
        $('#btnReturn').attr('disabled', false);
      }
      else
      {
        $('#btnSigned').attr('disabled', false);
        $('#btnReturn').attr('disabled', false);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#btnSigned').attr('disabled', false);
      $('#btnReturn').attr('disabled', false);
    })
  }
})
</script>

<!-- checklist -->
<script>
$('.checklist').change(function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
    $('#btnSigned').attr('disabled', false);
    $('#btnReturn').attr('disabled', false);
  }
  else
  {
    $('#btnSigned').attr('disabled', false);
    $('#btnReturn').attr('disabled', false);
  }
})
</script>