<script>
$(document).ready(function () {
    $('#releasing-table').DataTable();
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

//release all checked
function released_all()
{
  var id = []
  $('input:checkbox[name=checklist]:checked').each(function() { //itemid
    id.push($(this).val())
  })

  if(id.length != 0)
  {
    $.each(id, function(key, value){
      $.ajax({
        type: 'POST',
        url: '../../controls/mark_released.php',
        data: {id:value},
        success: function(html)
        {
          $('#released-body').html(html);
        }
      })
    })
  }
}

//mark release per po
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
$(document).on('dblclick', '#releasing-table tr', function(){
  var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();

  $.ajax({
    type: 'POST',
    url: '../../controls/view_po_for_release.php',
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
})

//submit and mark request released
function submit()
{
  var id = $('#po-id').val();
  var or_num = $('#or-num').val();
  var myData = 'id=' + id + '&or_num=' + or_num;

  if(or_num != '')
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/mark_released.php',
      data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(response)
      {
        if(response != 0)
        {
          //get the latest list
          $.ajax({
            url: '../../controls/view_all_for_releasing.php',
            success: function(html)
            {
              $('#success').html('<center><i class="fas fa-check"></i> PO/JO is successfully marked as Release.</center>');
                $('#success').show();
                setTimeout(function(){
                  $('#success').fadeOut();
                }, 1500)
              $('#released-body').fadeOut();
              $('#released-body').fadeIn();
              $('#released-body').html(html);
            }
          })
        }else{
          $('#warning').html('<center><i class="fas fa-ban"></i> Submit Failed! Please contact the system administrator at local 124 for assistance.</center>');
          $('#warning').show();
          setTimeout(function(){
            $('#warning').fadeOut();
          }, 3000)
        }
      }
    })
  }else{
    $('#warning').html('<center><i class="fas fa-ban"></i> Please input OR/CR Number.</center>');
    $('#warning').show();
    setTimeout(function(){
      $('#warning').fadeOut();
    }, 2000)
  }
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