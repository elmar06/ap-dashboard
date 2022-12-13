<script>
//datepicker
$('.datepicker').datepicker({
  clearBtn: true,
  format: "MM dd, yyyy",
  setDate: new Date(),
  autoClose: true
});
//select 2
$('.select2').select2();

//toast
function showToast(){
  var title = 'Loading...';
  var duration = 500;
  $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
}
function hideLoading(){
  $.Toast.hideToast();
}

//generate report function
function generate_report()
{
  var project = $('#project').val();
  var company = $('#company').val();
  var supplier = $('#supplier').val();
  var status = $('#status').val();
  var date_from = $('#from').val();
  var date_to = $('#to').val();
  var myData = 'project=' + project + '&company=' + company + '&supplier=' + supplier + '&status=' + status + '&date_from=' + date_from + '&date_to=' + date_to;

  if(date_from != '' && date_to != ''){
    showToast();
    window.open('../../controls/generate_report_scm.php?' + myData);
  }else{
    toastr.error('ERROR! Please select a date span to generate report.');
    $('#from').focus();
  }
}

//event handler
//project
$('#project').on('change', function(){
  $('#company').attr('disabled', true);
  $('#supplier').attr('disabled', true);
  $('#status').attr('disabled', true);
})
//Company
$('#company').on('change', function(){
  $('#project').attr('disabled', true);
  $('#supplier').attr('disabled', true);
  $('#status').attr('disabled', true);
})
//Supplier
$('#supplier').on('change', function(){
  $('#company').attr('disabled', true);
  $('#project').attr('disabled', true);
  $('#status').attr('disabled', true);
})
//Status
$('#status').on('change', function(){
  $('#company').attr('disabled', true);
  $('#supplier').attr('disabled', true);
  $('#project').attr('disabled', true);
})
//clear or reset the dropdown box
$(document).ready(function(){
  $('.remove-data').on('click', function(e){
    e.preventDefault();

    $('#project').append('<option selected disabled>Select a Project</option>');
    $('#company').append('<option selected disabled>Select a Company</option>');
    $('#supplier').append('<option selected disabled>Select a Supplier</option>');
    $('#status').append('<option selected disabled>Select a Status</option>');
    //enable fields
    $('#project').attr('disabled', false);
    $('#company').attr('disabled', false);
    $('#supplier').attr('disabled', false);
    $('#status').attr('disabled', false);
  })
})
</script>