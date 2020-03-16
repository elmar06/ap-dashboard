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

//acknowledge request
$('.edit').click(function(e){
  e.preventDefault();

  var id = $(this).attr('value');

  $.ajax({
    type: 'POST',
    url: '../../controls/view_process_byID.php',
    data: {id:id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#POmodalDetails').modal('show');
      $('#details-body').html(html);
      $('#cv-number').focus();
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})

//view details
$(document).on('dblclick', '#req-table tr', function(){
  var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();
  
  $.ajax({
    type: 'POST',
    url: '../../controls/view_process_byID.php',
    data: {id:id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#POmodalDetails').modal('show');
      $('#details-body').html(html);
      $('#cv-number').focus();
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})

function submitForSignature()
{
  var id = $('#upd-id').val();
  var cv_no = $('#cv-no').val();
  var bank = $('#bank').val();
  var check_no = $('#check-no').val();
  var checkdate = $('#checkdate').val();
  var myData = 'id=' + id + '&cv_no=' + cv_no + '&bank=' + bank + '&check_no=' + check_no + '&checkdate=' + checkdate;

  if(cv_no != '' && bank != '' && check_no != '' && checkdate != null)
  {
    $.ajax({
    type: 'POST',
    url: '../../controls/mark_for_signature.php',
    data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(response)
      {
        if(response > 0)
        {
          //display the new list
          $.ajax({
            type: 'POST',
            url: '../../controls/view_all_process_po.php',
            success: function(html)
            {
              $('#upd-success').html('<center><i class="fas fa-check"></i> PO/JO is ready Signature.</center>');
              $('#upd-success').show();
              setTimeout(function(){
                $('#upd-success').fadeOut();
              }, 3000)
              $('#req-body').fadeOut();
              $('#req-body').fadeIn();
              $('#req-body').html(html);
            }
          })
        }
        else
        {
          $('#upd-warning').html('<center><i class="fas fa-ban"></i> Submit Failed! Please contact the system administrator at local 124 for assistance.</center>');
          $('#upd-warning').show();
          setTimeout(function(){
            $('#upd-warning').fadeOut();
          }, 3000)
        }
      }
    })
  }else{
    $('#upd-warning').html('<center><i class="fas fa-ban"></i> Submit Failed! Please fill out all the check details needed.</center>');
    $('#upd-warning').show();
    setTimeout(function(){
      $('#upd-warning').fadeOut();
    }, 3000)
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
        $('#btnProcessAll').show();
      }
      else
      {
        $('#btnProcessAll').show();
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

      $('#btnProcessAll').show();
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
    $('#btnProcessAll').show();
  }
  else
  {
    $('#btnProcessAll').show();
  }
})
</script>