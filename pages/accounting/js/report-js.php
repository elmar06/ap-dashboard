<script>
//datepicker
$(document).ready(function(){
  $('.datepicker').datepicker({
    clearBtn: true,
    format: "MM dd, yyyy",
    setDate: new Date(),
    autoClose: true
  });
  //select 2
  $('.select2').select2();
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

//clear or reset the dropdown box
$(document).ready(function(){
  $('.remove-data').on('click', function(e){
    e.preventDefault();

    $('#fo-company').append('<option selected disabled>Select a Company</option>');
    $('#fo-supplier').append('<option selected disabled>Select a Supplier</option>');
    $('#fo-status').append('<option selected disabled>Select a Status</option>');
  })
})

//button event handler
//CHECK FOR RELEASING
$('#for-releasing').on('click', function(e){
  e.preventDefault();

  $('#check').show();
  $('#disbursement').hide();
  $('#percentage-report').hide();

})
//DISBURSEMENT REPORT
$('#report').on('click', function(e){
  e.preventDefault();

  $('#disbursement').show();
  $('#check').hide();
  $('#percentage-report').hide();

})
//PERCENTAGE REPORT
$('#percentage').on('click', function(e){
  e.preventDefault();

  $('#disbursement').hide();
  $('#check').hide();
  $('#percentage-report').show();
})

//generate report function
function for_releasing_report()
{
  var project = $('#fo-porject').val();
  var company = $('#fo-company').val();
  var supplier = $('#fo-supplier').val();
  var status = $('#fo-status').val();
  var requestor = $('#user-id').val();
  var date_from = $('#from').val();
  var date_to = $('#to').val();
  var action = 1;
  var myData = 'project=' + project + '&company=' + company + '&supplier=' + supplier + '&status=' + status + '&requestor=' + requestor + '&date_from=' + date_from + '&date_to=' + date_to + '&action=' + action;

  showToast();
  window.location = '../../controls/generate_report_fo.php?' + myData;
}
//generate report function
function disbursement_report()
{
  var date_from = $('#dis-from').val();
  var date_to = $('#dis-to').val();
  var action = 2;
  var myData = 'date_from=' + date_from + '&date_to=' + date_to + '&action=' + action;
  showToast();
  window.location = '../../controls/generate_report_fo.php?' + myData;
}
//generate report function
function percentage_report()
{
  var date_from = $('#percent-from').val();
  var date_to = $('#percent-to').val();
  var action = 3;
  var myData = 'date_from=' + date_from + '&date_to=' + date_to + '&action=' + action;
  showToast();
  window.location = '../../controls/generate_report_fo.php?' + myData;
}
</script>