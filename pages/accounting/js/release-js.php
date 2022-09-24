<script>
//datatable
$('#req-table').DataTable();

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
// $(document).on('dblclick', '#req-table tr', function(){
//   var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();

//   $.ajax({
//     type: 'POST',
//     url: '../../controls/view_po_released_fo.php',
//     data: {id:id},
//     beforeSend: function()
//     {
//       showToast();
//     },
//     success: function(html)
//     {
//       $('#POmodalDetails').modal('show');
//       $('#details-body').html(html);
//     },
//     error: function(xhr, ajaxOptions, thrownError)
//     {
//       alert(thrownError);
//     }
//   })
// })
</script>