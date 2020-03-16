<!-- search box in drop down menu -->
<script>
$(document).ready(function () {
  $('#submitted-table').DataTable(); // ID From dataTable 
})

//select2 js
$(".select2").select2();

//toast
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
})

</script>